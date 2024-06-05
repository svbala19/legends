<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            color: white;
            background-image: url('bgimage.jpg'); /* Set background image */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* No repeating of the background image */
            padding: 20px; /* Add padding to the body */
        }
        .container {
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            padding: 20px;
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Box shadow */
        }
        h1 {
            text-align: center; /* Center align the heading */
        }
        p {
            margin-bottom: 10px; /* Add some space between paragraphs */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Profile</h1>
        <?php
        session_start(); // Start the session

        if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
            header("Location: login.php"); // Redirect to login if not logged in or not a student
            exit();
        }

        require_once 'db_connect.php';

        $email = $_SESSION['email']; // Get the logged-in user's email

        // Fetch the user's details from the database
        $sql_user_details = "SELECT * FROM students WHERE email = :email";
        $stmt = $conn->prepare($sql_user_details);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user_details = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user_details) {
            echo "<p>User details not found.</p>";
            exit();
        }

        // Fetch the attendance percentage of the student
        $sql_attendance = "SELECT AVG(attendance_percentage) AS attendance_percentage 
                           FROM attendance 
                           WHERE student_name = :student_name";
        $stmt = $conn->prepare($sql_attendance);
        $stmt->bindParam(':student_name', $user_details['name']);
        $stmt->execute();
        $attendance_result = $stmt->fetch(PDO::FETCH_ASSOC);
        $attendance_percentage = $attendance_result ? round($attendance_result['attendance_percentage'], 2) : 0;

        // Fetch the project name and team leader (TL) assigned to the student
        $sql_project_details = "SELECT projects.project_name, staff.name AS project_tl 
                                FROM projects 
                                INNER JOIN staff ON projects.project_tl = staff.id 
                                WHERE projects.student_id = :student_id";
        $stmt = $conn->prepare($sql_project_details);
        $stmt->bindParam(':student_id', $user_details['id']);
        $stmt->execute();
        $project_details = $stmt->fetch(PDO::FETCH_ASSOC);
        $project_name = $project_details ? $project_details['project_name'] : 'No project assigned';
        $project_tl = $project_details ? $project_details['project_tl'] : 'No TL assigned';

        // Close the database connection
        $conn = null;
        ?>
        <div>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user_details['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_details['email']); ?></p>
            <p><strong>Date of Joining:</strong> <?php echo htmlspecialchars($user_details['date_of_joining']); ?></p>
            <p><strong>Attendance Percentage:</strong> <?php echo htmlspecialchars($attendance_percentage); ?>%</p>
            <p><strong>Project Assigned:</strong> <?php echo htmlspecialchars($project_name); ?></p>
            <p><strong>Project Team Leader (TL):</strong> <?php echo htmlspecialchars($project_tl); ?></p>
        </div>
    </div>
</body>
</html>
