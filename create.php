<?php

$title = 'Create';
require_once 'config/dbconnection.php';
//include 'models/functions.php';

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty(trim($_POST['id'])) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    $modified = new DateTime('NOW');
    $modified = $modified->format('Y-m-d H:i:s');
    // Insert new record into the products table
    $sql = 'INSERT INTO products VALUES (?, ?, ?, ?, ?, ?, ?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $name, $description, $price, $category, $created, $modified]);
    // Output message
    $msg = 'Created Successfully!';
}
$pdo = NULL;
include 'templates/header.php';
?>

<div class="content update">
	<h2>Create Product</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="name">Name</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="name" placeholder="Iphone XR" id="name">
        <label for="description">Description</label>
        <label for="price">Price</label>
        <input type="text" name="description" placeholder="Technical Specs" id="description">
        <input type="text" name="price" placeholder="202.99" id="price">
        <label for="category">Category</label>
        <label for="created">Created</label>
        <input type="text" name="category" placeholder="Product Category" id="category">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?php 
include 'templates/footer.php';
?>