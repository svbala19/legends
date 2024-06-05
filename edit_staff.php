<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the staff details
    $sql = "SELECT * FROM staff WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$staff) {
        echo "Staff member not found.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Update staff details
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $sql = "UPDATE staff SET name = :name, email = :email, role = :role WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: manage_staff.php");
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <h2 class="mb-4">Edit Staff</h2>
        <form method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($staff['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($staff['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <input type="text" name="role" class="form-control" value="<?= htmlspecialchars($staff['role']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
