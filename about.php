<?php
// Include the configuration file
include 'config.php';

// Start the session
session_start();

// Check if the user is logged in
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    // If not logged in, redirect to the login page
    header('location:login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style1.2.css">
</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
    <h3>About Us</h3>
    <p> <a href="home.php">Home</a> / About </p>
</div>

<section class="about">
    <div class="flex">
        <div class="image">
            <img src="images/about-img.jpg" alt="About Us">
        </div>

        <div class="content">
            <h3>Why Choose Us?</h3>
            <p>We are committed to providing exceptional service and ensuring a superior shopping experience for our customers. Here are a few reasons why you should choose us:</p>
            <ul>
                <li><strong>Experienced Team:</strong> Our team consists of highly experienced professionals dedicated to providing top-notch services.</li>
                <li><strong>Customer Support:</strong> We offer 24/7 customer support to assist you with any queries or issues you may have.</li>
                <li><strong>Secure Transactions:</strong> We prioritize the security of your transactions with advanced encryption and security protocols.</li>
                <li><strong>Wide Range of Products:</strong> Our extensive collection ensures that you find exactly what you're looking for.</li>
                <li><strong>Competitive Prices:</strong> We offer the best prices without compromising on quality.</li>
            </ul>
            <a href="contact.php" class="btn">Contact Us</a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>
</html>
