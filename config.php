<?php
// file containing the encryption key
include 'key.php';

// $encryption_key is defined
if (!isset($encryption_key)) {
    die("<script>alert('Encryption key not found.')</script>");
}

// Read the encrypted content from the file
$encrypted_content = file_get_contents(__DIR__ . '/config.enc');
$decoded_content = base64_decode($encrypted_content);

// Extract the IV and encrypted data
$iv_length = openssl_cipher_iv_length('aes-256-cbc');
$iv = substr($decoded_content, 0, $iv_length);
$encrypted_data = substr($decoded_content, $iv_length);

// Decrypt the data using the encryption key
$decrypted_data = openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);

// Decode the JSON configuration
$config = json_decode($decrypted_data, true);

// Extract database configuration parameters
$server = $config['server'];
$username = $config['username'];
$password = $config['password'];
$database = $config['database'];

// Establish a database connection
$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}
?>
