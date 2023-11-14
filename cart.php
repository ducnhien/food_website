<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
};

if (isset($_POST['delete'])) {
    $cart_id = $_POST['cart_id'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$cart_id'");
    $message[] = 'cart item deleted!';
}

if (isset($_POST['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");
    $message[] = 'deleted all from cart!';
}

if (isset($_POST['update_qty'])) {
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$qty' WHERE id = '$cart_id'");
    $message[] = 'cart quantity updated';
}

$grand_total = 0;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'compoments/user_header.php'; ?>

    <div class="heading">
        <h3>shopping cart</h3>
        <p><a href="home.php">home</a> <span> / cart</span></p>
    </div>

    <section class="products">
        <h1 class="title">your cart</h1>

        <div class="box-container">

            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            ?>
                    <form action="" method="post" class="box">
                        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                        <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
                        <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('delete this item?');"></button>
                        <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
                        <div class="name"><?= $fetch_cart['name']; ?></div>
                        <div class="flex">
                            <div class="price"><span>$</span><?= $fetch_cart['price']; ?></div>
                            <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
                            <button type="submit" class="fas fa-edit" name="update_qty"></button>
                        </div>
                        <div class="sub-total"> sub total : <span>$<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
                    </form>
            <?php
                    $grand_total += $sub_total;
                }
            } else {
                echo '<p class="empty">your cart is empty</p>';
            }
            ?>

        </div>

        <div class="cart-total">
            <p>cart total : <span>$<?= $grand_total; ?></span></p>
            <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">proceed to checkout</a>
        </div>

        <div class="more-btn">
            <form action="" method="post">
                <button type="submit" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" name="delete_all" onclick="return confirm('delete all from cart?');">delete all</button>
            </form>
            <a href="menu.php" class="btn">continue shopping</a>
        </div>

    </section>


    <?php include 'compoments/footer.php'; ?>

    <script src="js/script.js"></script>
</body>
</html>