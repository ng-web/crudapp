<?php

$title = 'Update';
require_once 'config/dbconnection.php';
//include 'models/functions.php';

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the product id exists, for example update.php?id=1 will get the product with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $category = isset($_POST['category']) ? $_POST['category'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        $modified = new DateTime('NOW');
        $modified = $modified->format('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE products SET id = ?, name = ?, description = ?, price = ?, category_id = ?, created = ?, modified = ? WHERE id = ?');
        $stmt->execute([$id, $name, $description, $price, $category, $created, $modified, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the product from the products table
    $sql = 'SELECT * FROM products WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Product doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
$pdo = NULL;
include 'templates/header.php';
?>

<div class="content update">
	<h2>Update Product #<?=$product['id']?></h2>
    <form action="update.php?id=<?=$product['id']?>" method="post">
        <label for="id">ID</label>
        <label for="name">Name</label>
        <input type="text" name="id" placeholder="1" value="<?=$product['id']?>" id="id">
        <input type="text" name="name" placeholder="Iphone XR" value="<?=$product['name']?>" id="name">
        <label for="description">Description</label>
        <label for="price">Price</label>
        <input type="text" name="description" placeholder="Technical Specs" value="<?=$product['description']?>" id="description">
        <input type="text" name="price" placeholder="202.99" value="<?=$product['price']?>" id="price">
        <label for="category">Category</label>
        <label for="created">Created</label>
        <input type="text" name="category" placeholder="Electronics" value="<?=$product['category_id']?>" id="category">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($product['created']))?>" id="created">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?php 
include 'templates/footer.php';
?>