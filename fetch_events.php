<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

$query = "SELECT ca.id, c.class_name, ca.class_id, ca.instructor_id, ca.resource_id, ca.coordinator_id, ca.start_time, ca.end_time
          FROM class_assignments ca
          JOIN classes c ON ca.class_id = c.id";


$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$events = array();
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

header('Content-Type: application/json');
echo json_encode($events);
?>
