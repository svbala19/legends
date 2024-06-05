<?php
// Include the database connection file
require_once 'db_connect.php';

// Retrieve roles from the database
$sql_roles = "SELECT 'staff' AS user_role UNION SELECT 'student' AS user_role UNION SELECT 'staff and students' AS user_role";
$roles = array();
$result_roles = $conn->query($sql_roles);
if ($result_roles->rowCount() > 0) {
    while ($row = $result_roles->fetch(PDO::FETCH_ASSOC)) {
        $roles[] = $row['user_role'];
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form input
    $notification = htmlspecialchars($_POST['notification']);
    $to = htmlspecialchars($_POST['to']);
    
    // Get current date and time
    $currentTime = date("Y-m-d H:i:s");
    
    // Prepare the SQL insert statement
    $sql_insert = "INSERT INTO notification (notification, to_role, created_at) VALUES (:notification, :to, :created_at)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bindParam(':notification', $notification);
    $stmt->bindParam(':created_at', $currentTime);

    // Insert notification into the database
    if ($to == 'staff and students') {
        // Insert separate notifications for 'staff' and 'student'
        $to_roles = ['staff', 'student'];
        foreach ($to_roles as $role) {
            $stmt->bindParam(':to', $role);
            $stmt->execute();
        }
    } else {
        // Insert notification for the selected role
        $stmt->bindParam(':to', $to);
        $stmt->execute();
    }
    
    // Redirect to update_notification.php with a success message
    header("Location: update_notification.php?success=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Notification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('bgimage.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Update Notification</h1>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                Notification updated successfully!
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="notification">Notification:</label>
                <textarea class="form-control" id="notification" name="notification" rows="4" cols="50"></textarea>
            </div>
            <div class="form-group">
                <label for="to">To:</label>
                <select class="form-control" id="to" name="to">
                    <?php foreach ($roles as $role) : ?>
                        <option value="<?php echo htmlspecialchars($role); ?>"><?php echo htmlspecialchars($role); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            
            <a href="dashboard.html" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
