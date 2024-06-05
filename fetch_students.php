<?php
require_once 'db_connect.php';

if (isset($_POST['role'])) {
    $role = $_POST['role'];

    $sql_students = "SELECT name FROM students WHERE role = :role";
    $stmt_students = $conn->prepare($sql_students);
    $stmt_students->bindParam(':role', $role);
    $stmt_students->execute();
    $students = $stmt_students->fetchAll(PDO::FETCH_COLUMN);

    foreach ($students as $student) {
        echo '<div class="student">';
        echo '<div class="icon-container">';
        echo '<i class="fa fa-user fa-2x not-selected" style="color: red;" data-student="' . htmlspecialchars($student) . '" onclick="toggleSelection(this)"></i>';
        echo '<label class="form-check-label mt-2">' . htmlspecialchars($student) . '</label>';
        echo '</div>';
        echo '</div>';
    }
}
?>
