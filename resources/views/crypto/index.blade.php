<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Cripto | Análise de Mercado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/a/a2/Bitcoin.svg" type="image/x-icon">
    <style>
        :root {
            --cor-primaria: #6c5ce7;
            --cor-secundaria: #a29bfe;
            --cor-escura: #2d3436;
            --cor-clara: #f5f6fa;
            --cor-sucesso: #00b894;
            --cor-perigo: #d63031;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: var(--cor-escura);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--cor-primaria) !important;
        }
        
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            border: none;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background-color: var(--cor-primaria);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }
        
        .positivo, .texto-positivo {
            color: var(--cor-sucesso) !important;
        }

        .icone-positivo {
            color: var(--cor-sucesso);
            font-weight: bold;
        }
        
        .negativo, .texto-negativo {
            color: var(--cor-perigo) !important;
        }

        .icone-negativo {
            color: var(--cor-perigo);
            font-weight: bold;
        }
        
        .icone-cripto {
            width: 32px;
            height: 32px;
            margin-right: 10px;
        }
        
        .capitalizacao-mercado {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .volume {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .container-grafico {
            height: 300px;
            position: relative;
        }
        
        .badge-tendencia {
            background-color: var(--cor-secundaria);
            color: white;
        }
        
        .caixa-busca {
            position: relative;
        }
        
        .caixa-busca i {
            position: absolute;
            top: 12px;
            left: 15px;
            color: #6c757d;
        }
        
        .caixa-busca input {
            padding-left: 40px;
            border-radius: 20px;
            border: 1px solid #dee2e6;
        }
        .paginacao .pagina-item {
            margin: 0 2px;
        }
        .paginacao .link-pagina {
            border-radius: 8px !important;
            min-width: 38px;
            text-align: center;
        }
        .paginacao .pagina-item.ativo .link-pagina {
            background-color: var(--cor-primaria);
            border-color: var(--cor-primaria);
        }
        .paginacao .pagina-item:not(.ativo) .link-pagina:hover {
            background-color: var(--cor-secundaria);
            color: white;
        }
        @media (max-width: 992px) {
            .tabela-responsiva {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .tabela td, .tabela th {
                white-space: nowrap;
            }
            .icone-cripto {
                width: 24px;
                height: 24px;
            }
        }

       /* Estilo da Paginação */
        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 10px 0;
            align-items: center;
        }

        .pagination .page-item {
            margin: 0;
            transition: all 0.3s ease;
        }

        .pagination .page-link {
            border-radius: 10px !important;
            min-width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: 2px solid var(--cor-secundaria);
            background-color: white;
            color: var(--cor-primaria);
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--cor-primaria);
            border-color: var(--cor-primaria);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(108, 92, 231, 0.2);
        }

        .pagination .page-item:not(.active):not(.disabled) .page-link:hover {
            background-color: var(--cor-secundaria);
            color: white;
            border-color: var(--cor-secundaria);
            transform: translateY(-2px);
        }

        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #f8f9fa;
            border-color: #e9ecef;
        }

        .pagination .page-item .page-link i {
            font-size: 1.1rem;
        }

        /* Efeito especial para os botões de navegação */
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            padding: 0 12px;
            background-color: var(--cor-primaria);
            color: white;
            border-color: var(--cor-primaria);
        }

        .pagination .page-item:first-child.disabled .page-link,
        .pagination .page-item:last-child.disabled .page-link {
            background-color: #e9ecef;
            border-color: #dee2e6;
            color: #adb5bd;
        }
        .table-hover tbody tr td.positivo {
            color: var(--cor-sucesso);
        }

        .table-hover tbody tr td.negativo {
            color: var(--cor-perigo);
        }
        #translate-btn {
            transition: all 0.3s ease;
        }

        #translate-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(108, 92, 231, 0.3);
        }

        .news-title {
            cursor: pointer;
            transition: color 0.2s;
        }

        .news-title:hover {
            color: var(--cor-primaria);
        }
    </style>
