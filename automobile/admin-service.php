<?php
include('dbconnection.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_name = trim($_POST['service_name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);

    $stmt = $con->prepare("INSERT INTO service (service_name, description, price) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $service_name, $description, $price);

    if ($stmt->execute()) {
        echo "<script>alert('Service added successfully!'); window.location='admin-service.php';</script>";
    } else {
        echo "<script>alert('Failed to add service. Please try again.');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Red Clover | Add Service</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', sans-serif;}
        body {display: flex;min-height: 100vh;background: url('bugatti.jpg') no-repeat center center/cover;color: #fff;}

        /* Sidebar */
        .sidebar {background: rgba(0,0,0,0.9); width:250px; min-height:100vh; padding:30px 20px; position:fixed; top:0;}
        .logo {font-size:26px; color:#ff4d00; font-weight:700; margin-bottom:40px; display:flex; align-items:center; gap:8px;}
        .sidebar-menu {list-style:none;}
        .sidebar-menu li {margin:15px 0;}
        .sidebar-menu a {text-decoration:none; color:#ddd; display:block; padding:10px 15px; border-radius:6px; transition:.3s;}
        .sidebar-menu a:hover, .sidebar-menu a.active {background:#ff4d00; color:#fff;}
        .submenu {list-style:none; margin-left:20px; display:none;}
        .dropdown:hover .submenu {display:block;}

        /* Main Content */
        .main-content {margin-left:250px; flex:1; padding:40px; overflow-y:auto;}
        .dashboard-header {display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; border-bottom:1px solid #333; padding-bottom:10px;}
        .dashboard-header h1 {color:#ff4d00; font-size:28px;}

        /* Form Section */
        .form-section {background: rgba(30,30,30,0.85); border-radius:12px; padding:40px; max-width:700px; margin:auto; box-shadow:0 0 15px rgba(255,77,0,0.3);}
        .form-section h2 {color:#ff4d00; text-align:center; margin-bottom:25px;}
        form label {display:block; margin-bottom:6px; font-weight:500; color:#ccc;}
        form input, form textarea {width:100%; padding:10px 12px; margin-bottom:18px; border:none; border-radius:6px; background:#222; color:#fff; font-size:15px;}
        form input:focus, form textarea:focus {outline:2px solid #ff4d00;}
        form button {background:#ff4d00; color:#fff; border:none; padding:12px 20px; border-radius:6px; font-size:16px; cursor:pointer; transition:0.3s; width:100%;}
        form button:hover {background:#ff661a;}
        .note {text-align:center; font-size:14px; color:#aaa; margin-top:15px;}

        @media(max-width:992px){
            .sidebar {width:100%; position:relative; border-bottom:1px solid #333;}
            .main-content {margin-left:0; padding:25px;}
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
            <h1>Add Service</h1>
            <div>Welcome, Admin | <span id="current-date"></span></div>
        </div>

        <section class="form-section">
            <h2><i class="fas fa-tools"></i> Add New Service</h2>
            <form method="POST" action="">
                <label for="service_name">Service Name</label>
                <input type="text" name="service_name" id="service_name" placeholder="Eg: Oil Change" required>

                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3" placeholder="Describe the service..." required></textarea>

                <label for="price">Price</label>
                <input type="text" name="price" id="price" placeholder="Eg: 1500" required>

                <button type="submit">Add Service</button>
            </form>
            <p class="note">The new service will be added to the system immediately.</p>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('current-date').textContent = new Date().toLocaleDateString();
        });
    </script>
</body>
</html>
