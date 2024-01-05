<?php

include '../components/connect.php';

session_start();

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_admin = mysqli_query($conn, "SELECT * FROM `admin` WHERE name = '$name' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_admin) > 0) {
        $fetch_admin_id = mysqli_fetch_assoc($select_admin);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header('location: index.php');
    } else {
        $message[] = 'incorrect username or password!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!-- Font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
            <div class="message">
                <span>' . $message . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        ';
        }
    }
    ?>

    <section class="form-container">

        <form action="" method="post">
            <h3>login now</h3>
            <p><span>WELCOME BACK TO FOOD WEBSITE</span></p>
            <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="login now" name="submit" class="btn">
            <a class="forgot_pass_link" href="forgot_pass.php">Forgot password?</a>
        </form>
        
    </section>
    

</body>
</html>