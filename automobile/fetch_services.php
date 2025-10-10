<?php
include 'dbconnection.php';

$sql = "SELECT * FROM services ORDER BY id DESC";
$result = $conn->query($sql);

$services = [];
while ($row = $result->fetch_assoc()) {
    $row['features'] = json_decode($row['features'], true);
    $services[] = $row;
}

echo json_encode($services);
$conn->close();
?>
