<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

$resource_id = $_GET['id'];

// Delete resource
$sql = "DELETE FROM resources WHERE id = $resource_id";

if ($conn->query($sql) === TRUE) {
    echo "Resource deleted successfully!";
    header("Location: Manage_Resource.php");
    exit();
} else {
    echo "Error deleting resource: " . $conn->error;
}
?>
