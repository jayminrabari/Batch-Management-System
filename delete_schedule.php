<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;

    if (empty($event_id)) {
        echo "Event ID is required.";
        exit();
    }

    // Delete the schedule
    $stmt = $conn->prepare("DELETE FROM class_assignments WHERE id = ?");

    if ($stmt) {
        $stmt->bind_param("i", $event_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Schedule deleted successfully.";
        } else {
            echo "Failed to delete schedule or schedule not found.";
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
