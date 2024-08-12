<?php
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Get class_id from URL parameter
$class_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;

// Define start and end dates for the report (you can adjust these or use form inputs)
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

// Validate dates
if (!DateTime::createFromFormat('Y-m-d', $start_date) || !DateTime::createFromFormat('Y-m-d', $end_date)) {
    echo "Invalid date format.";
    exit();
}

// Prepare the query to get attendance data based on assignment_id
$query = "
    SELECT
        b.course_name,
        c.class_name,
        ca.start_time,
        ca.end_time,
        u.name AS coordinator_name,
        a.status AS attendance_status,
        s.name AS student_name,
        a.date AS attendance_date
    FROM
        attendance a
    JOIN
        class_assignments ca ON a.assignment_id = ca.id
    JOIN
        classes c ON ca.class_id = c.id
    JOIN
        users u ON ca.coordinator_id = u.id
    JOIN
        students s ON a.student_id = s.id
    JOIN
        batches b ON c.batch_id = b.id
    WHERE
        a.assignment_id = ?
        AND a.date BETWEEN ? AND ?
    ORDER BY
        b.course_name, c.class_name, ca.start_time, a.date, s.name;
";

$stmt = $conn->prepare($query);
$stmt->bind_param("iss", $class_id, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Report</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Attendance Report</h2>
        
        <!-- Download CSV Button -->
        <form method="post" action="download_report2.php">
            <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
            <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
            <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id); ?>">
            <button type="submit" class="btn btn-success">Download Report</button>
        </form>

        <?php if (count($data) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Batch</th>
                        <th>Class</th>
                        <th>Start Date</th>
                        <th>Start Time</th>
                        <th>End Date</th>
                        <th>End Time</th>
                        <th>Instructor</th>
                        <th>Student</th>
                        <th>Attendance Status</th>
                        <th>Attendance Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                        <td><?php echo htmlspecialchars(date('F j, Y', strtotime($row['start_time']))); ?></td>
                        <td><?php echo htmlspecialchars(date('g:i A', strtotime($row['start_time']))); ?></td>
                        <td><?php echo htmlspecialchars(date('F j, Y', strtotime($row['end_time']))); ?></td>
                        <td><?php echo htmlspecialchars(date('g:i A', strtotime($row['end_time']))); ?></td>
                        <td><?php echo htmlspecialchars($row['coordinator_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                        <td><?php echo $row['attendance_status'] ? 'Present' : 'Absent'; ?></td>
                        <td><?php echo htmlspecialchars(date('F j, Y', strtotime($row['attendance_date']))); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No data available for the selected period.</p>
        <?php endif; ?>
    </div>
</body>
</html>
