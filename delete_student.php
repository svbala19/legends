<?php
include 'db_connect.php';

if(isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Delete student from the database
    $sql = "DELETE FROM students WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $student_id);

    if ($stmt->execute()) {
        // Redirect to the manage students page after successful deletion
        header("Location: manage_students.php");
        exit;
    } else {
        echo "Error deleting student.";
    }
} else {
    echo "Student ID is missing.";
    exit;
}
?>
