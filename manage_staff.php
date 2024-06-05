<?php
// Include your database connection script
include 'db_connect.php';

// Fetch staff members from the database
$sql = "SELECT * FROM staff";
$stmt = $conn->query($sql);
$staff_members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('bgimage.jpg') no-repeat center center fixed;
            background-size: cover;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            max-width: 800px;
            border-radius: 10px;
            margin-top: 50px;
            margin-bottom: 20px; /* Add margin-bottom */
        }
        .table-container {
            margin-top: 20px; /* Add margin-top */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Manage Staff</h2>
        <div class="table-container"> <!-- Add this div -->
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($staff_members as $staff): ?>
                        <tr>
                            <td><?= htmlspecialchars($staff['id']) ?></td>
                            <td><?= htmlspecialchars($staff['name']) ?></td>
                            <td><?= htmlspecialchars($staff['email']) ?></td>
                            <td><?= htmlspecialchars($staff['role']) ?></td>
                            <td>
                                <a href="edit_staff.php?id=<?= htmlspecialchars($staff['id']) ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="delete_staff.php?id=<?= htmlspecialchars($staff['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this staff member?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="dashboard.html" class="btn btn-secondary">Back</a>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
