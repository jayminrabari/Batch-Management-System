<?php

// Make sure u config this before running project
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "bta"; // Make DB Name As bta else face error while checking

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
