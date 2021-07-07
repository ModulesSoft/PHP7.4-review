<?php 
namespace app\controllers;
use app\models\Product;
use app\Router;

class ProductController {

    public function index($arg){
        $search = $_GET['search'] ?? '';
        $product = new Product();
        $result = $product->getProducts($search);
        $router = new Router();
        $router->render('index',$result);

    }



}
