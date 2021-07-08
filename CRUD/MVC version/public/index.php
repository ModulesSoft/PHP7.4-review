<?php
use app\Router;
use app\controllers\ProductController;

require_once __DIR__."/../vendor/autoload.php";
$router = new Router();

$router->get('/',[ProductController::class,"index"]);
$router->get('/products',[ProductController::class,"index"]);
$router->get('/products/edit',[ProductController::class,"edit"]);
$router->post('/products/edit',[ProductController::class,"edit"]);
$router->post('/products/delete',[ProductController::class,"delete"]);
$router->get('/products/create',[ProductController::class,"create"]);
$router->post('/products/create',[ProductController::class,"create"]);
$router->route();
