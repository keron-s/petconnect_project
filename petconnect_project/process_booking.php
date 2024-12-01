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
// Retrieve form data
$service_id = $_POST['service_id'];
$user_name = $_POST['user_name'];
$user_email = $_POST['user_email'];
$booking_date = $_POST['booking_date'];
$booking_time = $_POST['booking_time'];
$notes = $_POST['notes'];

// Insert data into `bookings` table
$sql = "INSERT INTO bookings (service_id, user_name, user_email, booking_date, booking_time, notes)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssss", $service_id, $user_name, $user_email, $booking_date, $booking_time, $notes);

if ($stmt->execute()) {
    echo "<p>Booking confirmed! Thank you, " . htmlspecialchars($user_name) . ".</p>";
} else {
    echo "<p>Failed to confirm booking. Please try again.</p>";
}

$stmt->close();
$conn->close();
?>
