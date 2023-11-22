<?php

include "../components/connect.php";

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
};

if (isset($_POST['update_payment'])) {

    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    $update_status = mysqli_query($conn, "UPDATE `orders` SET payment_status = '$payment_status' WHERE id = '$order_id'") or die('query failed');
    $message[] = 'payment status updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_order = mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
    header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>placed orders</title>

    <!-- Font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <section class="placed-orders">

        <h1 class="heading">placed orders</h1>

        <div class="box-container">

            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>
                    <div class="box">
                        <p> user id : <span><?= $fetch_orders['user_id']; ?></span></p>
                        <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
                        <p> name : <span><?= $fetch_orders['name']; ?></span></p>
                        <p> email : <span><?= $fetch_orders['email']; ?></span></p>
                        <p> number : <span><?= $fetch_orders['number']; ?></span></p>
                        <p> address : <span><?= $fetch_orders['address']; ?></span></p>
                        <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
                        <p> total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
                        <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
                        <form action="" method="post">
                            <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                            <select name="payment_status" class="drop-down">
                                <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                                <option value="pending">pending</option>
                                <option value="completed">completed</option>
                            </select>
                            <div class="flex-btn">
                                <input type="submit" value="update" class="btn" name="update_payment">
                                <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
                            </div>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no orders placed yet!</p>';
            }
            ?>

        </div>

    </section>

    <script src="../js/admin_script.js"></script>

</body>

</html>