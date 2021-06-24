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
//validation and submit query
$errors = [];
if (!empty($_POST)) {
    if (!$_POST['title']) {
        $errors[] = "title must not be empty";
    }
    if (!$_POST['description']) {
        $errors[] = "description must not be empty";
    }
    if (!$_POST['price']) {
        $errors[] = "price must not be empty";
    }
    if (empty($errors)) {
        $image = null;
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        if (isset($_FILES)) {
            if (!file_exists('uploads')) {
                mkdir('uploads', 0777, true);
            }
            $ext = explode('.', $_FILES['image']['name']);
            $extention = $ext[count($ext) - 1];
            $image = 'uploads/' . randomName($extention);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }
        try {
            $statement = $pdo->prepare("insert into products (title,description,image,price) values (:title,:description,:image,:price)");
            $statement->bindValue('title', $title);
            $statement->bindValue('description', $description);
            $statement->bindValue('image', $image);
            $statement->bindValue('price', $price);
            $statement->execute();
            header("Location:index.php");
            exit;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }
}

function randomName(string $extention)
{
    if(!$extention){
        die('image extention not found!');
    }
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($characters), -10) . '.' . $extention;
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Simple Products CRUD Review</title>
</head>

<body>
    <h1>Add new product</h1>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php
            foreach ($errors as $err) {
                echo '- ' . $err . '<br>';
            }
            ?>
        </div>
    <?php endif ?>
    <div style="margin : 12px">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image" class="form-label">Image</label>
                <input name="image" id="image" type="file" class="form-control">
            </div>
            <div class="form-group">
                <label for="title" class="form-label">Title</label>
                <input name="title" class="form-control" id="title">
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="price">Price</label>
                <input name="price" type="number" step=".01" class="form-control" id="price">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>