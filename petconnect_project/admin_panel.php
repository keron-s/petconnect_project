<?php
session_start();

// If the admin is not logged in, redirect to login page
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

// Fetch all bookings
$sql = "SELECT b.id, b.booking_date, b.booking_time, u.name AS user_name, s.name AS service_name
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        JOIN users u ON b.user_email = u.email";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - PetConnect</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <a href="logout.php">Logout</a>
    </header>
    <main>
        <section class="admin-section">
            <h2>Manage Bookings</h2>
            <div id="bookings-container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='booking'>";
                        echo "<p>" . htmlspecialchars($row['user_name']) . " (" . htmlspecialchars($row['service_name']) . ")</p>";
                        echo "<p><strong>Date:</strong> " . htmlspecialchars($row['booking_date']) . " <strong>Time:</strong> " . htmlspecialchars($row['booking_time']) . "</p>";
                        echo "<a href='view_booking_details.php?id=" . $row['id'] . "'>View Details</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No bookings available.</p>";
                }
                ?>
            </div>
        </section>
    </main>
</body>
</html>
