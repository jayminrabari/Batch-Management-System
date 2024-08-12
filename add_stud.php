<?php
session_start();
include('config.php');

// Check if the user is logged in and is an instructor or admin
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'instructor' && $_SESSION['role'] !== 'admin')) {
    header("Location: signin.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $student_name = $_POST['name'];

    // Insert student data
    $query = "INSERT INTO students (name) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $student_name);

    if ($stmt->execute()) {
        echo "Student added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
     
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Add New Student</h2>
        <form method="post">
            <div class="form-group">
                <label for="name">Student Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
