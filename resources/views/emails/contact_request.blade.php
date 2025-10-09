<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>Новая заявка</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            color: #111827;
        }

        .box {
            max-width: 560px;
            margin: 0 auto;
            padding: 16px;
        }

        .muted {
            color: #6b7280;
            font-size: 12px;
        }

        .row {
            margin: 8px 0;
        }

        .label {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="box">
        <h2>Новая заявка с сайта</h2>
        <div class="row"><span class="label">Имя:</span> {{ $data['name'] ?? '-' }}</div>
        <div class="row"><span class="label">Телефон:</span> {{ $data['phone'] ?? '-' }}</div>
        <div class="row"><span class="label">Телефон (нормализованный):</span> +{{ $data['phone_normalized'] ?? '-' }}
        </div>
        <div class="row"><span class="label">Желаемая дата:</span> {{ $data['date'] ?? '-' }}</div>
        <hr>
        <p class="muted">Отправлено: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>

</html>
