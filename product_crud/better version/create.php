<?php
//DB connection
/** @var $pdo \PDO */
require_once "database.php";

//random name generator
require_once "functions.php";

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
            if(!($_FILES['image']['size'])){
                die('image size is too heavy. maximum possible: 2MB');
            }
            if (!file_exists('uploads')) {
                mkdir('uploads', 0777, true);
            }
            //make unique name and path for image
            $ext = explode('.', $_FILES['image']['name']);
            $extention = $ext[count($ext) - 1];
            $image = 'uploads/' . randomName($extention);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
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

?>
<!doctype html>
<html lang="en">
<?php
require_once "_header.php";
?>

<body>
    <h1>Add new product</h1>
    <?php require_once "form.php" ?>
</body>

</html>