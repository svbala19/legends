<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('bgimage.jpg');
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
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Manage Projects</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Project Name</th>
                    <th>Project TL</th>
                    <th>Action</th> <!-- Add this header for action buttons -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Include your database connection script
                include 'db_connect.php';

                // Fetch projects with project team leader names from the database
                $sql = "SELECT p.project_id, p.project_name, s.name AS project_tl 
                        FROM projects p 
                        INNER JOIN staff s ON p.project_tl = s.id";
                $result = $conn->query($sql);

                if ($result && $result->rowCount() > 0) {
                    // Output data of each row
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row["project_id"] . "</td>";
                        echo "<td>" . $row["project_name"] . "</td>";
                        echo "<td>" . $row["project_tl"] . "</td>";
                        echo "<td>
                                <a href='edit_project.php?id=" . $row['project_id'] . "' class='btn btn-primary'>Edit</a>
                                <a href='delete_project.php?id=" . $row['project_id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this project?\")'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No projects found</td></tr>";
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
