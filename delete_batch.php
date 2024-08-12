<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

$batch_id = $_GET['id'];

// Delete batch
$sql = "DELETE FROM batches WHERE id = $batch_id";

if ($conn->query($sql) === TRUE) {
    echo "Batch deleted successfully!";
    header("Location: Manage_Batches.php");
    exit();
} else {
    echo "Error deleting batch: " . $conn->error;
}
?>
