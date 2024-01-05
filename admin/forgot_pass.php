<?php
ob_start();
session_start();
include '../components/connect.php';
$randomNumber = mt_rand(1000, 9999);
//import thư viện phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
if (isset($_POST['send'])) {

  $email = $_POST['email'];
  $select_profile = mysqli_query($conn, "SELECT * FROM `admin` WHERE email = '$email'");
  if (mysqli_num_rows($select_profile) > 0) {
  $mail = new PHPMailer(true);

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'thienlodc123@gmail.com';
  $mail->Password = 'uwgz llfk wheg xdwe';
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;

  $mail->setFrom('thienlodc123@gmail.com', 'FOOD WEBSITE');
  $mail->addAddress($_POST["email"]);
  $mail->isHTML(true);
  $mail->Subject = "Forgot password";
  $mail->Body = "password reset code: $randomNumber";
  $mail->send();
  $_SESSION['code'] = $randomNumber;
  $_SESSION['email'] = $email;
  header ("location: verify.php");
} else {
    $message = 'This email does not exist!';
}

}
if (isset($_POST['verify'])){
  
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>forgot pass</title>
  <link rel="stylesheet" href="../asset/css/forgot_pass.css">
</head>
<style>
  .subscribe {
    margin: auto;
    position: relative;
    height: 140px;
    width: 400px;
    padding: 20px;
    background-color: #FFF;
    border-radius: 4px;
    color: #333;
    box-shadow: 0px 0px 60px 5px rgba(0, 0, 0, 0.4);
  }

  .subscribe:after {
    position: absolute;
    content: "";
    right: -10px;
    bottom: 18px;
    width: 0;
    height: 0;
    border-left: 0px solid transparent;
    border-right: 10px solid transparent;
    border-bottom: 10px solid #1a044e;
  }

  .subscribe p {
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    letter-spacing: 4px;
    line-height: 28px;
  }

  .subscribe input {
    position: absolute;
    bottom: 30px;
    border: none;
    border-bottom: 1px solid #d4d4d4;
    padding: 10px;
    width: 82%;
    background: transparent;
    transition: all .25s ease;
  }

  .subscribe input:focus {
    outline: none;
    border-bottom: 1px solid #0d095e;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', 'sans-serif';
  }

  .subscribe .submit-btn {
    position: absolute;
    border-radius: 30px;
    border-bottom-right-radius: 0;
    border-top-right-radius: 0;
    background-color: #0f0092;
    color: #FFF;
    padding: 12px 25px;
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
    letter-spacing: 5px;
    right: -10px;
    bottom: -20px;
    cursor: pointer;
    transition: all .25s ease;
    box-shadow: -5px 6px 20px 0px rgba(26, 26, 26, 0.4);
  }

  .subscribe .submit-btn:hover {
    background-color: #07013d;
    box-shadow: -5px 6px 20px 0px rgba(88, 88, 88, 0.569);
  }

 
</style>

<body>

  <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <div class="subscribe">
      <p>FORGOT PASSWORD</p>
      <input placeholder="Your e-mail" class="subscribe-input" name="email" type="email">
      <br>
      <input name="send" style="width: 40%;" type="submit" class="submit-btn" value="SEND CODE">
    </div>
  </form>
</body>

</html>