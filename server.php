<?php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
$publicPath = __DIR__.DIRECTORY_SEPARATOR.'public';
$filePath = $publicPath.str_replace('/', DIRECTORY_SEPARATOR, $uri);

if ($uri !== '/' && file_exists($filePath)) {
    return false;
}

require_once $publicPath.DIRECTORY_SEPARATOR.'index.php';
