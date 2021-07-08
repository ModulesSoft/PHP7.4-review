<?php

namespace app\models;

use app\Database;
use app\helpers\GeneralHelper;
use PDO;
use PDOException;

class Product
{
  public ?Database $db = null;
  public function __construct()
  {
    $this->db = new Database;
  }
  public function getProducts($keywords = '')
  {
    try {
      $statement = $this->db->pdo->prepare('select * from products where title like :title;');
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
      $statement = $this->db->pdo->prepare('select * from products where id = :id;');
      $statement->bindValue(":id", $id);
      $statement->execute();
      $product = $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "Query failed: " . $e->getMessage();
    }
    return $product;
  }

  public function save($product)
  {
    //validation and submit query
    $errors = [];
    if ($product) {
      if (!$product['title']) {
        $errors[] = "title must not be empty";
      }
      if (!$product['description']) {
        $errors[] = "description must not be empty";
      }
      if (!$product['price']) {
        $errors[] = "price must not be empty";
      }
      if (empty($errors)) {
        $title = $product['title'];
        $description = $product['description'];
        $price = $product['price'];
        $id = $product['id'] ?? null;
        $imageFile = $product['imageFile'];
        if (isset($imageFile) && $imageFile['name']) {
          if (!($imageFile['size'])) {
            die('image size is too heavy. maximum possible: 2MB');
          }
          if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
          }
          //make unique name and path for image
          $ext = explode('.', $imageFile['name']);
          $extention = $ext[count($ext) - 1];
          $image = 'uploads/' . GeneralHelper::randomName($extention);
          move_uploaded_file($imageFile['tmp_name'], $image);
        }
        try {
          if (!$id) { //create a new product
            $statement = $this->db->pdo->prepare("insert into products (title,description,image,price) values (:title,:description,:image,:price)");
            $statement->bindValue('title', $title);
            $statement->bindValue('description', $description);
            $statement->bindValue('image', $image ?? null);
            $statement->bindValue('price', $price);
            $statement->execute();
            // exit;
          } else { //update a product
            if ($image) {
              $statement = $this->db->pdo->prepare("update products set title=:title,description=:description,image=:image,price=:price where id=:id;");
              $statement->bindValue('title', $title);
              $statement->bindValue('description', $description);
              $statement->bindValue('image', $image);
              $statement->bindValue('price', $price);
              $statement->bindValue('id', $id);
              $statement->execute();
              // exit;
            } elseif (!$image) {
              $statement = $this->db->pdo->prepare("update products set title=:title,description=:description,price=:price where id=:id;");
              $statement->bindValue('title', $title);
              $statement->bindValue('description', $description);
              $statement->bindValue('price', $price);
              $statement->bindValue('id', $id);
              $statement->execute();
              // exit;
            }
          }

          return null;
        } catch (PDOException $e) {
          echo "Query failed: " . $e->getMessage();
        }
      } else {
        return $errors;
      }
    }
  }
  public function delete($id)
  {
    if (isset($id)) {
      try {
        $statement = $this->db->pdo->prepare("delete from products where id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
      } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
      }
    }
  }
}