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
    <h1>edit product <?php echo $title; ?></h1>
    <img style="width:200px" src="<?php echo $image; ?>" />

    <?php
    require_once __DIR__ . "/layout/_form.php";
    ?>

</body>

</html>