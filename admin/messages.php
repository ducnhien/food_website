<?php

include "../components/connect.php";

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_message = mysqli_query($conn, "DELETE FROM `messages` WHERE id = '$delete_id'") or die("query failed");
    header("location:messages.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messages</title>

    <!-- Font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="messages">

        <h1 class="heading">messages</h1>

        <div class="box-container">

            <?php
            $select_messages = mysqli_query($conn, "SELECT * FROM `messages`") or die('query failed');
            if (mysqli_num_rows($select_messages) > 0) {
                while ($fetch_messages = mysqli_fetch_assoc($select_messages)) {
            ?>
            <div class="box">
                <p> name : <span><?= $fetch_messages['name']; ?></span></p>
                <p> number : <span><?= $fetch_messages['number']; ?></span></p>
                <p> email : <span><?= $fetch_messages['email']; ?></span></p>
                <p> message : <span><?= $fetch_messages['message']; ?></span></p>
                <a href="messages.php?delete=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('delete this message?');">delete</a>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">you have no messages</p>';
            }
            ?>

        </div>

    </section>

    <script src="../js/script.js"></script>

</body>

</html>