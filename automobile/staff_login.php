<?php
session_start();
include "dbconnection.php"; // include DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values safely
    $staffname = $conn->real_escape_string($_POST['staffname']);
    $password = $conn->real_escape_string($_POST['password']);
    $department_name = $conn->real_escape_string($_POST['department_name']);

    // Query to find the staff member
    $sql = "SELECT * FROM Staff_signup WHERE staff_name = '$staffname' AND department_name = '$department_name'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $staff = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $staff['password'])) {
            // Set session variables
            $_SESSION['staff_id'] = $staff['id'];
            $_SESSION['staff_name'] = $staff['staff_name'];
            $_SESSION['department_name'] = $staff['department_name'];
            
            // ✅ Redirect to staff dashboard
            header("Location: http://localhost/automobile/home.html");
            exit();
        } else {
            echo "<h2 style='color:red;'>Error: Invalid password</h2>";
        }
    } else {
        echo "<h2 style='color:red;'>Error: Staff not found or department mismatch</h2>";
    }
}
$conn->close();
?>