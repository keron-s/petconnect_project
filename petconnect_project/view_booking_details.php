<?php
session_start();

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
$host = "localhost";
$username = "root"; 
$password = "root";  
$dbname = "petconnect_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get booking ID from URL
$booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$booking_details = '';

// Fetch booking details
if ($booking_id > 0) {
    $sql = "SELECT b.booking_date, b.booking_time, b.notes, u.name AS user_name, u.email, s.name AS service_name
            FROM bookings b
            JOIN services s ON b.service_id = s.id
            JOIN users u ON b.user_email = u.email
            WHERE b.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $booking_details = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - PetConnect</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Booking Details</h1>
    </header>
    <main>
        <?php if ($booking_details): ?>
            <div class="booking-detail">
                <p><strong>User:</strong> <?php echo htmlspecialchars($booking_details['user_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($booking_details['email']); ?></p>
                <p><strong>Service:</strong> <?php echo htmlspecialchars($booking_details['service_name']); ?></p>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($booking_details['booking_date']); ?></p>
                <p><strong>Time:</strong> <?php echo htmlspecialchars($booking_details['booking_time']); ?></p>
                <p><strong>Notes:</strong> <?php echo htmlspecialchars($booking_details['notes']); ?></p>
            </div>
        <?php else: ?>
            <p>Booking not found.</p>
        <?php endif; ?>
    </main>
</body>
</html>
