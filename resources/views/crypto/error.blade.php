<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro | Crypto Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .error-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-card {
            max-width: 500px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-card card text-center">
            <div class="card-header bg-danger text-white">
                <h5><i class="bi bi-exclamation-triangle-fill"></i> Ocorreu um erro</h5>
            </div>
            <div class="card-body">
                <i class="bi bi-emoji-frown" style="font-size: 3rem; color: #dc3545;"></i>
                <h4 class="card-title mt-3">{{ $message ?? 'Erro desconhecido' }}</h4>
                <p class="card-text">Não foi possível carregar os dados do mercado de criptomoedas.</p>
                <a href="{{ url('/crypto') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-arrow-clockwise"></i> Tentar novamente
                </a>
            </div>
            <div class="card-footer text-muted">
                <small>Se o problema persistir, entre em contato com o suporte</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>