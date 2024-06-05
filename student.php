<?php
session_start(); // Start the session

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
    header("Location: login.php"); // Redirect to login if not logged in or not a student
    exit();
}

require_once 'db_connect.php';

$email = $_SESSION['email']; // Get the logged-in user's email

// Fetch the user's name from the database
$sql_username = "SELECT name FROM students WHERE email = :email";
$stmt = $conn->prepare($sql_username);
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Handle the case where user's data is not found in the database
    echo "User not found";
    exit();
}

$username = $user['name']; // Get the logged-in user's name

// Fetch the latest notification for students or staff and students
$sql_notification = "SELECT notification FROM notification WHERE to_role IN ('student', 'staff and students') ORDER BY created_at DESC LIMIT 2";
$stmt_notification = $conn->prepare($sql_notification);
$stmt_notification->execute();

if ($stmt_notification->rowCount() > 0) {
    $latest_notification = $stmt_notification->fetch(PDO::FETCH_ASSOC)['notification'];
} else {
    $latest_notification = "No new notifications";
}

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="dashboard2.css">
  <link rel="icon" href="logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .username  {
        margin-top: 100px;
        color: white;
    }
    body {
        font-family: Arial, sans-serif;
    }
    .sidebar {
        height: 100%;
        width: 236px;
        position: fixed;
        top: 15px;
        left: -250px;
        background-color: #111;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 20px;
    }
    .sidebar h2, .sidebar ul, .sidebar li, .sidebar a {
        color: white;
        text-decoration: none;
    }
    .sidebar ul {
        list-style-type: none;
        padding: 0;
    }
    .sidebar ul li {
        padding: 8px 16px;
        text-align: left;
    }
    .sidebar ul li a {
        color: white;
        display: block;
    }
    .sidebar ul li a:hover {
        background-color: #575757;
    }
    .open-btn {
        font-size: 30px;
        cursor: pointer;
        color: #111;
        position: absolute;
        top: 20px;
        left: 20px;
    }
    .notification-pane {
        height: 90%;
        width: 200px;
        position: fixed;
        top: 80px;
        right: 0;
        background-image: url("sidebar.jpg");
        overflow-y: auto;
        padding-top: 20px;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
        border-radius: 10px;
    }
    .notification-pane h2 {
        color: #fff;
        text-align: center;
    }
    .notification-pane p {
        color: #fff;
        padding: 10px;
        margin-right: 10px;
        margin-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }
  </style>
  </head>
<body>
  <header>
    <nav>
      <i class="fa fa-bars open-btn" aria-hidden="true" onclick="toggleSidebar()" style="color: white;"></i>
      <a href="index.html">
        <img src="legends.png" alt="Legends Tech Solution Logo" height="40">
      </a>
    </nav>
  </header>
  
  <div class="sidebar" id="sidebar">
    <h2>Menu</h2>
    <ul>
      <li><a href="dailyactivity.php"><i class="fas fa-calendar-alt"></i> Daily Activities</a></li>
      <li><a href="queries.php"><i class="fas fa-question-circle"></i> Queries</a></li>
      <li><a href="studentprofile.php"><i class="fas fa-user"></i> My Profile</a></li> 
      <li><a href="#" onclick="confirmLogout()"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>

  <div class="main username">
    <center>
      <h1>Student Dashboard</h1> 
      <h1>Hello <?php echo htmlspecialchars($username); ?>,</h1>
    </center>
  </div>

  <div class="notification-pane" id="notification-pane">
    <h2>Notifications</h2>
    <marquee behavior="scroll" direction="up" scrollamount="2">
      <p><?php echo htmlspecialchars($latest_notification); ?></p>
    </marquee>
  </div>

  <footer>
    <!-- Footer content -->
  </footer>

  <script src="script.js"></script>
  <script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        if (sidebar.style.left === '-250px') {
            sidebar.style.left = '0';
        } else {
            sidebar.style.left = '-250px';
        }
    }
    function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        window.location.href = "index.html"; // Replace "logout.php" with the actual logout script
    }
}
  </script>
</body>
</html>
