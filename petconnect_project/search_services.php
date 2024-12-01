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

// Get the search query
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

// Prepare the SQL statement
$sql = "SELECT name, type, rating, description FROM services WHERE name LIKE ? OR type LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = '%' . $query . '%';
$stmt->bind_param("ss", $searchTerm, $searchTerm);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Return results as HTML
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
    echo "<p>No matching services found.</p>";
}

$stmt->close();
$conn->close();
?>
