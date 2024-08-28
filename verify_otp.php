<?php
include 'config.php';
include 'csrf.php'; // Include CSRF file

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Singapore');

if (isset($_POST['verify'])) {
    // Validate CSRF token
    if (!validate_csrf_token($_POST['csrf_token'])) {
        $message[] = 'Invalid CSRF token!';
    } else {
        if (isset($_SESSION['otp_email'])) {
            $email = $_SESSION['otp_email'];
            $otp = mysqli_real_escape_string($conn, $_POST['otp']);

            error_log("Verifying OTP at: " . date("Y-m-d H:i:s"));

            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND otp = '$otp' AND otp_expiration > NOW()") or die('Query failed');

            if (mysqli_num_rows($select_users) > 0) {
                mysqli_query($conn, "UPDATE `users` SET otp = NULL, otp_expiration = NULL WHERE email = '$email'") or die('Query failed');
                $row = mysqli_fetch_assoc($select_users);

                if (isset($_SESSION['reset_password'])) {
                    unset($_SESSION['otp_email']);
                    unset($_SESSION['reset_password']);
                    header('Location: reset_password.php');
                    exit;
                }

                if ($row['user_type'] == 'admin') {
                    $_SESSION['admin_name'] = $row['name'];
                    $_SESSION['admin_email'] = $row['email'];
                    $_SESSION['admin_id'] = $row['id'];
                    unset($_SESSION['otp_email']);
                    header('Location: admin_page.php');
                } elseif ($row['user_type'] == 'user') {
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_email'] = $row['email'];
                    $_SESSION['user_id'] = $row['id'];
                    unset($_SESSION['otp_email']);
                    header('Location: home.php');
                }
                exit;
            } else {
                $message[] = 'Invalid or expired OTP!';
            }
        } else {
            $message[] = 'Session expired or email not set. Please try again.';
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
    <title>Verify OTP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style1.2.css">
</head>
<body>
<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '<div class="message"><span>' . $message . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
    }
}
?>
<div class="form-container">
    <form action="" method="post">
        <h3>Verify OTP</h3>
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
        <input type="text" name="otp" placeholder="Enter OTP" required class="box">
        <input type="submit" name="verify" value="Verify OTP" class="btn">
    </form>
</div>
</body>
</html>
