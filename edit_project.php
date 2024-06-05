<?php
// Include your database connection script
include 'db_connect.php';

// Check if project ID is provided
if(isset($_GET['id'])) {
    $project_id = $_GET['id'];

    // Fetch project details from the database
    $sql = "SELECT p.*, s.name AS team_leader_name 
            FROM projects p 
            INNER JOIN staff s ON p.project_tl = s.id 
            WHERE p.project_id = :project_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':project_id', $project_id);
    $stmt->execute();
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$project) {
        echo "Project not found.";
        exit;
    }
} else {
    echo "Project ID is missing.";
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated project details from the form
    $project_name = $_POST['project_name'];
    $project_tl = $_POST['project_tl'];

    // Update project details in the database
    $sql = "UPDATE projects SET project_name = :project_name, project_tl = :project_tl WHERE project_id = :project_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':project_name', $project_name);
    $stmt->bindParam(':project_tl', $project_tl);
    $stmt->bindParam(':project_id', $project_id);

    if ($stmt->execute()) {
        // Redirect to the manage projects page after successful update
        header("Location: manage_projects.php");
        exit;
    } else {
        echo "Error updating project.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
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
            max-width: 400px; /* Adjust the max-width to fit the minimal width you desire */
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Project</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="project_name" class="form-label">Project Name:</label>
                <input type="text" class="form-control" id="project_name" name="project_name" value="<?php echo $project['project_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="project_tl" class="form-label">Project Team Leader:</label>
                <select class="form-select" id="project_tl" name="project_tl" required>
                    <option value="<?php echo $project['project_tl']; ?>"><?php echo $project['team_leader_name']; ?></option>
                    <!-- Populate options dynamically from database -->
                    <?php
                    // Fetch staff members from the database
                    $sql = "SELECT id, name FROM staff";
                    $result = $conn->query($sql);

                    if ($result && $result->rowCount() > 0) {
                        // Output data of each row
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            // Exclude the current team leader from the dropdown list
                            if ($row['id'] != $project['project_tl']) {
                                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                            }
                        }
                    } else {
                        echo "<option value='' disabled>No staff members found</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Project</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Back</a> <!-- Add this line -->
        </form>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
