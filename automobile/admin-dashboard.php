<?php
session_start();
include('dbconnection.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ===== Total Customers =====
$customerCount = 0;
$result = $con->query("SELECT COUNT(*) AS count FROM user_registration"); // replace 'register' with your actual customer table name
if ($result && $row = $result->fetch_assoc()) {
    $customerCount = $row['count'];
}

// ===== Active Appointments =====
$activeAppointments = 0;
$result = $con->query("SELECT COUNT(*) AS count FROM appointments WHERE appointment_date >= CURDATE()");
if ($result && $row = $result->fetch_assoc()) {
    $activeAppointments = $row['count'];
}

// ===== Total Revenue =====
$totalRevenue = 0;
$result = $con->query("SELECT SUM(amount) AS total FROM payment");
if ($result && $row = $result->fetch_assoc()) {
    $totalRevenue = $row['total'] ?: 0;
}

// ===== Recent Activities =====
$recentActivities = [];
$result = $con->query("SELECT name, service_type, appointment_date FROM appointments ORDER BY appointment_date DESC LIMIT 5");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recentActivities[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Red Clover | Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        /* ===== Base Styles ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: url('bugatti.jpg') no-repeat center center/cover;
            /* color: #fff; */
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 250px;
            background: rgba(0, 0, 0, 0.9);
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            min-height: 100vh;
        }

        .logo {
            font-size: 26px;
            font-weight: 700;
            color: #ff4d00;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 40px;
        }

        .sidebar-menu {
            list-style: none;
            flex-grow: 1;
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

        .logout-btn {
            margin-top: 30px;
            text-align: center;
        }

        .logout-btn a {
            display: inline-block;
            background: #ff4d00;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s ease;
        }

        .logout-btn a:hover {
            background: #e13e00;
        }

        /* ===== Main Content ===== */
        .main-content {
            margin-left: 250px;
            padding: 40px;
            flex: 1;
            overflow-y: auto;
            /* background: rgba(0, 0, 0, 0.6); */
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .dashboard-header h1 {
            color: #ff4d00;
            font-size: 30px;
            font-weight: 700;
        }

        .dashboard-header span {
            font-weight: 500;
            color: #ddd;
        }

        /* ===== Stats Cards ===== */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            /* background: rgba(30, 30, 30, 0.85); */
            border-radius: 12px;
            padding: 25px;
            border-left: 5px solid #ff4d00;
            transition: 0.3s ease;
            text-align: left;
        }

        .stat-card:hover {
            background: rgba(40, 40, 40, 0.9);
            transform: translateY(-5px);
        }

        .stat-card h3 {
            color: #aaa;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .stat-card .value {
            font-size: 26px;
            font-weight: 700;
            color: #ff4d00;
        }

        /* ===== Recent Activities Section ===== */
        .dashboard-section {
            background: rgba(30, 30, 30, 0.85);
            border-radius: 12px;
            padding: 30px;
        }

        .dashboard-section h2 {
            font-size: 22px;
            color: #ff4d00;
            margin-bottom: 20px;
            border-bottom: 2px solid #444;
            padding-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: #fff;
            text-align: left;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #444;
        }

        th {
            color: #ff4d00;
            text-transform: uppercase;
            font-size: 14px;
        }

        td {
            font-size: 15px;
        }

        @media(max-width: 992px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: relative;
                border-bottom: 1px solid #333;
                flex-direction: row;
                justify-content: space-between;
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

                <!-- Staff Dropdown -->
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
            <h1>Admin Dashboard</h1>
            <div>Welcome, <span>Admin</span> | <span id="current-date"></span></div>
        </div>

        <div class="stats-cards">
            <div class="stat-card">
                <h3>TOTAL CUSTOMERS</h3>
                <div class="value"><?php echo $customerCount; ?></div>
            </div>

            <div class="stat-card">
                <h3>ACTIVE APPOINTMENTS</h3>
                <div class="value"><?php echo $activeAppointments; ?></div>
            </div>

            <div class="stat-card">
                <h3>TOTAL REVENUE</h3>
                <div class="value">₹<?php echo number_format($totalRevenue, 2); ?></div>
            </div>
        </div>

        <section class="dashboard-section">
            <h2>Recent Activities</h2>
            <?php if (!empty($recentActivities)) { ?>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Service</th>
                        <th>Appointment Date</th>
                    </tr>
                    <?php foreach ($recentActivities as $activity) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($activity['name']); ?></td>
                            <td><?php echo htmlspecialchars($activity['service_type']); ?></td>
                            <td><?php echo htmlspecialchars($activity['appointment_date']); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p>No recent activities to display.</p>
            <?php } ?>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('current-date').textContent = new Date().toLocaleDateString();
        });
    </script>
</body>

</html>