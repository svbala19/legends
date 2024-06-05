<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
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
            max-width: 400px; 
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-3 text-center">Add Project</h1>
        <form action="add_project_process.php" method="POST">
            <div class="mb-3">
                <label for="project_name" class="form-label">Project Name:</label>
                <input type="text" class="form-control" id="project_name" name="project_name" required>
            </div>
            <div class="mb-3">
                <label for="project_tl" class="form-label">Project Team Leader:</label>
                <select class="form-select" id="project_tl" name="project_tl" required>
                    <option value="">Select Team Leader</option>
                    <!-- Populate options dynamically from database -->
                    <?php
                    // Include your database connection script
                    include 'db_connect.php';

                    // Fetch staff members from the database
                    $sql = "SELECT id, name FROM staff";
                    $result = $conn->query($sql);

                    if ($result && $result->rowCount() > 0) {
                        // Output data of each row
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No staff members found</option>";
                    }

                    // Close the database connection
                    $conn = null;
                    ?>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Add Project</button>
                <button type="reset" class="btn btn-secondary">Clear</button>
                <a href="dashboard.html" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
    <script>
        function refreshPage() {
            location.reload();
        }
    </script>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

