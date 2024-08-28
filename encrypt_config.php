<?php
$data = [
    'server' => 'localhost',
    'username' => 'kyaw',
    'password' => 'Latt1234!',
    'database' => 'bookworm'
];

$encryption_key = 'my_secret_key'; 
$iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
$encrypted_data = openssl_encrypt(json_encode($data), 'aes-256-cbc', $encryption_key, 0, $iv);

file_put_contents('config.enc', base64_encode($iv . $encrypted_data));
echo "Config data encrypted and saved to config.enc";
?>
