<?php
include('dbconnection.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if (empty($username) || empty($password) || empty($email)) {
        die("Please fill in all required fields.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ✅ Correct table name here
    $stmt = $con->prepare("INSERT INTO user_registration (username, password, email, phone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $phone, $address);

    if ($stmt->execute()) {
        echo "<script>alert('Customer registered successfully!'); window.location='admin-manageregister.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to register customer.'); window.history.back();</script>";
    }

    $stmt->close();
    $con->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Red Clover | Add Customer</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* === Base Styles === */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      background: url('bugatti.jpg') no-repeat center center/cover;
      color: #fff;
      display: flex;
      min-height: 100vh;
    }

    /* === Sidebar === */
    .sidebar {
      background: rgba(0, 0, 0, 0.9);
      width: 250px;
      padding: 30px 20px;
      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
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
      margin-left: 270px;
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
    }

    .form-container {
      background: rgba(15, 15, 15, 0.9);
      padding: 40px 50px;
      border-radius: 12px;
      max-width: 550px;
      width: 100%;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(6px);
      animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h1 {
      text-align: center;
      color: #ff4d00;
      margin-bottom: 25px;
      font-size: 28px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #ccc;
      font-weight: 500;
    }

    input {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #333;
      border-radius: 6px;
      background: rgba(40, 40, 40, 0.8);
      color: #fff;
      font-size: 16px;
      transition: 0.3s;
    }

    input:focus {
      border-color: #ff4d00;
      outline: none;
      background: rgba(60, 60, 60, 0.9);
    }

    .btn {
      width: 100%;
      padding: 12px;
      background: #ff4d00;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 18px;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 10px;
    }

    .btn:hover {
      background: #e04300;
      transform: translateY(-2px);
    }

    .login-link {
      text-align: center;
      margin-top: 20px;
      color: #bbb;
    }

    .login-link a {
      color: #ff4d00;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    /* === Responsive === */
    @media (max-width: 992px) {
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

      .form-container {
        padding: 30px;
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
  <div class="main-content">
    <div class="form-container">
      <h1>Add Customer</h1>
      <form method="POST">
        <div class="form-group">
          <label>Username</label>
          <input type="text" name="username" required>
        </div>

        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" required>
        </div>

        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" required>
        </div>

        <div class="form-group">
          <label>Phone</label>
          <input type="tel" name="phone" pattern="[0-9]{10}" required>
        </div>

        <div class="form-group">
          <label>Address</label>
          <input type="text" name="address" required>
        </div>

        <button type="submit" class="btn">Register Customer</button>
      </form>

      <div class="login-link">
        Already registered? <a href="user_login.php">Login here</a>
      </div>
    </div>
  </div>
</body>
</html>
