<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete = mysqli_query($con, "DELETE FROM `admin` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_account.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admins accounts</title>

    <!-- Font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="accounts">

        <h1 class="heading">admins account</h1>

        <div class="box-container">

            <div class="box">
                <p>register new admin</p>
                <a href="register_admin.php" class="option-btn">register</a>
            </div>

            <?php
            $select_account = mysqli_query($conn, "SELECT * FROM `admin`") or die('query failed');
            if (mysqli_num_rows($select_account) > 0) {
                while ($fetch_accounts = mysqli_fetch_assoc($select_account)) {
            ?>
                    <div class="box">
                        <p> admin id : <span><?= $fetch_accounts['id']; ?></span> </p>
                        <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
                        <div class="flex-btn">
                            <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('delete this account?');">delete</a>
                            <?php
                            if ($fetch_accounts['id'] == $admin_id) {
                                echo '<a href="update_profile.php" class="option-btn">update</a>';
                            }
                            ?>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no accounts available</p>';
            }
            ?>
        </div>

    </section>

    <script src="../js/admin_script.js"></script>

</body>

</html>