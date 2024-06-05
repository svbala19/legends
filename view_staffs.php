<?php
include 'db_connect.php';

$sql = "SELECT * FROM staff";
$stmt = $conn->prepare($sql);
$stmt->execute();
$staff_members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('bgimage.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            background-color: white;
        }
        .back-button {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
    <a href="dashboard.html" class="btn btn-secondary">Back</a>
        <h2>View Staff</h2>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($staff_members as $staff): ?>
                    <tr>
                        <td><?= htmlspecialchars($staff['id']) ?></td>
                        <td><?= htmlspecialchars($staff['name']) ?></td>
                        <td><?= htmlspecialchars($staff['email']) ?></td>
                        <td><?= htmlspecialchars($staff['role']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
    
</body>
</html>
