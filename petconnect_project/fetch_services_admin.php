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

$sql = "SELECT id, name, type FROM services";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='service'>";
        echo "<p>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['type']) . ")</p>";
        echo "<button onclick='deleteService(" . $row['id'] . ")'>Delete</button>";
        echo "</div>";
    }
} else {
    echo "<p>No services found.</p>";
}
?>
