<?php
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Get the start and end dates from the POST request
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-01');
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-t');
$class_id = isset($_POST['class_id']) ? intval($_POST['class_id']) : 0;

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

// Close the database connection
$conn->close();

// Output headers to force download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="attendance.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, ['Batch', 'Class', 'Start Date', 'Start Time', 'End Date', 'End Time', 'coordinator', 'Student', 'Attendance Status', 'Attendance Date']);

// Output the data
foreach ($data as $row) {
    fputcsv($output, [
        $row['course_name'],
        $row['class_name'],
        date('F j, Y', strtotime($row['start_time'])),
        date('g:i A', strtotime($row['start_time'])),
        date('F j, Y', strtotime($row['end_time'])),
        date('g:i A', strtotime($row['end_time'])),
        $row['coordinator_name'],
        $row['student_name'],
        $row['attendance_status'] ? 'Present' : 'Absent',
        date('F j, Y', strtotime($row['attendance_date']))
    ]);
}

// Close output stream
fclose($output);

exit();
?>
