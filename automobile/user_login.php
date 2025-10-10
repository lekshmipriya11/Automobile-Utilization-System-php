<?php
session_start();
include "dbconnection.php"; // connect to DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM user_registration WHERE username = '$username' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // ✅ Login success
            $_SESSION['username'] = $row['username']; // store session
            header("Location: http://localhost/automobile/home.html"); // redirect to dashboard
            exit();
        } else {
            echo "<h3 style='color:red;'>Invalid password!</h3>";
        }
    } else {
        echo "<h3 style='color:red;'>User not found!</h3>";
    }
}
$conn->close();
?>
