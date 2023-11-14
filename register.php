<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' OR number = '$number'") or die('query failed');
    $row = mysqli_fetch_array($select_user);

    if(mysqli_num_rows($select_user) > 0) {
        $message[] = 'email or number already exsits';
    }else {
        if($pass != $cpass){
            $message[] = 'confirm password not matched';
        }else {
            $insert_user = mysqli_query($conn, "INSERT INTO `users`(name, email, number, password) VALUES('$name', '$email', '$number', '$cpass')");
            $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'");
            $row = mysqli_fetch_assoc($select_user);
            if(mysqli_num_rows($select_user) > 0) {
                $_SESSION['user_id'] = $row['id'];
                header('location:home.php');
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- Font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <section class="form-container">

        <form action="" method="post">
            <h3>register now</h3>
            <input type="text" name="name" required placeholder="enter your name" class="box" maxlength="50">
            <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="number" name="number" required placeholder="enter your number" class="box" min="0" max="9999999999" maxlength="10">
            <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="cpass" required placeholder="confirm your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="register now" name="submit" class="btn">
            <p>already have an account? <a href="login.php">login now</a></p>
        </form>

    </section>


    <?php include 'compoments/footer.php'; ?>


    <!-- custom js file link -->
    <script src="js/script.js"></script>

</body>

</html>