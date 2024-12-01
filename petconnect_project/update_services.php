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

// Get service ID from URL (if any)
$service_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$service_name = '';
$service_type = '';

// Fetch the service details
if ($service_id > 0) {
    $sql = "SELECT name, type FROM services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $service_name = $row['name'];
        $service_type = $row['type'];
    }
}

// Update the service details when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updated_name = $_POST['name'];
    $updated_type = $_POST['type'];

    $update_sql = "UPDATE services SET name = ?, type = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $updated_name, $updated_type, $service_id);
    $stmt->execute();

    header("Location: admin_panel.php"); // Redirect after update
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Service - PetConnect</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Update Service</h1>
    </header>
    <main>
        <section class="service-update">
            <form action="update_service.php?id=<?php echo $service_id; ?>" method="POST">
                <label for="name">Service Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($service_name); ?>" required>

                <label for="type">Service Type:</label>
                <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($service_type); ?>" required>

                <button type="submit" class="btn">Update Service</button>
            </form>
        </section>
    </main>
</body>
</html>
