<?php
include 'config.php';
include 'csrf.php'; // Include CSRF file
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Asia/Singapore');

function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rafiqjamal59@gmail.com';
        $mail->Password = 'akjx vtlu rpmq bxbm';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('rafiqjamal59@gmail.com', 'Bookworm 2FA');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP code is $otp";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['submit'])) {
    // Validate CSRF token
    if (!validate_csrf_token($_POST['csrf_token'])) {
        $message[] = 'Invalid CSRF token!';
    } else {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = mysqli_real_escape_string($conn, $_POST['password']);
        $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
        $user_type = $_POST['user_type'];

        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

        if (mysqli_num_rows($select_users) > 0) {
            $message[] = 'User already exists!';
        } else {
            if ($pass != $cpass) {
                $message[] = 'Confirm password does not match!';
            } else {
                $hashed_pass = password_hash($cpass, PASSWORD_DEFAULT);
                $otp = rand(100000, 999999);
                $otp_expiration = date("Y-m-d H:i:s", strtotime('+10 minutes'));
                error_log("Generated OTP at: " . date("Y-m-d H:i:s"));
                if (sendOTP($email, $otp)) {
                    mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type, otp, otp_expiration) VALUES('$name', '$email', '$hashed_pass', '$user_type', '$otp', '$otp_expiration')") or die('query failed');
                    $_SESSION['otp_email'] = $email;
                    header('location:verify_otp.php');
                } else {
                    $message[] = 'Failed to send OTP! Please check your email address and try again.';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style1.2.css">
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

<div class="form-container">
    <form action="" method="post">
        <h3>Register Now</h3>
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
        <input type="text" name="name" placeholder="Enter your name" required class="box">
        <input type="email" name="email" placeholder="Enter your email" required class="box">
        <input type="password" name="password" placeholder="Enter your password" required class="box">
        <input type="password" name="cpassword" placeholder="Confirm your password" required class="box">
        <select name="user_type" class="box">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <input type="submit" name="submit" value="Register Now" class="btn">
        <p>Already have an account? <a href="login.php">Login now</a></p>
        <p><a href="forgot-password.php">Forgot your password?</a></p>
    </form>
</div>
</body>
</html>
