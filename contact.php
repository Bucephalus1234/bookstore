<?php

include 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

// Encryption function
function encrypt_message($message, $encryption_key, $iv) {
    return openssl_encrypt($message, 'AES-256-CBC', $encryption_key, 0, $iv);
}

// Retrieve the encryption key from the environment variable
$encryption_key = getenv('ENCRYPTION_KEY');
if (!$encryption_key) {
    die('Encryption key not set');
}

if (isset($_POST['send'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = $_POST['number'];
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    // Generate a secure 16-byte IV
    $iv = random_bytes(16);

    // Encrypt the message
    $encrypted_msg = encrypt_message($msg, $encryption_key, $iv);

    // Convert IV to hexadecimal for storage
    $iv_hex = bin2hex($iv);

    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$encrypted_msg' AND iv = '$iv_hex'") or die('query failed');

    if (mysqli_num_rows($select_message) > 0) {
        $message[] = 'Message sent already!';
    } else {
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message, iv) VALUES('$user_id', '$name', '$email', '$number', '$encrypted_msg', '$iv_hex')") or die('query failed');
        $message[] = 'Message sent successfully!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style1.2.css">
</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
    <h3>Contact Us</h3>
    <p> <a href="home.php">Home</a> / Contact </p>
</div>

<section class="contact">
    <form action="" method="post">
        <h3>Say Something!</h3>
        <input type="text" name="name" required placeholder="Enter your name" class="box">
        <input type="email" name="email" required placeholder="Enter your email" class="box">
        <input type="number" name="number" required placeholder="Enter your number" class="box">
        <textarea name="message" class="box" placeholder="Enter your message" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="Send Message" name="send" class="btn">
    </form>
</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
