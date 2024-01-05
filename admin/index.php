<?php

include "../components/connect.php";

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>

    <!-- Font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="dashboard">

        <h1 class="heading">dashboard</h1>

        <div class="box-container">

            <div class="box">
                <h3>welcome</h3>
                <p><?= $fetch_profile['name']; ?></p>
                <a href="update_profile.php" class="btn">update profile</a>
            </div>

            <div class="box">
                <?php
                $total_pendings = 0;
                $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
                while ($fetch_pendings = mysqli_fetch_assoc($select_pendings)) {
                    $total_pendings += $fetch_pendings['total_price'];
                }
                ?>
                <h3><span>$</span><?= $total_pendings; ?><span>/-</span></h3>
                <p>total pendings</p>
                <a href="placed_orders.php" class="btn">see orders</a>
            </div>

            <div class="box">
                <?php
                $select_orders = mysqli_query($conn,'SELECT * FROM `orders`') or die('query failed');
                $numbers_of_orders = mysqli_num_rows($select_orders);
                ?>
                <h3><?= $numbers_of_orders; ?></h3>
                <p>total orders</p>
                <a href="placed_orders.php" class="btn">see orders</a>
            </div>

            <div class="box">
                <?php
                $select_products = mysqli_query($conn,'SELECT * FROM `products`') or die('query failed');
                $numbers_of_products = mysqli_num_rows($select_products);
                ?>
                <h3><?= $numbers_of_products; ?></h3>
                <p>products added</p>
                <a href="products.php" class="btn">see products</a>
            </div>

            <div class="box">
                <?php
                $select_users = mysqli_query($conn,'SELECT * FROM `users`') or die('query failed');
                $numbers_of_users = mysqli_num_rows($select_users);
                ?>
                <h3><?= $numbers_of_users; ?></h3>
                <p>users accounts</p>
                <a href="users_accounts.php" class="btn">see users</a>
            </div>

            <div class="box">
                <?php
                $select_admins = mysqli_query($conn,'SELECT * FROM `admin`') or die('query failed');
                $numbers_of_admins = mysqli_num_rows($select_admins);
                ?>
                <h3><?= $numbers_of_admins; ?></h3>
                <p>admins</p>
                <a href="admin_accounts.php" class="btn">see admins</a>
            </div>

            <div class="box">
                <?php
                $select_messages = mysqli_query($conn,'SELECT * FROM `messages`') or die('query failed');
                $numbers_of_messages = mysqli_num_rows($select_messages);
                ?>
                <h3><?= $numbers_of_messages; ?></h3>
                <p>new messages</p>
                <a href="messages.php" class="btn">see messages</a>
            </div>

        </div>

    </section>


    <script src="../js/script.js"></script>

</body>

</html>