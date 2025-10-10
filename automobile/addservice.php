<?php
include 'dbconnection.php';

$name = $_POST['service_name'];
$price = $_POST['service_price'];
$description = $_POST['service_description'];
$features = json_encode($_POST['features']);

$sql = "INSERT INTO addservice (service_name, service_price, service_description, features) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdss", $name, $price, $description, $features);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
