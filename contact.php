<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['send'])) {

    $name = $_POST['name'];
    $name = mysqli_real_escape_string($conn, $name);
    $email = $_POST['email'];
    $email = mysqli_real_escape_string($conn, $email);
    $number = $_POST['number'];
    $number = mysqli_real_escape_string($conn, $number);
    $msg = $_POST['msg'];
    $msg = mysqli_real_escape_string($conn, $msg);

    $select_message = mysqli_query($conn, "SELECT * FROM `messages` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'");

    if (mysqli_num_rows($select_message) > 0) {
        $message[] = 'already sent message!';
    } else {

        mysqli_query($conn, "INSERT INTO `messages`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')");

        $message[] = 'sent message successfully!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>

    <!-- Font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'components/user_header.php'; ?>

    <div class="heading">
        <h3>contact us</h3>
        <p><a href="home.php">home</a> <span> / contact</span></p>
    </div>

    <section class="contact">

        <div class="row">

            <div class="image">
                <img src="images/contact-img.svg" alt="">
            </div>

            <form action="" method="post">
                <h3>tell us something!</h3>
                <input type="text" name="name" maxlength="50" class="box" placeholder="enter your name" required>
                <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="enter your number" required maxlength="10">
                <input type="email" name="email" maxlength="50" class="box" placeholder="enter your email" required>
                <textarea name="msg" class="box" required placeholder="enter your message" maxlength="500" cols="30" rows="10"></textarea>
                <input type="submit" value="send message" name="send" class="btn">
            </form>

        </div>

    </section>

    <?php include 'components/footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>
</html>