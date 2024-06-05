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
$staff_name = $_SESSION['username'];

// Fetch roles from the students table
$sql_roles = "SELECT DISTINCT role FROM students";
$stmt_roles = $conn->prepare($sql_roles);
$stmt_roles->execute();
$roles = $stmt_roles->fetchAll(PDO::FETCH_COLUMN);

// Process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $date = $_POST['date'];
    $session = $_POST['session'];
    $students = isset($_POST['students']) ? json_decode($_POST['students'], true) : [];

    // Extract day, month, and year from the date
    $day = date('d', strtotime($date));
    $month = date('m', strtotime($date));
    $year = date('Y', strtotime($date));

    // Insert attendance data into the attendance table
    try {
        foreach ($students as $student_name => $attendance_status) {
            $attendance = ($attendance_status == 'present') ? 'Present' : 'Absent';
            $sql_insert = "INSERT INTO attendance (staff_name, role, student_name, attendance, date, session, day, month, year) VALUES (:staff_name, :role, :student_name, :attendance, :date, :session, :day, :month, :year)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bindParam(':staff_name', $staff_name);
            $stmt_insert->bindParam(':role', $role);
            $stmt_insert->bindParam(':student_name', $student_name);
            $stmt_insert->bindParam(':attendance', $attendance);
            $stmt_insert->bindParam(':date', $date);
            $stmt_insert->bindParam(':session', $session);
            $stmt_insert->bindParam(':day', $day);
            $stmt_insert->bindParam(':month', $month);
            $stmt_insert->bindParam(':year', $year);
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
            display: inline-block;
            text-align: center;
            margin-right: 20px;
            margin-bottom: 20px;
        }
        .icon-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .selected {
            color: green !important;
        }
        .not-selected {
            color: red !important;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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

        function clearForm() {
            document.getElementById('attendance-form').reset();
            selectedStudents = {}; // Clear the selected students object
            document.getElementById('student-list').innerHTML = ''; // Clear the student list
        }

        function markAll(status) {
            $('#student-list i').each(function() {
                var studentName = this.getAttribute('data-student');
                if (status === 'present') {
                    this.classList.remove('not-selected');
                    this.classList.add('selected');
                    selectedStudents[studentName] = 'present';
                } else {
                    this.classList.remove('selected');
                    this.classList.add('not-selected');
                    selectedStudents[studentName] = 'absent';
                }
            });
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
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="attendance-form" onsubmit="prepareStudentsData()">
            <div class="form-group">
                <label>Attendance Taken By:</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($staff_name); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="">Select Role</option>
                    <?php foreach ($roles as $role) : ?>
                        <option value="<?php echo htmlspecialchars($role); ?>"><?php echo htmlspecialchars($role); ?></option>
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
                <div>
                    <button type="button" class="btn btn-success" onclick="markAll('present')">Mark All Present</button>
                    <button type="button" class="btn btn-danger" onclick="markAll('absent')">Mark All Absent</button>
                </div>
                <div id="student-list" class="mt-3">
                    <!-- Student list will be populated here -->
                </div>
            </div>
            <input type="hidden" name="students" id="students-input">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="dashboard.html" class="btn btn-secondary">Back</a>
            <button type="button" class="btn btn-warning" onclick="clearForm()">Clear</button>
        </form>
    </div>
</body>
</html>
