<?php
session_start(); // Start the session

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php"); // Redirect if not logged in or not a staff member
    exit();
}

require_once 'db_connect.php';

$email = $_SESSION['email']; // Get the logged-in staff member's email

// Fetch the staff member's details from the database
$sql_staff_details = "SELECT * FROM staff WHERE email = :email";
$stmt = $conn->prepare($sql_staff_details);
$stmt->bindParam(':email', $email);
$stmt->execute();
$staff_details = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$staff_details) {
    // Handle the case where staff member's data is not found in the database
    // For example, redirect to an error page or display an error message
}

// Fetch the projects assigned to the staff member
$sql_assigned_projects = "SELECT projects.project_name 
                          FROM projects 
                          WHERE projects.project_tl = :staff_id";
$stmt = $conn->prepare($sql_assigned_projects);
$stmt->bindParam(':staff_id', $staff_details['id']);
$stmt->execute();
$assigned_projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Profile</title>
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
            text-align: center; 
        }
        p {
            margin-bottom: 10px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Profile</h1>
        <div>
            <p><strong>Name:</strong> <?php echo $staff_details['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $staff_details['email']; ?></p>
            <p><strong>Role:</strong> <?php echo $staff_details['role']; ?></p>
            <p><strong>Projects Assigned:</strong></p>
            <ul>
                <?php foreach ($assigned_projects as $project) { ?>
                    <li><?php echo $project['project_name']; ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</body>
</html>
