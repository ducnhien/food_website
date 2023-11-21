<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
};

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_admin = "SELECT * FROM `admin` WHERE name = '" . mysqli_real_escape_string($conn, $name) . "'";
    $result = mysqli_query($conn, $select_admin);

    if (mysqli_num_rows($result) > 0) {
        $message[] = 'username already exists!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'confirm passowrd not matched!';
        } else {
            $insert_admin = "INSERT INTO `admin`(name, password) VALUES ('" . mysqli_real_escape_string($conn, $name) . "', '" . mysqli_real_escape_string($conn, $cpass) . "')";
            mysqli_query($conn, $insert_admin);
            $message[] = 'new admin registered!';
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
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="form-container">

        <form action="" method="POST">
            <h3>register new</h3>
            <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="cpass" maxlength="20" required placeholder="confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="register now" name="submit" class="btn">
        </form>

    </section>

    <script src="../js/admin_script.js"></script>

</body>
</html>