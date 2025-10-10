<?php
include 'dbconnection.php';

$id = $_POST['id'];
$sql = "DELETE FROM services WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conn->close();

echo "success";
?>
