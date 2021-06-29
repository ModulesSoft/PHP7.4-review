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