<?php
namespace app\views\products; 
$products = $data;
?>
<!doctype html>
<html lang="en">
<?php
require_once __DIR__."/layout/_header.php";
?>
<body>
  <h1>Products list</h1>
  <p>
  <form action="" method="get">
    <div class="input-group mb-3">
      <input name="search" value="<?php echo $search; ?>" type="text" class="form-control" placeholder="Search products" aria-label="Recipient's username" aria-describedby="button-addon2">
      <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
    </div>
  </form>
  </p>
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
          <td><img style="width:100px" src="<?php echo $p['image']; ?>" /></td>
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