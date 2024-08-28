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

        $mail->setFrom('rafiqjamal159@gmail.com', 'Bookworm 2FA');
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

function detect_sql_injection($input) {
    $patterns = [
        '/select\s.*\sfrom\s.*/i', // SELECT statements
        '/union\s.*\sselect\s.*/i', // UNION SELECT statements
        '/insert\sinto\s.*/i', // INSERT statements
        '/update\s.*\sset\s.*/i', // UPDATE statements
        '/delete\sfrom\s.*/i', // DELETE statements
        '/drop\s.*\stable\s.*/i', // DROP TABLE statements
        '/--/', // Comment sequence
        '/#/', // Comment sequence
        '/\/\*/', // Comment sequence
    ];
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $input)) {
            return true;
        }
    }
    return false;
}

if (isset($_POST['submit'])) {
    // Validate CSRF token
    if (!validate_csrf_token($_POST['csrf_token'])) {
        $message[] = 'Invalid CSRF token!';
    } else {
        $email = $_POST['email'];
        $entered_pass = $_POST['password'];

        // Detect SQL injection
        if (detect_sql_injection($email) || detect_sql_injection($entered_pass)) {
            error_log("SQL Injection attempt detected: email = $email, password = $entered_pass");
            $message[] = 'Invalid input detected!';
        } else {
            $email = mysqli_real_escape_string($conn, $email);
            $entered_pass = mysqli_real_escape_string($conn, $entered_pass);

            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

            if (mysqli_num_rows($select_users) > 0) {
                $row = mysqli_fetch_assoc($select_users);
                $stored_hashed_pass = $row['password'];

                if (password_verify($entered_pass, $stored_hashed_pass)) {
                    $otp = rand(100000, 999999);
                    $otp_expiration = date("Y-m-d H:i:s", strtotime('+10 minutes'));
                    error_log("Generated OTP at: " . date("Y-m-d H:i:s") . " for email: $email with OTP: $otp and expiration: $otp_expiration");
                    if (sendOTP($email, $otp)) {
                        mysqli_query($conn, "UPDATE `users` SET otp = '$otp', otp_expiration = '$otp_expiration' WHERE email = '$email'") or die('query failed');
                        $_SESSION['otp_email'] = $email;
                        header('location:verify_otp.php');
                    } else {
                        $message[] = 'Failed to send OTP!';
                    }
                } else {
                    $message[] = 'Incorrect email or password!';
                }
            } else {
                $message[] = 'Incorrect email or password!';
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
    <title>Login</title>
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
        <h3>Login Now</h3>
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
        <input type="email" name="email" placeholder="Enter your email" required class="box">
        <input type="password" name="password" placeholder="Enter your password" required class="box">
        <input type="submit" name="submit" value="Login Now" class="btn">
        <p>Don't have an account? <a href="register.php">Register now</a></p>
        <p><a href="forgot-password.php">Forgot your password?</a></p>
    </form>
</div>
</body>
</html>
