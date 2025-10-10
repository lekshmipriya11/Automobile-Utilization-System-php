<?php
include('dbconnection.php');
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff_name = trim($_POST['staff_name']);
    $department_name = trim($_POST['department_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate required fields
    if (empty($staff_name) || empty($department_name) || empty($phone) || empty($email) || empty($password)) {
        $message = "All fields are required!";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $message = "Enter a valid 10-digit phone number!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Enter a valid email address!";
    } else {
        // Check if email already exists
        $checkEmail = $con->prepare("SELECT email FROM staff_signup WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();

        if ($checkEmail->num_rows > 0) {
            $message = "Email already exists! Please use another email.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $con->prepare("INSERT INTO staff_signup (staff_name, department_name, phone, email, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $staff_name, $department_name, $phone, $email, $hashedPassword);

            if ($stmt->execute()) {
                $message = "Staff registered successfully!";
            } else {
                $message = "Error while registering staff: " . $stmt->error;
            }
            $stmt->close();
        }
        $checkEmail->close();
    }
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Red Clover | Staff Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        /* Your existing CSS */
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

        .form-container {
            background: rgba(30, 30, 30, 0.85);
            border-radius: 12px;
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid rgba(255, 77, 0, 0.3);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
        }

        .form-container h2 {
            text-align: center;
            color: #ff4d00;
            margin-bottom: 25px;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
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
            padding: 12px 14px;
            border: none;
            border-radius: 6px;
            background: rgba(50, 50, 50, 0.7);
            color: #fff;
            font-size: 16px;
            transition: 0.3s ease;
            border: 1px solid #333;
        }

        input:focus {
            outline: none;
            border-color: #ff4d00;
            background: rgba(60, 60, 60, 0.8);
            box-shadow: 0 0 0 3px rgba(255, 77, 0, 0.2);
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: #ff4d00;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn:hover {
            background: #e04400;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 77, 0, 0.4);
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            color: #ff4d00;
            font-weight: 600;
            font-size: 16px;
        }

        @media(max-width:992px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: relative;
            }

            .main-content {
                margin-left: 0;
                padding: 25px;
            }

            .form-container {
                padding: 30px 20px;
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

    <main class="main-content">
        <div class="dashboard-header">
            <h1>Staff Registration</h1>
            <div>Welcome, Admin | <span id="current-date"></span></div>
        </div>

        <div class="form-container">
            <h2>Add New Staff Member</h2>

            <?php if ($message != ''): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="staffname">Staff Name</label>
                    <input type="text" id="staffname" name="staff_name" required>
                </div>

                <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" id="department" name="department_name" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" pattern="[0-9]{10}" title="Enter 10-digit number" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn">Register Staff</button>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('current-date').textContent = new Date().toLocaleDateString();
        });
    </script>
</body>

</html>