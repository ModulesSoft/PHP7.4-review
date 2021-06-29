<?php
//DB connection
/** @var $pdo \PDO */
require_once "../database.php";

//random name generator
require_once "../functions.php";

$id = null;
$image = null;
$title = null;
$description  = null;
$price = null;
if (!isset($_GET['id'])) {
    header("Location:index.php");
    exit;
} else {
    $id = $_GET['id'];
    try {
        $statement = $pdo->prepare("select * from products where id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        $result = $statement->fetch();
        $image = $result['image'];
        $title = $result['title'];
        $description = $result['description'];
        $price = $result['price'];
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
    }
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
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        if (isset($_FILES) && $_FILES['image']['name']) {
            if (!($_FILES['image']['size'])) {
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
            $statement = $pdo->prepare("update products set title=:title,description=:description,image=:image,price=:price where id=:id;");
            $statement->bindValue('title', $title);
            $statement->bindValue('description', $description);
            $statement->bindValue('image', $image);
            $statement->bindValue('price', $price);
            $statement->bindValue('id', $id);
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
require_once "../views/_header.php";
?>

<body>
    <h1>edit product <?php echo $title; ?></h1>
    <img style="width:200px" src="<?php echo $image; ?>" />

    <?php
    require_once "../views/_form.php";
    ?>

</body>

</html>