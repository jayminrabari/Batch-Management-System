<?php
session_start();
include('config.php');

// Check if the user is logged in and is an instructor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header("Location: signin.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $student_id = $_POST['student_id'];
    $class_id = $_POST['class_id'];

    // Insert enrollment data
    $query = "INSERT INTO enrollments (student_id, class_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $student_id, $class_id);

    if ($stmt->execute()) {
        echo "Enrollment successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

// Fetch students and classes for the form
$students_query = "SELECT id, name FROM students";
$students_result = $conn->query($students_query);

$classes_query = "SELECT id, class_name FROM classes";
$classes_result = $conn->query($classes_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enroll Students</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Enroll Students in Classes</h2>
        <form method="post">
            <div class="form-group">
                <label for="student_id">Select Student</label>
                <select name="student_id" id="student_id" class="form-control" required>
                    <option value="">Select a student</option>
                    <?php while ($student = $students_result->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($student['id']); ?>">
                            <?php echo htmlspecialchars($student['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="class_id">Select Class</label>
                <select name="class_id" id="class_id" class="form-control" required>
                    <option value="">Select a class</option>
                    <?php while ($class = $classes_result->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($class['id']); ?>">
                            <?php echo htmlspecialchars($class['class_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enroll</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
