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

// Get services with their features
$sql = "SELECT s.*, GROUP_CONCAT(sf.name) as feature_names
        FROM services s
        LEFT JOIN service_feature_relationships sfr ON s.id = sfr.service_id
        LEFT JOIN service_features sf ON sfr.feature_id = sf.id
        GROUP BY s.id";

$result = $conn->query($sql);

$services = array();
while($row = $result->fetch_assoc()) {
    $services[] = $row;
}

echo json_encode($services);

$conn->close();
?>