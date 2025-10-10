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
$feature_name = $_POST['feature_name'];
$feature_description = $_POST['feature_description'];

// Insert feature
$sql = "INSERT INTO service_features (name, description) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $feature_name, $feature_description);
$stmt->execute();

$stmt->close();
$conn->close();

echo "Feature added successfully!";
?>