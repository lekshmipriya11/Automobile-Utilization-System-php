<?php
include('dbconnection.php'); // include your DB connection

// Handle appointment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $vehicle_model = trim($_POST['vehicle_model']);
    $service_type = trim($_POST['service_type']);
    $appointment_date = trim($_POST['appointment_date']);
    $message = trim($_POST['message']);

    $stmt = $con->prepare("INSERT INTO appointments (name, email, phone, vehicle_model, service_type, appointment_date, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $phone, $vehicle_model, $service_type, $appointment_date, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Your appointment has been booked successfully!'); window.location='admin-addappointment.php';</script>";
    } else {
        echo "<script>alert('Failed to book appointment. Please try again.');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Red Clover | Book Appointment</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            background: url('bugatti.jpg') no-repeat center center/cover;
            color: #fff;
            min-height: 100vh;
            display: flex;
        }

        /* === Sidebar === */
        .sidebar {
            background: rgba(0, 0, 0, 0.9);
            width: 250px;
            min-height: 100vh;
            padding: 30px 20px;
            position: fixed;
            left: 0;
            top: 0;
        }

        .logo {
            font-size: 26px;
            color: #ff4d00;
            font-weight: 700;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin: 15px 0;
        }

        .sidebar-menu a {
            text-decoration: none;
            color: #ddd;
            display: block;
            padding: 10px 15px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #ff4d00;
            color: #fff;
        }

        .submenu {
            list-style: none;
            margin-left: 20px;
            display: none;
        }

        .dropdown:hover .submenu {
            display: block;
        }

        /* === Main Content === */
        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
        }

        .dashboard-header h1 {
            color: #ff4d00;
            font-size: 28px;
        }

        /* === Appointment Form Section === */
        .form-section {
            background: rgba(30, 30, 30, 0.85);
            border-radius: 12px;
            padding: 40px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 15px rgba(255, 77, 0, 0.3);
        }

        .form-section h2 {
            color: #ff4d00;
            text-align: center;
            margin-bottom: 25px;
        }

        form label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #ccc;
        }

        form input,
        form select,
        form textarea {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: none;
            border-radius: 6px;
            background: #222;
            color: #fff;
            font-size: 15px;
        }

        form input:focus,
        form select:focus,
        form textarea:focus {
            outline: 2px solid #ff4d00;
        }

        form button {
            background: #ff4d00;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
        }

        form button:hover {
            background: #ff661a;
        }

        .note {
            text-align: center;
            font-size: 14px;
            color: #aaa;
            margin-top: 15px;
        }

        @media(max-width:992px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: relative;
                border-bottom: 1px solid #333;
            }

            .main-content {
                margin-left: 0;
                padding: 25px;
            }
        }
    </style>
</head>

<body>
   <!-- Sidebar -->
<aside class="sidebar">
  <div>
    <div class="logo"><i class="fas fa-car"></i> Red Clover</div>
    <ul class="sidebar-menu">
      <li><a href="admin-dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>

      <!-- Customers Dropdown -->
      <li class="dropdown">
        <a href="#"><i class="fas fa-users"></i> Customers</a>
        <ul class="submenu">
          <li><a href="admin-registration.php">Add Customer</a></li>
          <li><a href="admin-manageregister.php">Manage Customers</a></li>
        </ul>
      </li>

      <!-- Appointments Dropdown -->
      <li class="dropdown">
        <a href="#"><i class="fas fa-calendar-alt"></i> Appointments</a>
        <ul class="submenu">
          <li><a href="admin-addappointment.php">Add Appointment</a></li>
          <li><a href="admin-manageappointment.php">Manage Appointments</a></li>
        </ul>
      </li>

      <!-- Services Dropdown -->
      <li class="dropdown">
        <a href="#"><i class="fas fa-tools"></i> Services</a>
        <ul class="submenu">
          <li><a href="admin-service.php">Add Service</a></li>
          <li><a href="admin-manageservice.php">Manage Services</a></li>
        </ul>
      </li>

      <!-- ✅ New Staff Dropdown -->
      <li class="dropdown">
        <a href="#"><i class="fas fa-user-tie"></i> Staff</a>
        <ul class="submenu">
          <li><a href="admin-staffregistration.php">Add Staff</a></li>
          <li><a href="admin-managestaff.php">Manage Staff</a></li>
        </ul>
      </li>
      <!-- Logout -->
      <li><a href="home.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>
</aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="dashboard-header">
            <h1>Book Appointment</h1>
            <div>Welcome, Admin | <span id="current-date"></span></div>
        </div>

        <section class="form-section">
            <h2><i class="fas fa-calendar-check"></i> Schedule a Car Service</h2>
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
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('current-date').textContent = new Date().toLocaleDateString();
        });
    </script>
</body>

</html>