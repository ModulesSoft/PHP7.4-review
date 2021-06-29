<?php 
//DB connection
/** @var $pdo \PDO */
require_once "database.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    try {
        $statement = $pdo->prepare("delete from products where id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
    }
}

header("Location:index.php");
exit;

?>