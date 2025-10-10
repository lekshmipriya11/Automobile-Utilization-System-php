<?php
include "dbconnection.php"; // include DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values safely
    $staff_name = $conn->real_escape_string($_POST['staff_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password    = $conn->real_escape_string($_POST['password']);
    $department_name  = $conn->real_escape_string($_POST['department_name']);

    // Hash password (secure!)
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert query
    $sql = "INSERT INTO Staff_signup (staff_name, password, email, phone,department_name ) 
            VALUES ('$staff_name', '$hashed_password', '$email', '$phone', '$department_name')";

    if ($conn->query($sql) === TRUE) {
        // ✅ Redirect to login page
        header("Location: Staff_login.html");
        exit();
    } else {
        echo "<h2 style='color:red;'>Error: " . $sql . "<br>" . $conn->error . "</h2>";
    }
}
$conn->close();
?>
