<?php

use Slim\Factory\AppFactory;
use Api\Controllers\XLSExporter;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);


// === 1. CORS Middleware (перемещено в начало) ===
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);

    $origin = $request->getHeaderLine('Origin');

    if (!empty($origin)) {
        $response = $response
            ->withHeader('Access-Control-Allow-Origin', $origin) // Разрешить конкретный Origin
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->withHeader('Access-Control-Allow-Credentials', 'true'); // Должно быть `true`, если используется `withCredentials`
    }

    return $response;
});

// === 2. Обработчик OPTIONS ===
$app->options('/{routes:.+}', function ($request, $response, $args) {
    $origin = $request->getHeaderLine('Origin');

    if (!empty($origin)) {
        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withStatus(200);
    }

    return $response->withStatus(403);
});


// Авторизация
$app->post('/api/xls', [XLSExporter::class, 'exportXls']);

$app->run();
