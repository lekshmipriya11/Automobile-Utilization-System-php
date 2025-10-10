<?php
$host = "localhost"; 
$user = "root";       // Default XAMPP username
$pass = "root";           // Default XAMPP has NO password — leave empty unless you set one
$db   = "automobile"; // Your database name

// Create connection
$con = new mysqli($host, $user, $pass, $db);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
