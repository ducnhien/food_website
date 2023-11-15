<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>

    <!-- Font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'components/user_header.php'; ?>

    <div class="heading">
        <h3>orders</h3>
        <p><a href="home.php">home</a> / orders</p>
    </div>

    <section class="box-container">

        <h1 class="title">your orders</h1>

        <div class="box-container">

            <?php
            if ($user_id == '') {
                echo '<p class="empty">please login to see your orders</p>';
            } else {
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id ='$user_id'") or die('query failed');
                if (mysqli_num_rows($select_orders) > 0) {
                    while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>
                        <div class="box">
                            <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
                            <p>name : <span><?= $fetch_orders['name']; ?></span></p>
                            <p>email : <span><?= $fetch_orders['email']; ?></span></p>
                            <p>number : <span><?= $fetch_orders['number']; ?></span></p>
                            <p>address : <span><?= $fetch_orders['address']; ?></span></p>
                            <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
                            <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
                            <p>total price : <span><?= $fetch_orders['total_price']; ?>/-</span></p>
                            <p> payment status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                                        echo 'red';
                                                                    } else {
                                                                        echo 'green';
                                                                    }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
                        </div>
            <?php
                    }
                } else {
                    echo '<p class="empty">no orders placed yet!</p>';
                }
            }
            ?>

        </div>

    </section>

    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>

</body>
</html>