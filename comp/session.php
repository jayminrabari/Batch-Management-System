<?php
session_start();

// Redirect to signin if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Retrieve user information from the session
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Unknown User';
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Unknown Role';

?>
