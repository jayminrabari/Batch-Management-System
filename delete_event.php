<?php
include('config.php');

$id = $_POST['id'];

$sql = "DELETE FROM classes WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Class deleted successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
