<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swagger API Documentation | JRS International School</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Swagger UI CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.11.0/swagger-ui.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #fafafa;
            color: #1e293b;
        }
        .header-bar {
            background: #031c3f;
            color: white;
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #e31e24;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header-bar h1 {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #ffffff;
        }
        .header-bar p {
            margin: 4px 0 0;
            font-size: 12px;
            color: #94a3b8;
        }
        /* Swagger UI Custom Styles */
        .swagger-ui .topbar { display: none !important; }
        .swagger-ui .information-container { padding: 24px 0; }
        .swagger-ui .scheme-container {
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 16px 0;
            margin-bottom: 24px;
            border-bottom: 1px solid #e2e8f0;
        }
        .swagger-ui .wrapper { max-width: 1380px; padding: 0 24px; }
        .swagger-ui .opblock { border-radius: 8px; overflow: hidden; margin: 0 0 12px; }
        .swagger-ui .btn.authorize {
            border-color: #031c3f;
            color: #031c3f;
        }
        .swagger-ui .btn.authorize svg {
            fill: #031c3f;
        }
    </style>
</head>
<body>
    <div class="header-bar">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="background: white; border-radius: 8px; padding: 4px 10px; display: flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                <img src="{{ asset('images/logo.png') }}" alt="JRS Logo" style="height: 32px; width: auto; object-fit: contain;">
            </div>
            <div>
                <h1>JRS International School — Swagger API Docs</h1>
                <p>Interactive OpenAPI 3.0 Documentation for Public & Admin REST Web Services</p>
            </div>
        </div>
    </div>

    <div id="swagger-ui"></div>

    <!-- Swagger UI JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.11.0/swagger-ui-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.11.0/swagger-ui-standalone-preset.min.js"></script>
    <script>
        window.onload = function() {
            @php
                $swaggerJsonFile = public_path('swagger.json');
                if (!file_exists($swaggerJsonFile)) {
                    $swaggerJsonFile = storage_path('api-docs/api-docs.json');
                }
                $specJson = file_exists($swaggerJsonFile) ? file_get_contents($swaggerJsonFile) : '{}';
            @endphp
            const spec = {!! $specJson !!};
            const ui = SwaggerUIBundle({
                spec: spec,
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout",
                displayRequestDuration: true,
                docExpansion: "list",
                filter: true,
                showExtensions: true,
                showCommonExtensions: true,
                persistAuthorization: true
            });
            window.ui = ui;
        };
    </script>
</body>
</html>
