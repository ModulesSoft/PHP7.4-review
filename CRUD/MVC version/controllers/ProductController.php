<?php 
namespace app\controllers;
class ProductController {

    public function index($arg){
        echo "index page";
        echo '<pre>';
        var_dump($arg);
        echo '</pre>';
    }



}
