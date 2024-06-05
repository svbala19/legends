<?php
// Include your database connection script
include 'db_connect.php';

// Check if project ID is provided
if(isset($_GET['id'])) {
    $project_id = $_GET['id'];

    // Delete project from the database
    $sql = "DELETE FROM projects WHERE project_id = :project_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':project_id', $project_id);

    if ($stmt->execute()) {
        // Redirect to the manage projects page after successful deletion
        header("Location: manage_projects.php");
        exit;
    } else {
        echo "Error deleting project.";
    }
} else {
    echo "Project ID is missing.";
    exit;
}
?>
