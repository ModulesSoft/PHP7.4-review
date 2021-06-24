<?php 


$servername = "localhost";
$username = "developer";
$password = "password";
$dbName = "phpcrud";
$pdo = null;


try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

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