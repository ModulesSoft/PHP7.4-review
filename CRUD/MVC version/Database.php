<?php

namespace app;

use PDO;
use PDOException;
use app\models\Product;


class Database
{
    public $servername = "localhost";
    public $username = "developer";
    public $password = "password";
    public $dbName = "phpcrud";
    public $pdo = null;
    function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->servername;dbname=$this->dbName", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function getProducts($keywords = '')
    {
        try {
            $statement = $this->pdo->prepare('select * from products where title like :title;');
            $statement->bindValue(":title", "%$keywords%");
            $statement->execute();
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        return $products;
    }
    public function getProduct($id)
    {
        try {
            $statement = $this->pdo->prepare('select * from products where id = :id;');
            $statement->bindValue(":id", $id);
            $statement->execute();
            $product = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
        return $product;
    }
    public function addProduct(Product $product)
    {
        try {
            $statement = $this->pdo->prepare("insert into products (title,description,image,price) values (:title,:description,:image,:price)");
            $statement->bindValue('title', $product->title);
            $statement->bindValue('description', $product->description);
            $statement->bindValue('image', $product->imagePath ?? null);
            $statement->bindValue('price', $product->price);
            $statement->execute();
            // exit;

            return null;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }
    public function editProduct(Product $product)
    {
        try {
            if ($product->imagePath) {
                $statement = $this->pdo->prepare("update products set title=:title,description=:description,image=:image,price=:price where id=:id;");
                $statement->bindValue('title', $product->title);
                $statement->bindValue('description', $product->description);
                $statement->bindValue('image', $product->imagePath);
                $statement->bindValue('price', $product->price);
                $statement->bindValue('id', $product->id);
                $statement->execute();
                return null;
                // exit;
            } elseif (!$product->imagePath) {
                $statement = $this->pdo->prepare("update products set title=:title,description=:description,price=:price where id=:id;");
                $statement->bindValue('title', $product->title);
                $statement->bindValue('description', $product->description);
                $statement->bindValue('price', $product->price);
                $statement->bindValue('id', $product->id);
                $statement->execute();
                return null;
                // exit;
            }
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }
    public function deleteProduct($id)
    {
        if (isset($id)) {
            try {
                $statement = $this->pdo->prepare("delete from products where id = :id");
                $statement->bindValue('id', $id);
                $statement->execute();
            } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
            }
        }
    }
}
