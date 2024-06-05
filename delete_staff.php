<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check for dependencies in the projects table
    $sql = "SELECT COUNT(*) FROM projects WHERE project_tl = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Handle the case where there are dependent records
        echo "Cannot delete staff member. They are assigned to $count projects.";
        // Optionally, provide a way to reassign or remove dependencies
    } else {
        // Proceed with deleting the staff member
        $sql = "DELETE FROM staff WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: manage_staff.php");
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>
