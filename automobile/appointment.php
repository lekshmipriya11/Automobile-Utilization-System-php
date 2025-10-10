<?php
// appointment.php
include('dbconnection.php'); // DB connection
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle appointment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $vehicle_model = trim($_POST['vehicle_model']);
    $service_type = trim($_POST['service_type']);
    $appointment_date = trim($_POST['appointment_date']);
    $message = trim($_POST['message']);

    // Use 'guest' for user_id if no login system
    $user_id = 'guest';

    // Insert into appointments table
    $stmt = $con->prepare("INSERT INTO appointments (user_id, name, email, phone, vehicle_model, service_type, appointment_date, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $user_id, $name, $email, $phone, $vehicle_model, $service_type, $appointment_date, $message);

    if ($stmt->execute()) {
        // Get last inserted appointment ID
        $appointment_id = $stmt->insert_id;

        echo "<script>
            alert('Your appointment has been booked successfully!');
            window.location='payment.php?appointment_id=" . $appointment_id . "';
        </script>";
        exit;
    } else {
        echo "<script>alert('Failed to book appointment. Please try again.');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Red Clover | Book Appointment</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
* {margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body {background:#0f0f0f;color:#fff;min-height:100vh;display:flex;flex-direction:column;}
.navbar {display:flex;justify-content:space-between;align-items:center;padding:20px 50px;background:rgba(0,0,0,0.85);box-shadow:0 4px 30px rgba(0,0,0,0.5);position:sticky;top:0;z-index:100;}
.logo {font-size:28px;font-weight:700;color:#ff4d00;text-transform:uppercase;letter-spacing:1px;display:flex;align-items:center;cursor:pointer;}
.logo i {margin-right:10px;color:#ff4d00;}
.logo-dropdown {position:relative;display:inline-block;}
.dropdown-content {display:none;position:absolute;background-color:rgba(15,15,15,0.98);min-width:220px;box-shadow:0 8px 16px rgba(0,0,0,0.5);border-radius:8px;overflow:hidden;border:1px solid #ff4d00;margin-top:10px;transition:0.3s;}
.dropdown-content a {color:#fff;padding:14px 18px;text-decoration:none;display:block;border-bottom:1px solid rgba(255,255,255,0.1);}
.dropdown-content a:last-child {border-bottom:none;}
.dropdown-content a:hover {background:#ff4d00;padding-left:22px;}
.show-dropdown {display:block;animation:fadeIn 0.3s ease;}
@keyframes fadeIn {from{opacity:0;transform:translateY(-10px);}to{opacity:1;transform:translateY(0);}}
.nav-links {display:flex;gap:30px;}
.nav-links a {text-decoration:none;color:#fff;font-size:18px;font-weight:500;padding:8px 15px;border-radius:4px;transition:0.3s;}
.nav-links a:hover {background:rgba(255,255,255,0.1);color:#ff4d00;}
.nav-links a.active {background:#ff4d00;color:#fff;}
.container {background:rgba(20,20,20,0.9);padding:40px;border-radius:12px;width:90%;max-width:700px;margin:40px auto;box-shadow:0 0 15px rgba(255,77,0,0.4);}
h1 {text-align:center;color:#ff4d00;margin-bottom:25px;}
form label {display:block;margin-bottom:6px;font-weight:500;color:#ccc;}
form input, form select, form textarea {width:100%;padding:10px 12px;margin-bottom:18px;border:none;border-radius:6px;background:#222;color:#fff;font-size:15px;}
form input:focus, form select:focus, form textarea:focus {outline:2px solid #ff4d00;}
form button {width:100%;background:#ff4d00;color:#fff;border:none;padding:12px 20px;border-radius:6px;font-size:16px;cursor:pointer;transition:0.3s;}
form button:hover {background:#ff661a;}
.note {text-align:center;font-size:14px;color:#aaa;margin-top:15px;}
@media(max-width:600px){.container {padding:25px;}}
</style>
</head>
<body>

<nav class="navbar">
    <div class="logo-dropdown">
        <div class="logo" onclick="toggleDropdown()">
            <i class="fas fa-car"></i> Red Clover <i class="fas fa-chevron-down" style="margin-left:10px;font-size:16px;"></i>
        </div>
        <div class="dropdown-content" id="dropdownMenu">
            <a href="home.php"><i class="fas fa-home"></i> Home</a>
            <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
            <a href="services.php"><i class="fas fa-tools"></i> Services</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
        </div>
    </div>
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
    </div>
</nav>

<div class="container">
    <h1><i class="fas fa-calendar-check"></i> Book Your Car Service</h1>
    <form method="POST" action="">
        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" placeholder="Enter your full name" required>

        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" placeholder="example@gmail.com" required>

        <label for="phone">Phone Number</label>
        <input type="text" name="phone" id="phone" placeholder="Enter your phone number" required>

        <label for="vehicle_model">Vehicle Model</label>
        <input type="text" name="vehicle_model" id="vehicle_model" placeholder="Eg: Honda City 2021" required>

        <label for="service_type">Select Service Type</label>
        <select name="service_type" id="service_type" required>
            <option value="">-- Select Service --</option>
            <option value="General Service">General Service</option>
            <option value="Engine Repair">Engine Repair</option>
            <option value="Oil Change">Oil Change</option>
            <option value="Car Wash">Car Wash</option>
            <option value="AC Repair">AC Repair</option>
            <option value="Painting">Painting</option>
        </select>

        <label for="appointment_date">Preferred Appointment Date</label>
        <input type="date" name="appointment_date" id="appointment_date" required>

        <label for="message">Additional Message (Optional)</label>
        <textarea name="message" id="message" rows="3" placeholder="Any special request..."></textarea>

        <button type="submit">Book Appointment</button>
    </form>
    <p class="note">We’ll contact you to confirm your appointment details.</p>
</div>

<script>
function toggleDropdown() {
    document.getElementById('dropdownMenu').classList.toggle('show-dropdown');
}
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('dropdownMenu');
    const logo = document.querySelector('.logo');
    if (!logo.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.remove('show-dropdown');
    }
});
</script>
</body>
</html>
