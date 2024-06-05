<?php
// Include the database connection file
require_once 'db_connect.php';

// Query to fetch staff queries from the queries table
$sql_staff = "SELECT * FROM queries WHERE user_role = 'staff'";
$result_staff = $conn->query($sql_staff);

// Query to fetch student queries from the queries table
$sql_student = "SELECT * FROM queries WHERE user_role = 'student'";
$result_student = $conn->query($sql_student);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Queries</title>
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
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="staff-tab" data-toggle="tab" href="#staff" role="tab" aria-controls="staff" aria-selected="true">Staff Queries</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="student-tab" data-toggle="tab" href="#student" role="tab" aria-controls="student" aria-selected="false">Student Queries</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="staff" role="tabpanel" aria-labelledby="staff-tab">
                <h1 class="mt-4 mb-4">Staff Queries</h1>
                <?php if ($result_staff->rowCount() > 0) { ?>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Query Type</th>
                                <th>Query</th>
                                <th>Date</th>
                                <th>Login User</th>
                                <th>User Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_staff->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['query_type']); ?></td>
                                    <td><?php echo htmlspecialchars($row['query']); ?></td>
                                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['login_user']); ?></td>
                                    <td><?php echo htmlspecialchars($row['user_role']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No staff queries found.</p>
                <?php } ?>
            </div>
            <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
                <h1 class="mt-4 mb-4">Student Queries</h1>
                <?php if ($result_student->rowCount() > 0) { ?>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Query Type</th>
                                <th>Query</th>
                                <th>Date</th>
                                <th>Login User</th>
                                <th>User Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_student->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['query_type']); ?></td>
                                    <td><?php echo htmlspecialchars($row['query']); ?></td>
                                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['login_user']); ?></td>
                                    <td><?php echo htmlspecialchars($row['user_role']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No student queries found.</p>
                <?php } ?>
            </div>
            <a href="dashboard.html" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn = null;
?>
