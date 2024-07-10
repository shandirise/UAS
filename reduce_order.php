<?php
    require_once 'connect.php';

    $product_id = $_POST['product_id'];
    $email = $_POST['email'];

    // Get current cart item
    $query = "SELECT * FROM cart WHERE product_id = '$product_id' AND email = '$email';";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);

    $amount = $row['amount'];
    $price = $row['price'];

    if ($amount >= 1) {
        $new_amount = $amount - 1;
        $new_price = $price - ($price / $amount);

        // Update cart item
        $query = "UPDATE cart SET amount = '$new_amount', price = '$new_price' WHERE product_id = '$product_id' AND email = '$email';";
        mysqli_query($connect, $query);

        // Update product stock
        $query = "UPDATE product SET stock = stock + 1 WHERE product_id = '$product_id';";
        mysqli_query($connect, $query);
    } 
    header('Location: cart.php');
    exit;
?>