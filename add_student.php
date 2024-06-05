<?php
include 'db_connect.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $college_name = $_POST['college_name'];
    $project_name = $_POST['project_name'];
    $date_of_joining = $_POST['date_of_joining'];

    $sql = "INSERT INTO students (name, email, role, college_name, project_name, date_of_joining) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $email, $role, $college_name, $project_name, $date_of_joining]);

    $message = "Student added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
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
    <script>
        function toggleInternshipFields() {
            var role = document.getElementById('role').value;
            var internshipFields = document.getElementById('internship-fields');
            if (role === 'Internship') {
                internshipFields.style.display = 'block';
            } else {
                internshipFields.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Add Student</h2>
        <?php if (!empty($message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="role">Select Training/Internship:</label>
                <select class="form-control" id="role" name="role" onchange="toggleInternshipFields()" required>
                    <option value="">Select Role</option>
                    <option value="Training">Training</option>
                    <option value="Internship">Internship</option>
                </select>
            </div>
            <div id="internship-fields" style="display: none;">
                <div class="form-group">
                    <label for="college_name">College Name:</label>
                    <input type="text" class="form-control" id="college_name" name="college_name">
                </div>
            </div>
            <div class="form-group">
                <label for="project_name">Project Name:</label>
                <select class="form-control" id="project_name" name="project_name">
                    <option value="">Select Project</option>
                    <?php
                        // Fetch project names from the project table
                        $sql = "SELECT project_name FROM projects";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $projects = $stmt->fetchAll(PDO::FETCH_COLUMN);

                        // Output options for each project name
                        foreach ($projects as $project) {
                            echo "<option value='" . htmlspecialchars($project) . "'>" . htmlspecialchars($project) . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date_of_joining">Date of Joining:</label>
                <input type="date" class="form-control" id="date_of_joining" name="date_of_joining" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Student</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
            <a href="dashboard.html" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
