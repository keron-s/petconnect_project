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

$service_id = $_POST['service_id'];
$sql = "DELETE FROM services WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $service_id);
$stmt->execute();
echo "Service deleted successfully!";
?>
