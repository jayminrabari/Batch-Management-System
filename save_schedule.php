<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = isset($_POST['class_id']) ? intval($_POST['class_id']) : 0;
    $instructor_id = isset($_POST['instructor_id']) ? intval($_POST['instructor_id']) : 0;
    $resource_id = isset($_POST['resource_id']) ? intval($_POST['resource_id']) : 0;
    $coordinator_id = isset($_POST['coordinator_id']) ? intval($_POST['coordinator_id']) : 0;
    $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '';
    $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '';

    // Basic validation
    if (empty($class_id) || empty($instructor_id) || empty($resource_id) || empty($coordinator_id) || empty($start_time) || empty($end_time)) {
        echo "All fields are required.";
        exit();
    }

    // Create DateTime objects with IST timezone
    $start_time_dt = new DateTime($start_time, new DateTimeZone('Asia/Kolkata'));
    $end_time_dt = new DateTime($end_time, new DateTimeZone('Asia/Kolkata'));

    // Ensure that end time is after start time
    if ($end_time_dt <= $start_time_dt) {
        echo "End time must be after start time.";
        exit();
    }

    // Format the times as strings to use in queries (IST)
    $start_time_ist = $start_time_dt->format('Y-m-d H:i:s');
    $end_time_ist = $end_time_dt->format('Y-m-d H:i:s');

    // Check for overlapping schedules
    $stmt = $conn->prepare("SELECT id FROM class_assignments WHERE 
        (class_id = ? OR instructor_id = ? OR resource_id = ? OR coordinator_id = ?) AND
        (start_time < ? AND end_time > ?) AND
        (NOT (start_time >= ? AND end_time <= ?))");

    if ($stmt) {
        $stmt->bind_param("iiisssss", $class_id, $instructor_id, $resource_id, $coordinator_id, $end_time_ist, $start_time_ist, $start_time_ist, $end_time_ist);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Conflict detected with existing schedules.";
            $stmt->close();
            exit();
        }

        $stmt->close();
    } else {
        echo "Failed to prepare statement.";
        exit();
    }

    // Save the schedule
    $stmt = $conn->prepare("INSERT INTO class_assignments (class_id, instructor_id, resource_id, coordinator_id, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("iiisss", $class_id, $instructor_id, $resource_id, $coordinator_id, $start_time_ist, $end_time_ist);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Schedule saved successfully.";
        } else {
            echo "Failed to save schedule.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare statement.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
