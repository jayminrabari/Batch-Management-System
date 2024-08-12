<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

$user_id = $_GET['id'];

// Delete user
$sql = "DELETE FROM users WHERE id = $user_id";

if ($conn->query($sql) === TRUE) {
    echo "User deleted successfully!";
    header("Location: Manage_User.php");
    exit();
} else {
    echo "Error deleting user: " . $conn->error;
}
?>
