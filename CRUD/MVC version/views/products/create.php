<?php
$id = $data['id'];
$image = $data['image'];
$title = $data['title'];
$description  = $data['description'];
$price = $data['price'];
?>
<!doctype html>
<html lang="en">

<body>
    <h1>Add new product</h1>
    <?php
    require_once __DIR__ . "/layout/_form.php";
    ?>

</body>

</html>