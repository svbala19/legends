<?php
include 'db_connect.php';

$sql = "SELECT * FROM students";
$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group students by role
$roles = [];
foreach ($students as $student) {
    $roles[$student['role']][] = $student;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
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
        <h2>View Students</h2>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <?php foreach ($roles as $role => $students): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $role === array_key_first($roles) ? 'active' : ''; ?>" id="<?php echo $role; ?>-tab" data-toggle="tab" href="#<?php echo $role; ?>" role="tab" aria-controls="<?php echo $role; ?>" aria-selected="<?php echo $role === array_key_first($roles) ? 'true' : 'false'; ?>">
                        <?php echo ucfirst($role); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content" id="myTabContent">
            <?php foreach ($roles as $role => $students): ?>
                <div class="tab-pane fade <?php echo $role === array_key_first($roles) ? 'show active' : ''; ?>" id="<?php echo $role; ?>" role="tabpanel" aria-labelledby="<?php echo $role; ?>-tab">
                    <table class="table table-bordered mt-3">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <?php if ($role !== 'training'): ?>
                                    <th>College Name</th>
                                <?php endif; ?>
                                <th>Project Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= htmlspecialchars($student['id']) ?></td>
                                    <td><?= htmlspecialchars($student['name']) ?></td>
                                    <td><?= htmlspecialchars($student['email']) ?></td>
                                    <?php if ($role !== 'training'): ?>
                                        <td><?= htmlspecialchars($student['college_name']) ?></td>
                                    <?php endif; ?>
                                    <td><?= htmlspecialchars($student['project_name']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
