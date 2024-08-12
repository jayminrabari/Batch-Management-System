<?php
session_start();
include('config.php');

// Check if the user is logged in and is an instructor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header("Location: signin.php");
    exit();
}

// Get class assignment ID from URL
$class_assignment_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;

// Validate class_assignment_id
if ($class_assignment_id <= 0) {
    echo "Invalid class assignment ID.";
    exit();
}

// Fetch the actual class ID and class date from the class_assignments table
$query = "SELECT class_id, start_time FROM class_assignments WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $class_assignment_id);
$stmt->execute();
$result = $stmt->get_result();
$class_assignment = $result->fetch_assoc();

if (!$class_assignment) {
    echo "Class assignment not found.";
    exit();
}

$actual_class_id = $class_assignment['class_id'];
$class_date = new DateTime($class_assignment['start_time'], new DateTimeZone('Asia/Kolkata'));
$current_date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));

// Check if the class date is in the future
if ($class_date > $current_date) {
    echo "Attendance cannot be taken for future classes.";
    exit();
}

$instructor_id = $_SESSION['user_id']; // Get the instructor's ID from the session

// Check if attendance has already been taken for today
$formatted_date = $current_date->format('Y-m-d');
$query = "SELECT COUNT(*) AS count FROM attendance WHERE assignment_id = ? AND date = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $class_assignment_id, $formatted_date);
$stmt->execute();
$result = $stmt->get_result();
$attendance_record = $result->fetch_assoc();

$attendance_taken = $attendance_record['count'] > 0;

// Fetch students enrolled in the actual class
$query = "SELECT s.id, s.name FROM students s
          JOIN enrollments e ON s.id = e.student_id
          WHERE e.class_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $actual_class_id);
$stmt->execute();
$result = $stmt->get_result();
$students = $result->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$attendance_taken) {
    $date = $current_date->format('Y-m-d'); // Current date in IST

    foreach ($students as $student) {
        $status = isset($_POST['attendance'][$student['id']]) ? 1 : 0;

        // Insert or update attendance
        $query = "INSERT INTO attendance (assignment_id, class_id, student_id, status, date, instructor_id) VALUES (?, ?, ?, ?, ?, ?)
                  ON DUPLICATE KEY UPDATE status = ?, updated_at = NOW()";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiiisii", $class_assignment_id, $actual_class_id, $student['id'], $status, $date, $instructor_id, $status);

        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit();
        }
    }
    header("Location: Instructor_Dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Take Attendance</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Take Attendance for Class</h2>

        <?php if ($attendance_taken): ?>
            <p class="alert alert-info">Attendance has already been taken for this class on <?php echo htmlspecialchars($current_date->format('Y-m-d')); ?>.</p>
        <?php else: ?>
            <form method="post">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Attended</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($students) > 0): ?>
                            <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                                <td>
                                    <input type="checkbox" name="attendance[<?php echo $student['id']; ?>]" value="1">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">No students enrolled in this class.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Submit Attendance</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
