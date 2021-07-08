<?php

namespace app\controllers;

use app\models\Product;
use app\Router;

class ProductController
{

    public function index()
    {
        $search = $_GET['search'] ?? '';
        $product = new Product();
        $result = $product->db->getProducts($search);
        $router = new Router();
        $router->render('index', $result);
    }

    public function edit()
    {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData = [];
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = $_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;
            $productData['id'] = $id;
            $product = new Product();
            $product->set($productData);
            $router = new Router();
            $errors = $product->save();
            if ($errors) {
                $router->render('edit', $productData, $errors);
            } else {
                header("Location:/");
                exit;
            }
        } else {
            $product = new Product();
            $result = $product->db->getProduct($id);
            $router = new Router();
            $router->render('edit', $result);
        }
    }
    public function delete()
    {
        $id = $_POST['id'];
        $product = new Product();
        $result = $product->db->deleteProduct($id);
        $router = new Router();
        header("Location:/");
        exit;
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData = [];
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = $_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;
            $product = new Product();
            $product->set($productData);
            $errors = $product->save();
            if ($errors) {
                $router = new Router();
                $router->render('create', $productData, $errors);
            } else {
                header("Location:/");
                exit;
            }
        } else {
            $router = new Router();
            $router->render('create');
        }
    }
}
