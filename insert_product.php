<?php

require_once 'connect.php';

// Get the form data
$product_name = $_POST['product_name'];
$price = $_POST['price'];
$stock = $_POST['stock'];

// Insert the data into the database
$sql = "INSERT INTO product (product_name, price, stock) VALUES ('$product_name', $price, $stock)";
if (mysqli_query($connect, $sql)) {
    echo "Product added successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

header('Location: homepage.php');
mysqli_close($connect);
?>