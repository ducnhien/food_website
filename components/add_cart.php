<?php

if (isset($_POST['add_to_cart'])) {

    if ($user_id == '') {
        header('location:login.php');
    } else {

        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);

        $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$name' AND user_id = '$user_id'");

        if (mysqli_num_rows($check_cart_numbers) > 0) {
            $message[] = 'already added to cart!';
        } else {
            $insert_cart = mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$pid', '$name', '$price', '$qty', '$image')");
            $message[] = 'added to cart!';
        }
    }
}

?>