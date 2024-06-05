<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="form.css">
</head>
<body>
  <div class="overlay" id="overlay"></div>
  
  <div class="login-container" id="loginContainer">
    <h2>Internship and Training Program <br> Management System Login</h2>
    <form id="login-form" action="login.php" method="post">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
  
  <?php
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $host = "localhost";
    $dbname = "legends";
    $username = "root";
    $db_password = "";

    $conn = new mysqli($host, $username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($email == "admin@gmail.com" && $password == "admin") {
        $_SESSION['username'] = 'Admin'; // Store admin name in session
        $_SESSION['role'] = 'admin';
        $_SESSION['email'] = $email; // Store admin email in session
        header("Location: dashboard.html");
        exit;
    } else {
        // Check in the staff table
        $stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password == "staff") {
                $_SESSION['username'] = $user['name']; // Store staff name in session
                $_SESSION['role'] = 'staff';
                $_SESSION['email'] = $user['email']; // Store email in session
                header("Location: staff.php");
                exit;
            }
        }

        // Check in the students table
        $stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password == "student") {
                $_SESSION['username'] = $user['name']; // Store student name in session
                $_SESSION['role'] = 'student';
                $_SESSION['email'] = $user['email']; // Store email in session
                header("Location: student.php");
                exit;
            }
        }

        echo "<script>alert('Invalid email or password');</script>";
    }

    $conn->close();
}
?>



</body>
</html>
