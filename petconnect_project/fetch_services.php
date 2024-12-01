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

// Fetch services
$sql = "SELECT name, type, rating, description FROM services";
$result = $conn->query($sql);

// Return services as HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='service'>";
        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
        echo "<p>Type: " . htmlspecialchars($row['type']) . "</p>";
        echo "<p>Rating: " . htmlspecialchars($row['rating']) . " ★</p>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No services available at the moment.</p>";
}

$conn->close();
?>
