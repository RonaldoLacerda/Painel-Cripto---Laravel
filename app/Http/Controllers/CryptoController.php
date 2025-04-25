<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\Log;

class CryptoController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('COINMARKETCAP_API_KEY');
        
        if (empty($this->apiKey)) {
            Log::error('CoinMarketCap API key not configured');
            throw new \Exception('API key não configurada. Verifique seu arquivo .env');
        }
    }

    public function index()
    {
        $client = new Client([
            'timeout' => 30, // aumente o timeout
            'connect_timeout' => 15,
            'headers' => [
                'X-CMC_PRO_API_KEY' => $this->apiKey,
                'Accept' => 'application/json',
            ],
            'http_errors' => false
        ]);
        
        try {
            $response = $client->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
                'query' => [
                    'start' => 1,
                    'limit' => 10,
                    'convert' => 'USD',
                    'sort' => 'market_cap',
                    'sort_dir' => 'desc'
                ]
            ]);
            

            // Verifica se a resposta foi bem sucedida
            if ($response->getStatusCode() !== 200) {
                $errorBody = $response->getBody()->getContents();
                Log::error('API Error', [
                    'status' => $response->getStatusCode(),
                    'body' => $errorBody,
                    'headers' => $response->getHeaders()
                ]);
                throw new \Exception("Erro na API: " . $errorBody);
            }

            $data = json_decode($response->getBody(), true);
            
            if (!isset($data['data'])) {
                Log::error('CoinMarketCap API Response Missing Data: ' . json_encode($data));
                throw new \Exception("Formato de dados inesperado da API");
            }

            $cryptos = array_map(function($item) {
                if (!isset($item['quote']['USD'])) {
                    Log::error('Missing USD quote for: ' . $item['symbol']);
                    return null;
                }
                
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'symbol' => $item['symbol'],
                    'current_price' => $item['quote']['USD']['price'],
                    'price_change_percentage_24h' => $item['quote']['USD']['percent_change_24h'],
                    'price_change_percentage_7d' => $item['quote']['USD']['percent_change_7d'],
                    'market_cap' => $item['quote']['USD']['market_cap'],
                    'total_volume' => $item['quote']['USD']['volume_24h'],
                    'image' => $this->getCryptoImage($item['id']),
                    'sparkline_in_7d' => $this->getSparklineData($item['id'])
                ];
            }, $data['data']);

            // Remove possíveis itens nulos
            $cryptos = array_filter($cryptos);

            if (empty($cryptos)) {
                throw new \Exception("Nenhum dado válido retornado pela API");
            }
            $globalMetrics = $client->get('https://pro-api.coinmarketcap.com/v1/global-metrics/quotes/latest');
            $globalData = json_decode($globalMetrics->getBody(), true)['data'];
            
            $news = $this->getNews();
            // Criação do gráfico
            $chart = $this->createChart($cryptos);
            $gainersResponse = $client->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
                'query' => [
                    'start' => 1,
                    'limit' => 5,
                    'convert' => 'USD',
                    'sort' => 'percent_change_24h',
                    'sort_dir' => 'desc',
                    'percent_change_24h_min' => 0.1
                ]
            ]);
            
            $gainersData = json_decode($gainersResponse->getBody(), true);
            
            $topGainers = array_map(function($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'symbol' => $item['symbol'],
                    'price_change_percentage_24h' => $item['quote']['USD']['percent_change_24h'],
                    'image' => $this->getCryptoImage($item['id'])
                ];
            }, $gainersData['data']);
            $topGainers = array_filter($topGainers, function($item) {
                return $item['price_change_percentage_24h'] > 0;
            });

            return view('crypto.index', [
                'cryptos' => $cryptos,
                'chart' => $chart,
                'global' => $globalData,
                'news' => $news,
                'topGainers' => $topGainers
            ]);
            
            
        } catch (\Exception $e) {
            Log::error('Erro completo', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return view('crypto.error', [
                'message' => 'Erro detalhado: ' . $e->getMessage()
            ]);
        }
    }
    public function getCryptos(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = 10;
        $start = ($page - 1) * $limit + 1;

        $client = new Client([
            'headers' => [
                'X-CMC_PRO_API_KEY' => $this->apiKey,
                'Accept' => 'application/json',
            ]
        ]);

        try {
            $response = $client->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
                'query' => [
                    'start' => $start,
                    'limit' => $limit,
                    'convert' => 'USD',
                    'sort' => 'market_cap',
                    'sort_dir' => 'desc'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            
            $cryptos = array_map(function($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'symbol' => $item['symbol'],
                    'current_price' => $item['quote']['USD']['price'],
                    'price_change_percentage_24h' => $item['quote']['USD']['percent_change_24h'],
                    'price_change_percentage_7d' => $item['quote']['USD']['percent_change_7d'],
                    'market_cap' => $item['quote']['USD']['market_cap'],
                    'total_volume' => $item['quote']['USD']['volume_24h'],
                    'image' => $this->getCryptoImage($item['id'])
                ];
            }, $data['data']);

            return response()->json([
                'cryptos' => $cryptos,
                'total' => $data['status']['total_count'],
                'current_page' => $page
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getNews()
{
    $client = new Client([
        'timeout' => 10,
        'http_errors' => false
    ]);
    
    try {
        // Primeiro tentamos em inglês (mais resultados)
        $response = $client->get('https://newsapi.org/v2/everything', [
            'query' => [
                'q' => 'crypto OR cryptocurrency OR bitcoin OR ethereum',
                'apiKey' => env('NEWS_API_KEY'),
                'pageSize' => 6,
                'sortBy' => 'publishedAt',
                'language' => 'en' // Inglês tem mais conteúdo
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        
        // Se não encontrar em inglês, tenta sem filtro de linguagem
        if ($response->getStatusCode() !== 200 || empty($data['articles'])) {
            $response = $client->get('https://newsapi.org/v2/everything', [
                'query' => [
                    'q' => 'crypto OR cryptocurrency',
                    'apiKey' => env('NEWS_API_KEY'),
                    'pageSize' => 6
                ]
            ]);
            $data = json_decode($response->getBody(), true);
        }

        // Se ainda sem resultados, tenta headlines internacionais
        if (empty($data['articles'])) {
            $response = $client->get('https://newsapi.org/v2/top-headlines', [
                'query' => [
                    'category' => 'business',
                    'apiKey' => env('NEWS_API_KEY'),
                    'pageSize' => 6
                ]
            ]);
            $data = json_decode($response->getBody(), true);
        }

        return $data['articles'] ?? [];

    } catch (\Exception $e) {
        Log::error('Error fetching news: '.$e->getMessage());
        return [];
    }
}

    private function getCryptoImage($id)
    {
        return "https://s2.coinmarketcap.com/static/img/coins/64x64/{$id}.png";
    }

    private function getSparklineData($id)
    {
        $client = new Client([
            'headers' => [
                'X-CMC_PRO_API_KEY' => $this->apiKey,
                'Accept' => 'application/json',
            ]
        ]);

        try {
            $response = $client->get("https://pro-api.coinmarketcap.com/v2/cryptocurrency/ohlcv/historical", [
                'query' => [
                    'id' => $id,
                    'time_period' => '7d',
                    'interval' => 'daily'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return array_column($data['data'][$id]['quotes'], 'quote.USD.close');

        } catch (\Exception $e) {
            Log::error('Error fetching sparkline: '.$e->getMessage());
            return $this->generateSparklineData(); // Fallback para dados fictícios
        }
    }


    private function generateSparklineData()
    {
        return array_map(function() {
            return rand(25000, 35000) / 100; // Valores entre 250 e 350
        }, range(1, 24));
    }

    private function createChart($cryptos)
    {
        $chart = new Chart;
        
        // Configuração básica do gráfico
        $chart->title('Variação de Preço (24h)');
        $chart->labels(array_map(function($i) {
            return date('H:i', strtotime("+{$i} hours"));
        }, range(0, 23)));

        // Dataset Bitcoin
        $chart->dataset('Bitcoin', 'line', $this->generateSparklineData())
            ->color('#f7931a')
            ->backgroundcolor('rgba(247, 147, 26, 0.1)')
            ->fill(true)
            ->linetension(0.4);

        // Dataset Ethereum
        $chart->dataset('Ethereum', 'line', $this->generateSparklineData())
            ->color('#627eea')
            ->backgroundcolor('rgba(98, 126, 234, 0.1)')
            ->fill(true)
            ->linetension(0.4);

        // Opções adicionais
        $chart->options([
            'responsive' => true,
            'maintainAspectRatio' => false,
            'tooltips' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'scales' => [
                'xAxes' => [
                    [
                        'gridLines' => [
                            'display' => false
                        ]
                    ]
                ],
                'yAxes' => [
                    [
                        'gridLines' => [
                            'display' => true,
                            'color' => 'rgba(0, 0, 0, 0.05)'
                        ]
                    ]
                ]
            ]
        ]);

        return $chart;
    }
}