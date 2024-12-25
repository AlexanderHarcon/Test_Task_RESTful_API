<?php

use App\Controllers\ProductController;

function route($uri, $requestMethod)
{
    $routes = [
        '/findItem' => [ProductController::class, 'findItem', 'GET'],
        '/updateItem' => [ProductController::class, 'updateItem', 'PUT'],
        '/deleteItem' => [ProductController::class, 'deleteItem', 'DELETE'],
        '/addItem' => [ProductController::class, 'addItem', 'POST'],
    ];


    if (isset($routes[$uri])) {

        $values     = $routes[$uri];
        $controller = $values[0];
        $method     = $values[1];

        if ($requestMethod !== $values[2]) {
            http_response_code(405); // Method Not Allowed
            return json_encode(['error' => 'Method Not Allowed. Use ' . $values[2] . ' instead.']);
        }

        http_response_code(200);
        return (new $controller)->$method();
    }

    http_response_code(404);
    return json_encode(['error' => 'Method Not Found.']);
}