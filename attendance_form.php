<?php
session_start(); // Start the session

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php"); // Redirect to login if not logged in or not a staff member
    exit();
}

require_once 'db_connect.php';

// Initialize a success message variable
$success_message = "";
$error_message = ""; // Initialize an error message variable

// Fetch staff names from the staff table
$sql_staff = "SELECT name FROM staff";
$stmt_staff = $conn->prepare($sql_staff);
$stmt_staff->execute();
$staff_names = $stmt_staff->fetchAll(PDO::FETCH_COLUMN);

// Fetch roles from the students table
$sql_roles = "SELECT DISTINCT role FROM students";
$stmt_roles = $conn->prepare($sql_roles);
$stmt_roles->execute();
$roles = $stmt_roles->fetchAll(PDO::FETCH_COLUMN);

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_name = $_POST['staff'];
    $role = $_POST['role'];
    $date = $_POST['date'];
    $session = $_POST['session'];
    $students = isset($_POST['students']) ? json_decode($_POST['students'], true) : [];

    // Insert attendance data into the attendance table
    try {
        foreach ($students as $student_name => $attendance_status) {
            $attendance = ($attendance_status == 'present') ? 'Present' : 'Absent';
            $sql_insert = "INSERT INTO attendance (staff_name, role, student_name, attendance, date, session) VALUES (:staff_name, :role, :student_name, :attendance, :date, :session)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bindParam(':staff_name', $staff_name);
            $stmt_insert->bindParam(':role', $role);
            $stmt_insert->bindParam(':student_name', $student_name);
            $stmt_insert->bindParam(':attendance', $attendance);
            $stmt_insert->bindParam(':date', $date);
            $stmt_insert->bindParam(':session', $session);
            $stmt_insert->execute();
        }
        // Set success message
        $success_message = "Attendance has been successfully recorded.";
    } catch (PDOException $e) {
        // Set error message
        $error_message = "Error recording attendance: " . $e->getMessage();
    }
}

// Close the database connection
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-image: url('bgimage.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin-top: 50px; /* Adjust the margin-top value as needed */
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Add transparency to the container */
            padding: 20px;
            border-radius: 10px;
        }
        .student {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .student i {
            margin-right: 10px;
            cursor: pointer;
        }
        .selected {
            color: green !important;
        }
        .not-selected {
            color: red !important;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Attendance Form</h2>
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="prepareStudentsData()">
            <div class="form-group">
                <label for="staff">Attendance Taken By:</label>
                <select class="form-control" id="staff" name="staff" required>
                    <option value="">Select Staff</option>
                    <?php foreach ($staff_names as $name) : ?>
                        <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="">Select Role</option>
                    <?php foreach ($roles as $role) : ?>
                        <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Date:</label>
                <input type="date" class="form-control" name="date" required>
            </div>
            <div class="form-group">
                <label>Session:</label>
                <select class="form-control" name="session" required>
                    <option value="Morning">Morning</option>
                    <option value="Afternoon">Afternoon</option>
                    <option value="Evening">Evening</option>
                </select>
            </div>
            <div class="form-group">
                <label>Students:</label>
                <div id="student-list">
                    <!-- Student list will be populated here -->
                </div>
            </div>
            <input type="hidden" name="students" id="students-input">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        var selectedStudents = {}; // Object to store selected students

        function toggleSelection(icon) {
            var studentName = icon.getAttribute('data-student');

            if (icon.classList.contains('not-selected')) {
                icon.classList.remove('not-selected');
                icon.classList.add('selected');
                selectedStudents[studentName] = 'present'; // Mark as present
            } else {
                icon.classList.remove('selected');
                icon.classList.add('not-selected');
                selectedStudents[studentName] = 'absent'; // Mark as absent
            }
        }

        function prepareStudentsData() {
            document.getElementById('students-input').value = JSON.stringify(selectedStudents);
        }

        $(document).ready(function() {
            $('#role').change(function() {
                var role = $(this).val();
                if (role) {
                    $.ajax({
                        url: 'fetch_students.php',
                        type: 'POST',
                        data: {role: role},
                        success: function(response) {
                            $('#student-list').html(response);
                        },
                        error: function() {
                            $('#student-list').html('<div class="alert alert-danger">Failed to fetch student list. Please try again.</div>');
                        }
                    });
                } else {
                    $('#student-list').html('');
                }
            });
        });
    </script>
</body>
</html>
