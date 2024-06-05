<?php
$host = 'localhost';
$dbname = 'legends';
$username = 'root';
$db_password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
