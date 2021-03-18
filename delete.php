<?php

$title = 'Update';
require_once 'config/dbconnection.php';
//include 'models/functions.php';

$pdo = pdo_connect_mysql();
$msg = '';
// Check that the product ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $sql = 'SELECT * FROM products WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Product doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the product!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: products.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
$pdo = NULL;
include 'templates/header.php';
?>

<div class="content delete">
	<h2>Delete Product #<?=$product['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete product #<?=$product['id']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$product['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$product['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?php 
include 'templates/footer.php';
?>