<?php 
session_start();
require "config.php";
$email = "";
$errors = array();

// if user clicks continue button in forgot password form
if(isset($_POST['check-email'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $run_sql = mysqli_query($conn, $check_email);
    if(mysqli_num_rows($run_sql) > 0){
        $code = rand(100000, 999999);
        $insert_code = "UPDATE users SET otp = '$code', otp_expiration = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email = '$email'";
        $run_query =  mysqli_query($conn, $insert_code);
        if($run_query){
            $subject = "Password Reset Code";
            $message = "Your password reset code is $code";
            $sender = "From: lks942111@gmail.com"; // Use your actual email
            if(mail($email, $subject, $message, $sender)){
                $info = "We've sent a password reset code to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            }else{
                $errors['otp-error'] = "Failed while sending code!";
            }
        }else{
            $errors['db-error'] = "Something went wrong!";
        }
    }else{
        $errors['email'] = "This email address does not exist!";
    }
}

// if user clicks check reset code button
if(isset($_POST['check-reset-otp'])){
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
    $check_code = "SELECT * FROM users WHERE otp = '$otp_code' AND otp_expiration > NOW()";
    $code_res = mysqli_query($conn, $check_code);
    if(mysqli_num_rows($code_res) > 0){
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new-password.php');
        exit();
    }else{
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}

// if user clicks change password button
if(isset($_POST['change-password'])){
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    if($password !== $cpassword){
        $errors['password'] = "Confirm password not matched!";
    }else{
        $code = NULL;
        $otp_expiration = NULL;
        $email = $_SESSION['email']; // getting this email using session
        $encpass = password_hash($password, PASSWORD_DEFAULT);
        $update_pass = "UPDATE users SET otp = '$code', otp_expiration = '$otp_expiration', password = '$encpass' WHERE email = '$email'";
        $run_query = mysqli_query($conn, $update_pass);
        if($run_query){
            $info = "Your password has been changed. Now you can login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: password-changed.php');
        }else{
            $errors['db-error'] = "Failed to change your password!";
        }
    }
}

// if login now button click
if(isset($_POST['login-now'])){
    header('Location: login.php');
}
?>
