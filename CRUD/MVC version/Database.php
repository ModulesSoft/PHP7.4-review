<?php

namespace app;

use PDO;
use PDOException;


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
}
