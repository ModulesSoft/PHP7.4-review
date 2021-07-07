<?php

namespace app\models;

use app\Database;
use PDO;
use PDOException;
class Product
{
    public ?Database $db = null;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function getProducts($keywords)
    {
            try {
                $statement = $this->db->pdo->prepare('select * from products where title like :title;');
                $statement->bindValue(":title","%$keywords%");
                $statement->execute();
                $products = $statement->fetchAll(PDO::FETCH_ASSOC);
              } catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
              }
              return $products;
    }
}
