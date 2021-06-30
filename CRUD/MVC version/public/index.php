<?php
use app\Router;
use app\ProductController;

$router = new Router();

$router->get('/',[ProductController::class,"index"]);
$router->get('/products',[ProductController::class,"index"]);
// $router->post('/products/create',[ProductController::class,"create"]);
// $router->post('/products/delete',[ProductController::class,"delete"]);

