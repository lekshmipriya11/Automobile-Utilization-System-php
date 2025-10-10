<?php
session_start();
include('dbconnection.php');

$message = '';

// ----------------------
// Handle Edit Submission
// ----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staff_id'])) {
    $staff_id = intval($_POST['staff_id']);
    $staff_name = trim($_POST['staff_name']);
    $department_name = trim($_POST['department_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if (!empty($staff_name) && !empty($department_name) && !empty($phone) && !empty($email)) {
        $stmt = $con->prepare("UPDATE staff_signup SET staff_name=?, department_name=?, phone=?, email=? WHERE staff_id=?");
        $stmt->bind_param("ssssi", $staff_name, $department_name, $phone, $email, $staff_id);
        if ($stmt->execute()) {
            $message = "Staff updated successfully!";
        } else {
            $message = "Error updating staff: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "All fields are required!";
    }
}

// ----------------------
// Fetch all staff
// ----------------------
$staffList = [];
$result = $con->query("SELECT * FROM staff_signup ORDER BY staff_id ASC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $staffList[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Red Clover | Manage Staff</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: url('bugatti.jpg') no-repeat center center/cover;
            color: #fff;
        }

        .sidebar {
            background: rgba(0, 0, 0, 0.9);
            width: 250px;
            min-height: 100vh;
            padding: 30px 20px;
            position: fixed;
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
            transition: .3s;
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

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(30, 30, 30, 0.85);
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            color: #ccc;
            border-bottom: 1px solid #333;
        }

        th {
            background: #1f1f1f;
            color: #ff4d00;
        }

        tr:hover {
            background: rgba(255, 77, 0, 0.2);
        }

        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            margin-right: 5px;
        }

        .view-btn {
            background: #ff4d00;
        }

        .edit-btn {
            background: #ff4d00;
        }

        .delete-btn {
            background: #e04400;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            color: #ff4d00;
            font-weight: 600;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            background-color: #1f1f1f;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            color: #fff;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #fff;
        }

        .modal label {
            display: block;
            margin: 8px 0 4px;
        }

        .modal input,
        .modal textarea {
            width: 100%;
            padding: 8px;
            border: none;
            border-radius: 4px;
            background: #333;
            color: #fff;
            margin-bottom: 10px;
        }

        .modal button {
            background: #ff4d00;
            border: none;
            padding: 8px 14px;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            margin-top: 10px;
        }

        .modal button:hover {
            background: #ff661a;
        }

        @media(max-width:992px) {
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
            <h1>Manage Staff</h1>
            <div>Welcome, Admin | <span id="current-date"></span></div>
        </div>

        <?php if ($message != ''): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($staffList)): ?>
                    <?php foreach ($staffList as $staff): ?>
                        <tr>
                            <td><?= $staff['staff_id'] ?></td>
                            <td><?= htmlspecialchars($staff['staff_name']) ?></td>
                            <td><?= htmlspecialchars($staff['department_name']) ?></td>
                            <td><?= htmlspecialchars($staff['phone']) ?></td>
                            <td><?= htmlspecialchars($staff['email']) ?></td>
                            <td>
                                <button class="action-btn view-btn" onclick="openViewModal('<?= htmlspecialchars($staff['staff_name']) ?>','<?= htmlspecialchars($staff['department_name']) ?>','<?= htmlspecialchars($staff['phone']) ?>','<?= htmlspecialchars($staff['email']) ?>')">View</button>
                                <button class="action-btn edit-btn" onclick="openEditModal('<?= $staff['staff_id'] ?>','<?= htmlspecialchars($staff['staff_name']) ?>','<?= htmlspecialchars($staff['department_name']) ?>','<?= htmlspecialchars($staff['phone']) ?>','<?= htmlspecialchars($staff['email']) ?>')">Edit</button>
                                <form method="POST" action="admin-deletestaff.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $staff['staff_id'] ?>">
                                    <button type="submit" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this staff?');"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No staff registered yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <!-- VIEW MODAL -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('viewModal')">&times;</span>
            <h2>Staff Details</h2>
            <p><b>Name:</b> <span id="view_name"></span></p>
            <p><b>Department:</b> <span id="view_dept"></span></p>
            <p><b>Phone:</b> <span id="view_phone"></span></p>
            <p><b>Email:</b> <span id="view_email"></span></p>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Edit Staff</h2>
            <form method="POST">
                <input type="hidden" name="staff_id" id="edit_id">
                <label>Name</label>
                <input type="text" name="staff_name" id="edit_name" required>
                <label>Department</label>
                <input type="text" name="department_name" id="edit_dept" required>
                <label>Phone</label>
                <input type="text" name="phone" id="edit_phone" required>
                <label>Email</label>
                <input type="email" name="email" id="edit_email" required>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('current-date').textContent = new Date().toLocaleDateString();
        });

        function openViewModal(name, dept, phone, email) {
            document.getElementById('view_name').textContent = name;
            document.getElementById('view_dept').textContent = dept;
            document.getElementById('view_phone').textContent = phone;
            document.getElementById('view_email').textContent = email;
            document.getElementById('viewModal').style.display = 'block';
        }

        function openEditModal(id, name, dept, phone, email) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_dept').value = dept;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('edit_email').value = email;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>
