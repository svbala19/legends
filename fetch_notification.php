<?php
$host = "localhost";
$dbname = "legends";
$username = "root";
$db_password = "";

$conn = new mysqli($host, $username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch notification content and role from the database
$sql = "SELECT * FROM notifications ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $notificationContent = $row['content'];
    $role = $row['role'];
    echo json_encode(array('content' => $notificationContent, 'role' => $role));
} else {
    echo json_encode(array('content' => 'No notification found', 'role' => ''));
}

$conn->close();
?>
