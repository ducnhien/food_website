<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
};

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);

    if (!empty($name)) {
        $update_name = mysqli_query($conn, "UPDATE `users` SET name = '$name' WHERE id = '$user_id'") or die('query failed');
    }

    if (!empty($email)) {
        $select_email = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');
        if (mysqli_num_rows($select_email) > 0) {
            $message[] = 'email already taken!';
        } else {
            $update_email = mysqli_query($conn, "UPDATE `users` SET email = '$email' WHERE id = '$user_id'") or die('');
        }
    }

    if (!empty($number)) {
        $select_number = mysqli_query($conn, "SELECT * FROM `users` WHERE number = '$number'") or die('query failed');
        if (mysqli_num_rows($select_number) > 0) {
            $message[] = 'number already taken!';
        } else {
            $update_number = mysqli_query($conn, "UPDATE `users` SET number = '$number' WHERE id = '$user_id'") or die("query failed");
        }
    }

    $empty_pass = '40bd001563085fc35165329ea1ff5c5ecbdbbeef';
    $select_prev_pass = mysqli_query($conn, "SELECT password FROM `users` WHERE id = '$user_id'") or die('query failed');
    $fetch_prev_pass = mysqli_fetch_assoc($select_prev_pass);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    if ($old_pass != $empty_pass) {
        if ($old_pass != $prev_pass) {
            $message[] = 'old password not matched!';
        } elseif ($new_pass != $confirm_pass) {
            $message[] = 'confirm password not matched!';
        } else {
            if ($new_pass != $empty_pass) {
                $update_pass = mysqli_query($conn,"UPDATE `users` SET password = '$confirm_pass' WHERE id = '$user_id'");
                $message[] = 'password updated successfully!';
            } else {
                $message[] = 'please enter a new password!';
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
    <title>update profile</title>

    <!-- Font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'components/user_header.php'; ?>


    <section class="form-container update-form">

        <form action="" method="post">
            <h3>update profile</h3>
            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="box" maxlength="50">
            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="number" name="number" placeholder="<?= $fetch_profile['number']; ?>"" class=" box" min="0" max="9999999999" maxlength="10">
            <input type="password" name="old_pass" placeholder="enter your old password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="new_pass" placeholder="enter your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="confirm_pass" placeholder="confirm your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="update now" name="submit" class="btn">
        </form>

    </section>

    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>

</body>
</html>