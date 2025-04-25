📊 Painel-Cripto - Laravel
📌 Visão Geral
O Painel Cripto é uma aplicação web desenvolvida com Laravel que fornece informações em tempo real sobre o mercado de criptomoedas. Ele consome dados da API CoinMarketCap para exibir informações detalhadas sobre cotações, variações percentuais, capitalização de mercado e volume das principais criptomoedas. Além disso, a aplicação apresenta notícias atualizadas do setor de criptomoedas.

🛠 Tecnologias Utilizadas
Backend
PHP: Linguagem de programação utilizada para o desenvolvimento.

Laravel: Framework PHP utilizado para estruturar a aplicação.

GuzzleHTTP: Cliente HTTP utilizado para fazer chamadas à API externa.

ConsoleTVs/Charts: Biblioteca para geração de gráficos dinâmicos.

Frontend
Bootstrap 5: Framework CSS para construção de layouts responsivos e modernos.

Chart.js: Biblioteca JavaScript para visualização de dados em gráficos.

Font Awesome: Biblioteca de ícones vetoriais.

Vanilla JavaScript: Para manipulação do DOM e chamadas AJAX.

🔗 APIs Integradas
CoinMarketCap API: Fornece dados atualizados sobre criptomoedas (cotações, capitalização de mercado, volume, etc.).

NewsAPI: Integração para obter notícias sobre criptomoedas.

MyMemory Translation API: API usada para traduzir notícias sobre criptomoedas.


----
Página Inicial: resources/views/crypto/index.blade.php
Controller: app/Http/Controllers/CryptoController.php
