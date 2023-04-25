<?php
session_start();
$_SESSION['cart'];

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['item_id'];
    $product_name = $_POST['item_name'];
    $product_price = $_POST['item_price'];

    // Add product to cart
    $_SESSION['cart'][$product_id] = array(
        'item_name' => $product_name,
        'item_price' => $product_price,
        'item_quantity' => 1
    );

}
header('Location: cart.php');
?>