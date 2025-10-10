<?php
// Database connection
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "red_clover";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$service_name = $_POST['service_name'];
$service_price = $_POST['service_price'];
$service_description = $_POST['service_description'];
$features = $_POST['features'];

// Insert service
$sql = "INSERT INTO services (name, price, description) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sds", $service_name, $service_price, $service_description);
$stmt->execute();

$service_id = $stmt->insert_id;

// Insert service-feature relationships
if (!empty($features)) {
    $sql = "INSERT INTO service_feature_relationships (service_id, feature_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
    foreach ($features as $feature_id) {
        $stmt->bind_param("ii", $service_id, $feature_id);
        $stmt->execute();
    }
}

$stmt->close();
$conn->close();

echo "Service added successfully!";
?>