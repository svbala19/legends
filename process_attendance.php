<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db_connect.php';

    // Get form data
    $staff = $_POST['staff'];
    $role = $_POST['role'];
    $date = $_POST['date'];
    $session = $_POST['session'];

    // Process student attendance
    foreach ($_POST['students'] as $student) {
        $present = isset($_POST['attendance'][$student]) ? 1 : 0;

        // Insert attendance record into the database
        $sql = "INSERT INTO attendance (staff, role, student_name, date, session, present) 
                VALUES (:staff, :role, :student, :date, :session, :present)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':staff', $staff);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':student', $student);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':session', $session);
        $stmt->bindParam(':present', $present);
        $stmt->execute();
    }

    // Redirect back to the attendance page or wherever appropriate
    header("Location: attendance.php");
    exit();
} else {
    // Handle invalid requests
    header("Location: attendance.php");
    exit();
}
?>
