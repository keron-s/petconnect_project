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

// Get form data
$serviceId = $_POST['service'];
$date = $_POST['date'];
$time = $_POST['time'];
$notes = $_POST['notes'];
$userEmail = $_SESSION['user_email']; // Assume the user is logged in and their email is stored in the session

// Insert booking into the database
$sql = "INSERT INTO bookings (user_email, service_id, booking_date, booking_time, notes) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisss", $userEmail, $serviceId, $date, $time, $notes);

if ($stmt->execute()) {
    echo "Booking successful!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
