<?php
session_start(); // Start the session

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php"); // Redirect to login if not logged in or not a staff member
    exit();
}

require_once 'db_connect.php';

$email = $_SESSION['email']; // Get the logged-in user's email

// Fetch the user's name from the database
$sql_username = "SELECT name FROM staff WHERE email = :email";
$stmt = $conn->prepare($sql_username);
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Handle the case where user's data is not found in the database
    // For example, redirect to an error page or display an error message
}

$username = $user['name']; // Get the logged-in user's name

// Fetch the latest notification for students or staff and students
$sql_notification = "SELECT notification FROM notification WHERE to_role IN ('staff', 'staff and students') ORDER BY created_at DESC LIMIT 1";
$result_notification = $conn->query($sql_notification);
if ($result_notification->rowCount() > 0) {
    $latest_notification = $result_notification->fetch(PDO::FETCH_ASSOC)['notification'];
} else {
    $latest_notification = "No new notifications";
}

require_once 'db_connect.php';

// Fetch the latest notification for staff or staff and students
$sql_notification = "SELECT notification FROM notification WHERE to_role IN ('staff', 'staff and students') ORDER BY created_at DESC LIMIT 1";
$result_notification = $conn->query($sql_notification);
if ($result_notification->rowCount() > 0) {
    $latest_notification = $result_notification->fetch(PDO::FETCH_ASSOC)['notification'];
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
  <title>Staff Dashboard</title>
  <link rel="stylesheet" href="dashboard2.css">
  <link rel="icon" href="logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .username  {
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
        box-radius: 10px;
        ;
    }
    .notification-pane h2 {
        color: #fff;
        text-align: center;
    }
    .notification-pane p {
        color: #fff;
        padding: 10px;
        margin right: 10px;
        margin down: 100px;
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
        <li><a href="attendance.php"><i class="fas fa-check-circle"></i> Attendance</a></li>
        <li><a href="view_attendance.php"><i class="fas fa-check-circle"></i>View Attendance</a></li>
        <li><a href="staffprofile.php"><i class="fas fa-user"></i> My Profile</a></li>
        <li><a href="#" onclick="confirmLogout()"><i class="fas fa-sign-out-alt"></i> Logout</a></li>

  </ul>

  </div>


  <div class="main username">
      </br></br></br></br></br>
        <center><h1>Staff Dashboard</h1> 
        
        <h1> Hello <span class="username"><?php echo htmlspecialchars($username); ?></span>,</h1>
        
        <!-- Rest of the content -->
    </div>

    
    
    <div class="notification-pane" id="notification-pane">
    <h2>Notifications</h2>
    <marquee behavior="scroll" direction="up" scrollamount="2">
      <p><?php echo $latest_notification; ?></p>
    </marquee>
  </div>
  
  <script>
      // Fetch notification content from the server and display it
      window.onload = function () {
          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function () {
              if (xhr.readyState === XMLHttpRequest.DONE) {
                  if (xhr.status === 200) {
                      document.getElementById('notificationContent').textContent = xhr.responseText;
                      document.getElementById('notification').style.display = 'block';
                  } else {
                      console.error('Failed to fetch notification!');
                  }
              }
          };
          xhr.open('GET', 'fetch_notification.php', true);
          xhr.send();
      };
  </script>
  
  <div id="daily-activities" style="display: none;">
    <h2>Daily Activities</h2>
    <form id="daily-activities-form" action="daq.php" method="post"> <!-- Corrected form action and method -->
      <input type="text" name="activity" placeholder="Today's Activity">
      <button type="submit">Submit</button>
    </form>
  </div>
  
  <div id="queries" style="display: none;">
    <h2>Queries</h2>
    <form id="queries-form" action="daq.php" method="post"> <!-- Corrected form action and method -->
      <input type="text" name="query" placeholder="Enter your Queries">
      <button type="submit">Submit</button>
    </form>
  </div>
  
        <div class="content" id="attendance" style="display: none;">
          <h2>Attendance</h2>
        </div>
  <footer>
    <!-- Footer content -->
  </footer>

  <script src="script.js"></script>
  <script>
    function toggleMenu(menuId) {
      var menus = document.querySelectorAll('.main > div'); // Select all menu divs in the main section
      var clickedMenu = document.getElementById(menuId); // Get the clicked menu div

      for (var i = 0; i < menus.length; i++) {
        if (menus[i] === clickedMenu) {
          if (menus[i].style.display === 'none') {
            menus[i].style.display = 'block'; // Show the clicked menu
          } else {
            menus[i].style.display = 'none'; // Hide the clicked menu
          }
        } else {
          menus[i].style.display = 'none'; // Hide other menus
        }
      }
    }

  //for fa fa-bar function
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