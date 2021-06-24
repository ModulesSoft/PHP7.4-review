<?php

$servername = "localhost";
$username = "developer";
$password = "password";
$dbName = "phpcrud";
try {
  $pdo = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
try {
  $statement = $pdo->prepare('select * from products');
  $statement->execute();
  $products = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Query failed: " . $e->getMessage();
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
  <h1>Products list</h1>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->

  <p>
    <a href="create.php" type="button" class="btn btn-sm btn-outline-success">new product</a>
  </p>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Image</th>
        <th scope="col">Title</th>
        <th scope="col">Price</th>
        <th scope="col">Create Date</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $i => $p) : ?>
        <tr>
          <th scope="row"><?php echo $i ?></th>
          <td><?php echo $p['image']; ?></td>
          <td><?php echo $p['title']; ?></td>
          <td><?php echo $p['price']; ?>$</td>
          <td><?php echo $p['create_date']; ?></td>
          <td>
            <form action="delete.php" method="post">
              <input hidden name="id" value="<?php echo $p['id'] ?>" />
              <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
            </form>
            <form action="edit.php" method="get">
              <input hidden name="id" value="<?php echo $p['id'] ?>" />
              <button type="submit" class="btn btn-sm btn-outline-warning">edit</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</body>

</html>