<?php
include('config.php');

// Retrieve start_time and end_time from GET parameters
$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : '';

// Basic validation
if (empty($start_time) || empty($end_time)) {
    echo json_encode(['error' => 'Start time and end time are required.']);
    exit();
}

// Create DateTime objects with IST timezone
try {
    $start_time_dt = new DateTime($start_time, new DateTimeZone('Asia/Kolkata'));
    $end_time_dt = new DateTime($end_time, new DateTimeZone('Asia/Kolkata'));

    if ($end_time_dt <= $start_time_dt) {
        echo json_encode(['error' => 'End time must be after start time.']);
        exit();
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Invalid date format.']);
    exit();
}

// Format times for SQL queries (IST)
$start_time_ist = $start_time_dt->format('Y-m-d H:i:s');
$end_time_ist = $end_time_dt->format('Y-m-d H:i:s');

// Prepare SQL queries using prepared statements to prevent SQL injection
$queries = [
    'instructors' => "SELECT instructor_id FROM class_assignments WHERE (start_time < ? AND end_time > ?)",
    'coordinators' => "SELECT coordinator_id FROM class_assignments WHERE (start_time < ? AND end_time > ?)",
    'resources' => "SELECT resource_id FROM class_assignments WHERE (start_time < ? AND end_time > ?)",
];

$results = [];
foreach ($queries as $key => $query) {
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('ss', $end_time_ist, $start_time_ist);
        $stmt->execute();
        $result = $stmt->get_result();
        $results["unavailable_$key"] = array_column($result->fetch_all(MYSQLI_ASSOC), "{$key}_id");
        $stmt->close();
    } else {
        echo json_encode(['error' => "Failed to prepare query for $key."]);
        exit();
    }
}

// Send data back as JSON
echo json_encode($results);

$conn->close();
?>
