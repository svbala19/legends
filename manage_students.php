<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background: url('bgimage.jpg') no-repeat center center fixed;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            margin-top: 500px;
            padding-top: 10px;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Manage Students</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th> <!-- Add this header for action buttons -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Include your database connection script
                include 'db_connect.php';

                // Fetch students from the database
                $sql = "SELECT * FROM students";
                $result = $conn->query($sql);

                if ($result && $result->rowCount() > 0) {
                    // Output data of each row
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["role"] . "</td>";
                        echo "<td>
                                <a href='edit_student.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a>
                                <a href='delete_student.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No students found</td></tr>";
                }

                // Close the database connection
                $conn = null;
                ?>
            </tbody>
        </table>
        <a href="dashboard.html" class="btn btn-secondary">Back</a>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
