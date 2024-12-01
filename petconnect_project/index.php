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

// Fetch services from the database
$query = "SELECT * FROM services";
$result = mysqli_query($conn, $query);
$services = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetConnect - Home</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>

</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Welcome to PetConnect</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="booking.html">Book a Service</a></li>
                    <li><a href="search.php">Find Services</a></li>
                    <li><a href="view_bookings.html">View Bookings</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Section -->
    <main>
        <section class="intro">
            <h2>Your Pet's Best Friend</h2>
            <p>Welcome to PetConnect, your one-stop solution for pet services. Whether you're looking for grooming, training, or just a pet-friendly cafe, we've got it all!</p>
        </section>

        <!-- Search Bar Section -->
        <section class="search-bar-container">
            <input type="text" class="search-bar" placeholder="Search for a service..." />
            <button class="btn">Search</button>
        </section>

        <!-- Featured Services -->
        <section class="services">
            <h2>Featured Services</h2>
            <div class="service-list">
                <?php foreach ($services as $service): ?>
                    <div class="service">
                        <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                        <p><?php echo htmlspecialchars($service['description']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($service['location']); ?></p>
                        <p><strong>Rating:</strong> <?php echo number_format($service['rating'], 1); ?> ★</p>
                        <a href="booking.php?service_id=<?php echo $service['id']; ?>" class="btn">Book Now</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 PetConnect. All rights reserved.</p>
    </footer>

</body>
</html>
