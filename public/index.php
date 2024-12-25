<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/routes.php';

$uri           = $_SERVER['PATH_INFO'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
$result        = route($uri, $requestMethod);

echo $result;
