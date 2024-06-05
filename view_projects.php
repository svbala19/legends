<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Projects</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
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
        table {
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">View Projects</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Project ID</th>
                    <th>Project Name</th>
                    <th>Project TL</th>
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
                        echo "<td>" . htmlspecialchars($row["project_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["project_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["project_tl"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No projects found</td></tr>";
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
