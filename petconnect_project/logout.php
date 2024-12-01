<?php
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "root";
$dbname = "petconnect_db";

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_destroy(); // Destroy the session
header("Location: admin_login.php"); // Redirect to the login page
exit();
?>
