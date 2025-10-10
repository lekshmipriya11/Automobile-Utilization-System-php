<?php
include 'dbconnection.php';

$id = $_POST['id'];
$sql = "UPDATE services SET active = 1 - active WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conn->close();

echo "success";
?>
