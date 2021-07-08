<?php

namespace app;

use app\Database;
use app\controllers\ProductController;
use app\views\products;

class Router
{
    // public ?Database $db;
    public $getList = [];
    public $postList = [];
    function __construct()
    {
        // $this->db = new Database();
    }
    public function get($url, $params)
    {
        $this->getList[$url] = $params;
    }
    public function post($url, $params)
    {
        $this->postList[$url] = $params;
    }
    public function route()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $url = $_SERVER['PATH_INFO'] ?? '/';
        switch ($method) {
            case "GET":
                $fn = $this->getList[$url] ?? null;
                break;
            case "POST":
                $fn = $this->postList[$url] ?? null;
                break;
            default:
                $fn = null;
        }
        if(!$fn){
            http_response_code(404);
            die('Page not found - 404');
        }else{
            call_user_func($fn,$uri);
        }
        // $url = $_SERVER[]
    }
    public function render($view, $data)
    {
        // foreach ($data as $key => $value) {
        //     $$key = $value;
        // }
        // ob_start();
        include __DIR__."/views/products/layout/_header.php";
        include __DIR__."/views/products/$view.php";
        // $content = ob_get_clean();
        // include __DIR__."/views/products/layout/_header.php";
    }
}
