<?php
include 'connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connection successful!";
}

$conn->close();
?>