<?php
use app\Router;
use app\controllers\ProductController;

require_once __DIR__."/../vendor/autoload.php";
$router = new Router();

$router->get('/',[ProductController::class,"index"]);
$router->get('/products',[ProductController::class,"index"]);
$router->get('/edit',[ProductController::class,"edit"]);
$router->post('/edit',[ProductController::class,"edit"]);
$router->post('/delete',[ProductController::class,"delete"]);

// $router->post('/products/create',[ProductController::class,"create"]);
// $router->post('/products/delete',[ProductController::class,"delete"]);
$router->route();
