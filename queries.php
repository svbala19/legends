<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = $_POST['query'];
    $query_type = $_POST['query_type'];
    
    // Get the logged-in user's name and role from the session
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

    // Prepare and execute SQL query to insert the query
    $stmt = $conn->prepare("INSERT INTO queries (query, query_type, date, login_user, user_role) VALUES (?, ?, CURRENT_DATE(), ?, ?)");
    $stmt->bind_param("ssss", $query, $query_type, $login_user, $user_role);

    if ($stmt->execute()) {
        echo "<script>alert('Query submitted successfully');</script>";
    } else {
        echo "<script>alert('Failed to submit query');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Queries</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
        background-image: url('bgimage.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        margin-top: 100px; 
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Query Form</h3>
          </div>
          <div class="card-body">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="form-group">
                <label for="query_type">Query Type:</label>
                <select class="form-control" id="query_type" name="query_type" required>
                  <?php
                  if (isset($_SESSION['role']) && $_SESSION['role'] == 'student') {
                    echo '
                    <option value="Technical Queries">Technical Queries</option>
                    <option value="Programming and Coding Issues">Programming and Coding Issues</option>
                    <option value="Tools and Software">Tools and Software</option>
                    <option value="System and Network Issues">System and Network Issues</option>
                    <option value="Project-Related Queries">Project-Related Queries</option>
                    <option value="Task Clarifications">Task Clarifications</option>
                    <option value="Progress and Feedback">Progress and Feedback</option>
                    <option value="Collaboration and Communication">Collaboration and Communication</option>
                    <option value="Administrative Queries">Administrative Queries</option>
                    <option value="Onboarding and Documentation">Onboarding and Documentation</option>
                    <option value="Policies and Procedures">Policies and Procedures</option>
                    <option value="Schedules and Meetings">Schedules and Meetings</option>
                    <option value="Career Development Queries">Career Development Queries</option>
                    <option value="Skill Development">Skill Development</option>
                    <option value="Mentorship and Guidance">Mentorship and Guidance</option>
                    <option value="Performance Reviews">Performance Reviews</option>
                    <option value="HR and Benefits Queries">HR and Benefits Queries</option>
                    <option value="Compensation and Benefits">Compensation and Benefits</option>
                    <option value="Leave and Absence">Leave and Absence</option>
                    <option value="Conflict Resolution">Conflict Resolution</option>
                    <option value="IT Support Queries">IT Support Queries</option>
                    ';
                  } else if (isset($_SESSION['role']) && $_SESSION['role'] == 'staff') {
                    echo '
                    <option value="Onboarding and Orientation Queries">Onboarding and Orientation Queries</option>
                    <option value="Training Program Queries">Training Program Queries</option>
                    <option value="Technical Support Queries">Technical Support Queries</option>
                    <option value="Mentorship and Guidance Queries">Mentorship and Guidance Queries</option>
                    <option value="Project and Task Management Queries">Project and Task Management Queries</option>
                    <option value="Administrative and Logistical Queries">Administrative and Logistical Queries</option>
                    <option value="Performance and Feedback Queries">Performance and Feedback Queries</option>
                    <option value="Policy and Compliance Queries">Policy and Compliance Queries</option>
                    ';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="query">Query:</label>
                <textarea class="form-control" id="query" name="query" rows="4" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="<?php echo ($_SESSION['role'] == 'staff') ? 'staff.php' : 'student.php'; ?>" class="btn btn-secondary">Back</a>

              <button type="reset" class="btn btn-danger">Clear</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

