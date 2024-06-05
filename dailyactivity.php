<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activity = $_POST['activity'];
    $activity_type = $_POST['activity_type'];

    if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
        $login_user = $_SESSION['username'];
        $user_role = $_SESSION['role'];
    } else {
        die("User not logged in. Please log in first.");
    }

    $host = "localhost";
    $dbname = "legends";
    $username = "root";
    $db_password = "";

    $conn = new mysqli($host, $username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL query to insert the daily activity
    $stmt = $conn->prepare("INSERT INTO dailyactivity (activity, activity_type, date, login_user, user_role) VALUES (?, ?, CURRENT_DATE(), ?, ?)");
    $stmt->bind_param("ssss", $activity, $activity_type, $login_user, $user_role);

    if ($stmt->execute()) {
        echo "<script>alert('Daily activity added successfully');</script>";
    } else {
        echo "<script>alert('Failed to add daily activity');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daily Activity</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
        background-image: url('bgimage.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        margin-top: 100px; /* Adjust the margin-top value as needed */
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Daily Activity Form</h3>
          </div>
          <div class="card-body">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="form-group">
                <label for="activity_type">Activity Type:</label>
                <select class="form-control" id="activity_type" name="activity_type" required>
                  <?php
                  if (isset($_SESSION['role']) && $_SESSION['role'] == 'student') {
                    echo '
                    <option value="Technical Training and Learning Sessions">Technical Training and Learning Sessions</option>
                    <option value="Hands-On Project Work">Hands-On Project Work</option>
                    <option value="Mentorship and Supervision">Mentorship and Supervision</option>
                    <option value="Team Meetings and Stand-Ups">Team Meetings and Stand-Ups</option>
                    <option value="Skill Development and Soft Skills Training">Skill Development and Soft Skills Training</option>
                    <option value="Evaluation and Feedback">Evaluation and Feedback</option>
                    <option value="Documentation and Reporting">Documentation and Reporting</option>
                    <option value="Problem Solving and Debugging">Problem Solving and Debugging</option>
                    <option value="Research and Innovation">Research and Innovation</option>
                    <option value="Client Interaction">Client Interaction</option>
                    <option value="Self-Study and Personal Projects">Self-Study and Personal Projects</option>
                    ';
                  } else if (isset($_SESSION['role']) && $_SESSION['role'] == 'staff') {
                    echo '
                    <option value="Attendance and Scheduling">Attendance and Scheduling</option>
                    <option value="Performance Monitoring">Performance Monitoring</option>
                    <option value="Training and Development">Training and Development</option>
                    <option value="Project Management">Project Management</option>
                    <option value="Communication and Coordination">Communication and Coordination</option>
                    <option value="Documentation and Reporting">Documentation and Reporting</option>
                    <option value="Administrative Tasks">Administrative Tasks</option>
                    ';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="activity">Activity:</label>
                <input type="text" class="form-control" id="activity" name="activity" required>
              </div>
              
              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="<?php echo ($_SESSION['role'] == 'staff') ? 'staff.php' : 'student.php'; ?>" class="btn btn-secondary">Back</a>

              <button type="reset" class="btn btn-warning ml-2">Clear</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
