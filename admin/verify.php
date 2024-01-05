<?php 
session_start();
ob_start();
include '../components/connect.php';
if (isset($_POST['verify'])){
    $inp1 = $_POST['inp1'];
    $inp2 = $_POST['inp2'];
    $inp3 = $_POST['inp3'];
    $inp4 = $_POST['inp4'];
    $code = $inp1.$inp2.$inp3.$inp4;
    $email = $_SESSION['email'];
    if ($_SESSION['code'] == $code){
    $select_admin = mysqli_query($conn, "SELECT * FROM `admin` WHERE email = '$email' ") or die('query failed');

    if (mysqli_num_rows($select_admin) > 0) {
        $fetch_admin_id = mysqli_fetch_assoc($select_admin);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header('location: index.php');
    }
    }else {

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>verify</title>
</head>
<style>
    .form {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: space-around;
        width: 300px;
        background-color: white;
        border-radius: 12px;
        padding: 20px;
    }

    .title {
        font-size: 20px;
        font-weight: bold;
        color: black
    }

    .message {
        color: #a3a3a3;
        font-size: 14px;
        margin-top: 4px;
        text-align: center
    }

    .inputs {
        margin-top: 10px
    }

    .inputs input {
        width: 32px;
        height: 32px;
        text-align: center;
        border: none;
        border-bottom: 1.5px solid #d2d2d2;
        margin: 0 10px;
    }

    .inputs input:focus {
        border-bottom: 1.5px solid royalblue;
        outline: none;
    }

    .action {
        margin-top: 24px;
        padding: 12px 16px;
        border-radius: 8px;
        border: none;
        background-color: royalblue;
        color: white;
        cursor: pointer;
        align-self: end;
    }

    .back {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.7);
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }
</style>

<body>
    <div class="back">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="form">
            <div class="title">OTP</div>
            <div class="title">Verification Code</div>
            <p class="message">We have sent a verification code to your email</p>
            <div class="inputs"> <input name="inp1" id="input1" type="text" maxlength="1"> <input name="inp2"
                    id="input2" type="text" maxlength="1">
                <input name="inp3" id="input3" type="text" maxlength="1"> <input name="inp4" id="input4" type="text"
                    maxlength="1">
            </div> <input style="text-align: center;" type="submit" name="verify" value="verify me" class="action">
        </form>
    </div>

</body>

</html>