</head>
<body>
    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-currency-bitcoin me-2"></i>Painel Cripto
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#visao-geral">Indicadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#noticias">Notícias</a>
                    </li>
                </ul>
                <div class="caixa-busca">
                    <i class="bi bi-search"></i>
                    <input id="caixa-busca" class="form-control me-2" type="search" placeholder="Buscar criptomoeda...">
                </div>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <!-- Visão Geral do Mercado -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Visão Geral do Mercado</span>
                        <small class="text-white-50">Atualizado em: {{ now()->format('d/m/Y H:i') }}</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h5 class="card-title">Capitalização de Mercado</h5>
                                <p class="h4 text-primary">${{ number_format($global['quote']['USD']['total_market_cap'] / 1e12, 2) }}T</p>
                                <small class="text-muted {{ $global['quote']['USD']['total_market_cap_yesterday_percentage_change'] >= 0 ? 'positivo' : 'negativo' }}">
                                    {{ number_format($global['quote']['USD']['total_market_cap_yesterday_percentage_change'], 2) }}% (24h)
                                </small>
                            </div>
                            <div class="col-md-3">
                                <h5 class="card-title">Volume (24h)</h5>
                                <p class="h4 text-primary">${{ number_format($global['quote']['USD']['total_volume_24h'] / 1e9, 2) }}B</p>
                                <small class="text-muted {{ $global['quote']['USD']['total_volume_24h_yesterday_percentage_change'] >= 0 ? 'positivo' : 'negativo' }}">
                                    {{ number_format($global['quote']['USD']['total_volume_24h_yesterday_percentage_change'], 2) }}% (24h)
                                </small>
                            </div>
                            <div class="col-md-3">
                                <h5 class="card-title">Dominação do Bitcoin</h5>
                                <p class="h4 text-primary">{{ number_format($global['btc_dominance'], 1) }}%</p>
                            </div>
                            <div class="col-md-3">
                                <h5 class="card-title">Dominação do Ethereum</h5>
                                <p class="h4 text-primary">{{ number_format($global['eth_dominance'], 1) }}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Tabela Principal de Criptomoedas -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Criptomoedas</span>
                        <div>
                            <button class="btn btn-sm btn-outline-primary me-2">Top 100</button>
                            <button class="btn btn-sm btn-outline-secondary">Maiores Ganhos</button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="tabela-responsiva">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">#</th>
                                        <th>Nome</th>
                                        <th class="text-end">Preço</th>
                                        <th class="text-end">24h %</th>
                                        <th class="text-end">7d %</th>
                                        <th class="text-end">Capitalização</th>
                                        <th class="text-end mr-3">Volume (24h)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($cryptos as $crypto)
                                    <tr>
                                        <td class="ps-4">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $crypto['image'] }}" alt="{{ $crypto['name'] }}" class="icone-cripto">
                                                <div>
                                                    <strong>{{ $crypto['name'] }}</strong>
                                                    <div class="capitalizacao-mercado">{{ strtoupper($crypto['symbol']) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">${{ number_format($crypto['current_price'], 2) }}</td>
                                        <td class="text-end {{ $crypto['price_change_percentage_24h'] >= 0 ? 'positivo' : 'negativo' }}">
                                            {{ number_format($crypto['price_change_percentage_24h'], 2) }}%
                                            @if($crypto['price_change_percentage_24h'] >= 0)
                                                <i class="bi bi-arrow-up"></i>
                                            @else
                                                <i class="bi bi-arrow-down"></i>
                                            @endif
                                        </td>
                                        <td class="text-end {{ $crypto['price_change_percentage_7d'] >= 0 ? 'positivo' : 'negativo' }}">
                                            {{ number_format($crypto['price_change_percentage_7d'], 2) }}%
                                            @if($crypto['price_change_percentage_7d'] >= 0)
                                                <i class="bi bi-arrow-up"></i>
                                            @else
                                                <i class="bi bi-arrow-down"></i>
                                            @endif
                                        </td>
                                        <td class="text-end">${{ number_format($crypto['market_cap'], 0) }}</td>
                                        <td class="text-end mr-3">${{ number_format($crypto['total_volume'], 0) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <nav aria-label="Navegação de páginas">
                            <ul class="pagination justify-content-center mb-0" id="container-paginacao">
                                <!-- A paginação será injetada aqui pelo JavaScript -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Barra Lateral com Gráficos e Tendências -->
            <div class="col-md-4">
                <!-- Gráfico de Preços -->
                <!-- <div class="card mb-4">
                    <div class="card-header">
                        Variação de Preço (24h)
                    </div>
                    <div class="card-body">
                        <div class="container-grafico">
                            @if(isset($chart))
                                {!! $chart->container() !!}
                                {!! $chart->script() !!}
                            @else
                                <div class="alert alert-warning">
                                    Gráfico não disponível no momento
                                </div>
                            @endif
                        </div>
                    </div>
                </div> -->

                <!-- Criptomoedas em Alta -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-fire me-2"></i>Top Valorizações (24h)
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($topGainers as $gainer)
                            @php
                                $classe = $gainer['price_change_percentage_24h'] >= 0 ? 'texto-positivo' : 'texto-negativo';
                                $icone = $gainer['price_change_percentage_24h'] >= 0 ? 'bi-arrow-up' : 'bi-arrow-down';
                            @endphp
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $gainer['image'] }}" alt="{{ $gainer['name'] }}" class="icone-cripto">
                                    <div>
                                        <strong>{{ $gainer['name'] }}</strong>
                                        <div class="capitalizacao-mercado">{{ strtoupper($gainer['symbol']) }}</div>
                                    </div>
                                </div>
                                <span class="d-flex align-items-center {{ $classe }}">
                                    {{ number_format($gainer['price_change_percentage_24h'], 2) }}%
                                    <i class="bi {{ $icone }} ms-1"></i>
                                </span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <small class="text-muted">Atualizado em: {{ now()->format('H:i:s') }}</small>
                    </div>
                </div>

                <!-- Notícias do Mercado -->
                <div class="card" id="noticias">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-newspaper me-2"></i>Últimas Notícias
                        </div>
                        <small class="text-white-50">Atualizado: {{ now()->format('H:i') }}</small>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 g-3" id="news-container">
                        @forelse($news as $article)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm news-card">
                                <div class="card-body">
                                    <h6 class="news-title card-title fw-bold" data-original="{{ $article['title'] ?? '' }}">
                                        {{ Str::limit($article['title'] ?? 'Sem título', 65) }}
                                    </h6>
                                    <div class="mt-2">
    <div class="text-muted mb-1">
        <i class="bi bi-clock-history me-1"></i>
        {{ isset($article['publishedAt']) ? \Carbon\Carbon::parse($article['publishedAt'])->format('d/m - H:i') : 'Data desconhecida' }}
    </div>

    <div class="text-muted">
        {{ $article['source']['name'] ?? 'Fonte desconhecida' }}
    </div>
</div>
                                    <a href="{{ $article['url'] ?? '#' }}" target="_blank" 
                                    class="btn btn-sm btn-outline-primary mt-2 w-100">
                                        Ler notícia completa
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-warning mb-0">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Nenhuma notícia recente encontrada. Por favor, tente novamente mais tarde.
                            </div>
                        </div>
                        @endforelse
                            @if(count($news) > 0)
                            <div class="col-12 mt-3">
                                <small class="text-muted">
                                    Mostrando {{ count($news) }} notícias atualizadas
                                </small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-currency-bitcoin"></i> Painel Cripto</h5>
                    <p class="text-muted">Acompanhe o mercado de criptomoedas em tempo real com dados precisos e análises detalhadas.</p>
                </div>
                <div class="col-md-3">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted">Mercado</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Portfólio</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Notícias</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contato</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted"><i class="bi bi-envelope me-2"></i>contato@painelcripto.com</a></li>
                        <li><a href="#" class="text-decoration-none text-muted"><i class="bi bi-twitter me-2"></i>@painelcripto</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="row">
                <div class="col-md-12 text-center text-muted">
                    <small>© 2023 Painel Cripto. Todos os direitos reservados. Dados fornecidos por CoinGecko API.</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-trendline"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
    {!! $chart->script() !!}
    
    <script>
        // Gráficos sparkline para tendências de 7 dias
        document.querySelectorAll('.sparkline').forEach(canvas => {
            const valores = JSON.parse(canvas.dataset.values);
            new Chart(canvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: Array(valores.length).fill(''),
                    datasets: [{
                        data: valores,
                        borderColor: valores[0] <= valores[valores.length-1] ? 'var(--cor-perigo)' : 'var(--cor-sucesso)',
                        borderWidth: 1,
                        fill: false,
                        tension: 0.4
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { x: { display: false }, y: { display: false } }
                }
            });
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            const campoBusca = document.getElementById('caixa-busca');
            let todasCriptos = [];
            // Rolagem suave para âncoras
            document.querySelectorAll('a[href^="#"]').forEach(ancora => {
                ancora.addEventListener('click', function(e) {
                    e.preventDefault();
                    const alvo = document.querySelector(this.getAttribute('href'));
                    if (alvo) {
                        alvo.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Botões Top 100 e Maiores Ganhos
            const botaoTop100 = document.querySelector('.btn-outline-primary');
            const botaoGanhos = document.querySelector('.btn-outline-secondary');
            
            if (botaoTop100 && botaoGanhos) {
                botaoTop100.addEventListener('click', function() {
                    alert('Mostrando Top 100 criptomoedas');
                });
                
                botaoGanhos.addEventListener('click', function() {
                    alert('Mostrando criptomoedas com maiores ganhos');
                });
            }
        

            carregarCriptomoedas(1);
        });
        
        document.getElementById('caixa-busca').addEventListener('input', function() {
                const termo = this.value.toLowerCase();

                if (!todasCriptos.length) return; // ainda não carregou nada

                if (termo === '') {
                    // Se o campo está vazio, recarrega tudo normalmente
                    atualizarTabela(todasCriptos, 1);
                    atualizarPaginacao(1, Math.ceil(todasCriptos.length / 10));
                } else {
                    const criptosFiltradas = todasCriptos.filter(c =>
                        c.name.toLowerCase().includes(termo) ||
                        c.symbol.toLowerCase().includes(termo)
                    );
                    atualizarTabela(criptosFiltradas, 1);
                    atualizarPaginacao(1, Math.ceil(criptosFiltradas.length / 10));
                }
            });


        // Função para carregar criptomoedas
        function carregarCriptomoedas(pagina = 1) {
            // Mostra o indicador de carregamento
            const carregando = document.createElement('div');
            carregando.className = 'text-center py-4';
            carregando.innerHTML = `
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
            `;
            
            const corpoTabela = document.querySelector('table tbody');
            corpoTabela.parentNode.insertBefore(carregando, corpoTabela);
            corpoTabela.style.opacity = '0.5';
            
            fetch(`/cryptos?page=${pagina}`)
                .then(resposta => {
                    if (!resposta.ok) throw new Error('Erro na rede');
                    return resposta.json();
                })
                .then(dados => {
                    if (dados.error) {
                        throw new Error(dados.error);
                    }
                    todasCriptos = dados.cryptos;
                    // Atualiza a tabela
                    atualizarTabela(dados.cryptos, pagina);
                    
                    // Atualiza a paginação
                    atualizarPaginacao(pagina, Math.ceil(dados.total / 10));
                })
                .catch(erro => {
                    console.error('Erro:', erro);
                    alert('Erro ao carregar dados: ' + erro.message);
                })
                .finally(() => {
                    // Remove o indicador de carregamento
                    if (carregando.parentNode) carregando.parentNode.removeChild(carregando);
                    corpoTabela.style.opacity = '1';
                });
        }

        // Função para atualizar a tabela
        function atualizarTabela(criptomoedas, paginaAtual) {
            const corpoTabela = document.querySelector('table tbody');
            corpoTabela.innerHTML = '';
            
            criptomoedas.forEach((cripto, indice) => {
                const linha = document.createElement('tr');
                
                // Determina as classes com base no valor
                const classe24h = cripto.price_change_percentage_24h >= 0 ? 'positivo' : 'negativo';
                const classe7d = cripto.price_change_percentage_7d >= 0 ? 'positivo' : 'negativo';
                const icone24h = cripto.price_change_percentage_24h >= 0 ? 'bi-arrow-up' : 'bi-arrow-down';
                const icone7d = cripto.price_change_percentage_7d >= 0 ? 'bi-arrow-up' : 'bi-arrow-down';
                
                linha.innerHTML = `
                    <td class="ps-4">${(paginaAtual - 1) * 10 + indice + 1}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="${cripto.image}" alt="${cripto.name}" class="icone-cripto">
                            <div>
                                <strong>${cripto.name}</strong>
                                <div class="capitalizacao-mercado">${cripto.symbol.toUpperCase()}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-end">$${cripto.current_price.toFixed(2)}</td>
                    <td class="text-end ${classe24h}">
                        ${cripto.price_change_percentage_24h.toFixed(2)}%
                        <i class="bi ${icone24h} icone-${classe24h} ms-1"></i>
                    </td>
                    <td class="text-end ${classe7d}">
                        ${cripto.price_change_percentage_7d.toFixed(2)}%
                        <i class="bi ${icone7d} icone-${classe7d} ms-1"></i>
                    </td>
                    <td class="text-end">$${cripto.market_cap.toLocaleString()}</td>
                    <td class="text-end">$${cripto.total_volume.toLocaleString()}</td>
                `;
                corpoTabela.appendChild(linha);
            });
        }

        // Função para atualizar a paginação
        function atualizarPaginacao(paginaAtual, totalPaginas) {
            const paginacao = document.getElementById('container-paginacao');
            if (!paginacao) return;
            
            paginacao.innerHTML = '';
            
            // Botão Anterior
            const liAnterior = document.createElement('li');
            liAnterior.className = `page-item ${paginaAtual === 1 ? 'disabled' : ''}`;
            liAnterior.innerHTML = `
                <a class="page-link" href="#" aria-label="Anterior">
                    <i class="bi bi-chevron-left"></i>
                </a>
            `;
            liAnterior.addEventListener('click', (e) => {
                e.preventDefault();
                if (paginaAtual > 1) carregarCriptomoedas(paginaAtual - 1);
            });
            paginacao.appendChild(liAnterior);
            
            // Páginas
            let paginaInicial = Math.max(1, paginaAtual - 2);
            let paginaFinal = Math.min(totalPaginas, paginaAtual + 2);
            
            // Ajusta se estiver no início
            if (paginaAtual <= 3) {
                paginaFinal = Math.min(5, totalPaginas);
            }
            // Ajusta se estiver no final
            else if (paginaAtual >= totalPaginas - 2) {
                paginaInicial = Math.max(totalPaginas - 4, 1);
            }
            
            // Primeira página
            if (paginaInicial > 1) {
                const liPrimeira = document.createElement('li');
                liPrimeira.className = 'page-item';
                liPrimeira.innerHTML = `<a class="page-link" href="#">1</a>`;
                liPrimeira.addEventListener('click', (e) => {
                    e.preventDefault();
                    carregarCriptomoedas(1);
                });
                paginacao.appendChild(liPrimeira);
                
                if (paginaInicial > 2) {
                    const liReticencias = document.createElement('li');
                    liReticencias.className = 'page-item disabled';
                    liReticencias.innerHTML = `<span class="page-link">...</span>`;
                    paginacao.appendChild(liReticencias);
                }
            }
            
            // Páginas intermediárias
            for (let i = paginaInicial; i <= paginaFinal; i++) {
                const liPagina = document.createElement('li');
                liPagina.className = `page-item ${i === paginaAtual ? 'active' : ''}`;
                liPagina.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                liPagina.addEventListener('click', (e) => {
                    e.preventDefault();
                    carregarCriptomoedas(i);
                });
                paginacao.appendChild(liPagina);
            }
            
            // Última página
            if (paginaFinal < totalPaginas) {
                if (paginaFinal < totalPaginas - 1) {
                    const liReticencias = document.createElement('li');
                    liReticencias.className = 'page-item disabled';
                    liReticencias.innerHTML = `<span class="page-link">...</span>`;
                    paginacao.appendChild(liReticencias);
                }
                
                const liUltima = document.createElement('li');
                liUltima.className = 'page-item';
                liUltima.innerHTML = `<a class="page-link" href="#">${totalPaginas}</a>`;
                liUltima.addEventListener('click', (e) => {
                    e.preventDefault();
                    carregarCriptomoedas(totalPaginas);
                });
                paginacao.appendChild(liUltima);
            }
            
            // Botão Próximo
            const liProximo = document.createElement('li');
            liProximo.className = `page-item ${paginaAtual === totalPaginas ? 'disabled' : ''}`;
            liProximo.innerHTML = `
                <a class="page-link" href="#" aria-label="Próximo">
                    <i class="bi bi-chevron-right"></i>
                </a>
            `;
            liProximo.addEventListener('click', (e) => {
                e.preventDefault();
                if (paginaAtual < totalPaginas) carregarCriptomoedas(paginaAtual + 1);
            });
            paginacao.appendChild(liProximo);
        }

        // Função para traduzir notícias usando MyMemory API
        async function translateNews() {
            const newsCards = document.querySelectorAll('.news-card');
            const translateBtn = document.getElementById('translate-btn');
            
            if (!translateBtn) return;
            
            // Mostra status de carregamento
            translateBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Traduzindo...';
            translateBtn.disabled = true;
            
            try {
                for (const card of newsCards) {
                    const titleElement = card.querySelector('.news-title');
                    const originalTitle = titleElement.dataset.original || titleElement.textContent;
                    
                    // Só traduz se for inglês (evita retraduzir)
                    if (/[a-zA-Z]/.test(originalTitle)) {
                        const response = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(originalTitle)}&langpair=en|pt`);
                        const data = await response.json();
                        
                        if (data.responseData && data.responseData.translatedText) {
                            titleElement.textContent = data.responseData.translatedText;
                            titleElement.dataset.original = originalTitle; // Guarda original
                        }
                    }
                }
                
                translateBtn.innerHTML = '<i class="bi bi-check-circle"></i> Traduzido';
                setTimeout(() => {
                    translateBtn.innerHTML = '<i class="bi bi-translate"></i> Traduzir Notícias';
                    translateBtn.disabled = false;
                }, 2000);
                
            } catch (error) {
                console.error('Erro na tradução:', error);
                translateBtn.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Erro';
                setTimeout(() => {
                    translateBtn.innerHTML = '<i class="bi bi-translate"></i> Tentar Novamente';
                    translateBtn.disabled = false;
                }, 2000);
            }
        }

        // Adiciona botão de tradução dinamicamente
        function addTranslateButton() {
            const newsSection = document.querySelector('#noticias');
            if (!newsSection || document.getElementById('translate-btn')) return;
            
            const button = document.createElement('button');
            button.id = 'translate-btn';
            button.className = 'btn btn-sm btn-primary mb-3';
            button.innerHTML = '<i class="bi bi-translate"></i> Traduzir Notícias';
            button.onclick = translateNews;
            
            newsSection.insertAdjacentElement('afterbegin', button);
        }

        // Executa quando a página carrega
        document.addEventListener('DOMContentLoaded', function() {
            addTranslateButton();
            
            // Adiciona evento aos cards de notícia
            document.querySelectorAll('.news-card').forEach(card => {
                const title = card.querySelector('.news-title');
                if (title && !title.dataset.original) {
                    title.dataset.original = title.textContent; // Armazena original
                }
            });
        });
    </script>
</body>
</html>