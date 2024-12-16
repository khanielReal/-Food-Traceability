<?php
// config.php
$servername = "localhost"; // Use 127.0.0.1 instead of localhost for compatibility
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "food_traceability";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
