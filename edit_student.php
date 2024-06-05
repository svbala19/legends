<?php
include 'db_connect.php';

if(isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch student details from the database
    $sql = "SELECT * FROM students WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $student_id);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$student) {
        echo "Student not found.";
        exit;
    }
} else {
    echo "Student ID is missing.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated student details from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update student details in the database
    $sql = "UPDATE students SET name = :name, email = :email, role = :role WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':id', $student_id);

    if ($stmt->execute()) {
        // Redirect to the manage students page after successful update
        header("Location: manage_students.php");
        exit;
    } else {
        echo "Error updating student.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
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
</head>
<body>
    <div class="container">
                    <h2 class="mb-4">
                        Edit Student
    </h2>
                    <div class="card-body">
                        <?php if(isset($student)): ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $student['id']; ?>" method="post">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($student['name']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($student['email']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <?php
                                        // Fetch roles from the database
                                        $sql = "SELECT DISTINCT role FROM students";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                        
                                        // Iterate through roles and populate the dropdown
                                        foreach ($roles as $role) {
                                            echo '<option value="' . htmlspecialchars($role) . '"';
                                            if ($role === $student['role']) {
                                                echo ' selected';
                                            }
                                            echo '>' . htmlspecialchars($role) . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                            
                             <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
                            
                        </form>
                        <?php else: ?>
                        <div class="alert alert-danger">Student not found.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


