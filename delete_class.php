<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

$class_id = $_GET['id'];

// Delete class
$sql = "DELETE FROM classes WHERE id = $class_id";

if ($conn->query($sql) === TRUE) {
    echo "Class deleted successfully!";
    header("Location: Manage_Classes.php");
    exit();
} else {
    echo "Error deleting class: " . $conn->error;
}
?>
