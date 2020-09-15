<?php
require_once '../vendor/autoload.php';

use Controllers\ProductController;
use Db\Database;
use Lib\Request;

$database = new Database;
$database->init();
$db = $database->getDbConnection();

$request = new Request;
$method = $request->method();
$resource = $request->resource();

if (!$resource) {
    header('HTTP/1.1 404 Not Found');
}

if ($resource[0] == 'products') {
    $product = new ProductController($db, $request);
    switch ($method) {
        case 'GET':
            $product->show();
            break;

        case 'POST':
            $product->store();
            break;

        case 'PUT':
            $product->update();
            break;

        case 'DELETE':
            $product->destroy();
            break;

        default:
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET, POST, PUT, DELETE');
            break;
    }
} else {
    header('HTTP/1.1 404 Not Found');
}
