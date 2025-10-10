<?php
include "dbconnection.php"; // include DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values safely
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $email    = $conn->real_escape_string($_POST['email']);
    $phone    = $conn->real_escape_string($_POST['phone']);
    $address  = $conn->real_escape_string($_POST['address']);

    // Hash password (secure!)
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert query
    $sql = "INSERT INTO user_registration (username, password, email, phone, address) 
            VALUES ('$username', '$hashed_password', '$email', '$phone', '$address')";

    if ($conn->query($sql) === TRUE) {
        // ✅ Redirect to login page
        header("Location: http://localhost/automobile/user_login.html");
        exit();
    } else {
        echo "<h2 style='color:red;'>Error: " . $sql . "<br>" . $conn->error . "</h2>";
    }
}
$conn->close();
?>
