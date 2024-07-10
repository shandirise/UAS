<?php
require_once 'connect.php';

$product_id = $_POST['product_id'];
$price = $_POST['price'];
$email = $_SESSION['email'];

// Check if the product is already in the cart
$query = "SELECT * FROM cart WHERE product_id = '$product_id' AND email = '$email'";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    // If the product is already in the cart, update the amount and price
    $query = "UPDATE cart SET amount = amount + 1, price = price + '$price' WHERE product_id = '$product_id' AND email = '$email'";
    mysqli_query($connect, $query);
} else {
    // If the product is not in the cart, add it
    $query = "INSERT INTO cart (product_id, email, amount, price) VALUES ('$product_id', '$email', 1, '$price')";
    mysqli_query($connect, $query);
}

// Decrease the stock value in the product table
$query = "UPDATE product SET stock = stock - 1 WHERE product_id = '$product_id'";
mysqli_query($connect, $query);

header('Location: homepage.php');
exit;
?>