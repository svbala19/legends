<?php
// Include your database connection script
include 'db_connect.php';

// Retrieve form data
$project_name = $_POST['project_name'];
$project_tl = $_POST['project_tl'];

// Prepare SQL statement to insert project into the database
$sql = "INSERT INTO projects (project_name, project_tl) VALUES (:project_name, :project_tl)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':project_name', $project_name);
$stmt->bindParam(':project_tl', $project_tl);

// Execute the SQL statement
if ($stmt->execute()) {
    echo "Project added successfully.";
} else {
    echo "Error: " . $stmt->errorInfo()[2];
}

// Close the database connection
$conn = null;
?>
