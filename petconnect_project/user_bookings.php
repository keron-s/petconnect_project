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

// Get the user's email from the query string
$user_email = isset($_GET['email']) ? trim($_GET['email']) : '';

if ($user_email === '') {
    echo "<p>Please provide an email address to view bookings.</p>";
    exit();
}

// Fetch bookings for the user
$sql = "SELECT b.booking_date, b.booking_time, s.name AS service_name, s.type AS service_type, b.notes 
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        WHERE b.user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

// Return the bookings as HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='booking'>";
        echo "<h3>" . htmlspecialchars($row['service_name']) . "</h3>";
        echo "<p>Type: " . htmlspecialchars($row['service_type']) . "</p>";
        echo "<p>Date: " . htmlspecialchars($row['booking_date']) . "</p>";
        echo "<p>Time: " . htmlspecialchars($row['booking_time']) . "</p>";
        echo "<p>Notes: " . htmlspecialchars($row['notes']) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No bookings found for this email.</p>";
}

$stmt->close();
$conn->close();
?>
