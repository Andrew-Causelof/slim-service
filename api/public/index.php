<?php

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Controllers\XLSExporter;

require __DIR__ . '/../../vendor/autoload.php';


$app = AppFactory::create();

$app->post('/api/xls', [XLSExporter::class, 'exportXls']);


$app->run();
