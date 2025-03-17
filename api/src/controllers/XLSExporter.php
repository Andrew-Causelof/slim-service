<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class XLSExporter
{
    public static function exportXls(Request $request, Response $response, array $args)
    {
        $name = $args['name'];
        $response->getBody()->write("Привет, $name!");
        return $response;
    }
}
