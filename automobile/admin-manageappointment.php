<?php
include('dbconnection.php');

// Handle delete request
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = $con->prepare("DELETE FROM appointments WHERE appointment_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Appointment deleted successfully'); window.location='admin-manageappointment.php';</script>";
}

// Handle edit/update request
if (isset($_POST['update_appointment'])) {
    $id = intval($_POST['appointment_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $vehicle_model = trim($_POST['vehicle_model']);
    $service_type = trim($_POST['service_type']);
    $appointment_date = trim($_POST['appointment_date']);
    $message = trim($_POST['message']);

    $stmt = $con->prepare("UPDATE appointments SET name=?, email=?, phone=?, vehicle_model=?, service_type=?, appointment_date=?, message=? WHERE appointment_id=?");
    $stmt->bind_param("sssssssi", $name, $email, $phone, $vehicle_model, $service_type, $appointment_date, $message, $id);
    if ($stmt->execute()) {
        echo "<script>alert('Appointment updated successfully!'); window.location='admin-manageappointment.php';</script>";
    } else {
        echo "<script>alert('Failed to update appointment.');</script>";
    }
    $stmt->close();
}

// Fetch all appointments
$result = $con->query("SELECT * FROM appointments ORDER BY appointment_date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Red Clover | Manage Appointments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif;}
       body {
            display: flex;
            min-height: 100vh;
            background: url('bugatti.jpg') no-repeat center center/cover;
            color: #fff;
        }

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

        /* Table */
        table {width:100%; border-collapse:collapse; background: rgba(30,30,30,0.85); border-radius:10px; overflow:hidden;}
        th, td {padding:12px 15px; text-align:left; color:#ccc; border-bottom:1px solid #333;}
        th {background:#1f1f1f; color:#ff4d00;}
        tr:hover {background: rgba(255,77,0,0.2);}
/* Action Buttons */
.action-btn {display: inline-flex;align-items: center;justify-content: center;gap: 5px;padding: 8px 12px;border: none;border-radius: 6px;cursor: pointer;color: #fff;font-size: 14px;text-decoration: none;transition: all 0.3s ease;vertical-align: middle;}

.view-btn { background: #ff9800; }
.edit-btn { background: #ff4d00; }
.delete-btn { background: #e04400; }

.action-btn:hover {transform: translateY(-2px);opacity: 0.9;}

/* Ensure all buttons in table cells are aligned properly */
td {vertical-align: middle;}

td .action-btn {margin-right: 5px;white-space: nowrap;}
        .view-btn {background:#ff4d00;}
        .edit-btn {background:#ff4d00;}
        .delete-btn {background:#e04400;}

        @media(max-width:992px){
            .sidebar {width:100%; position:relative; border-bottom:1px solid #333;}
            .main-content {margin-left:0; padding:25px;}
        }

        /* Modal */
        .modal {display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.8);}
        .modal-content {background-color:#1f1f1f; margin:10% auto; padding:20px; border-radius:8px; width:50%; box-shadow:0 0 10px rgba(0,0,0,0.5);}
        .close {color:#aaa; float:right; font-size:22px; font-weight:bold; cursor:pointer;}
        .close:hover {color:#fff;}
        .modal h2 {color:#ff4d00; text-align:center; margin-bottom:20px;}
        .modal label {display:block; margin:8px 0 4px; color:#ccc;}
        .modal input, .modal textarea, .modal select {width:100%; padding:8px; border:none; border-radius:4px; background:#333; color:#fff; margin-bottom:10px;}
        .modal button {background:#ff4d00; border:none; padding:8px 14px; border-radius:4px; color:#fff; cursor:pointer; margin-top:10px;}
        .modal button:hover {background:#ff661a;}
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
            <h1>Manage Appointments</h1>
            <div>Welcome, Admin | <span id="current-date"></span></div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Vehicle</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['appointment_id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td><?= htmlspecialchars($row['vehicle_model']) ?></td>
                            <td><?= htmlspecialchars($row['service_type']) ?></td>
                            <td><?= htmlspecialchars($row['appointment_date']) ?></td>
                            <td><?= htmlspecialchars($row['message']) ?></td>
                            <td>
                                <button class="action-btn view-btn" onclick="openViewModal(
                                    '<?= $row['appointment_id'] ?>','<?= htmlspecialchars($row['name']) ?>','<?= htmlspecialchars($row['email']) ?>',
                                    '<?= htmlspecialchars($row['phone']) ?>','<?= htmlspecialchars($row['vehicle_model']) ?>',
                                    '<?= htmlspecialchars($row['service_type']) ?>','<?= htmlspecialchars($row['appointment_date']) ?>',
                                    '<?= htmlspecialchars($row['message']) ?>'
                                )">View</button>

                                <button class="action-btn edit-btn" onclick="openEditModal(
                                    '<?= $row['appointment_id'] ?>','<?= htmlspecialchars($row['name']) ?>','<?= htmlspecialchars($row['email']) ?>',
                                    '<?= htmlspecialchars($row['phone']) ?>','<?= htmlspecialchars($row['vehicle_model']) ?>',
                                    '<?= htmlspecialchars($row['service_type']) ?>','<?= htmlspecialchars($row['appointment_date']) ?>',
                                    '<?= htmlspecialchars($row['message']) ?>'
                                )">Edit</button>

                                <a href="?delete_id=<?= $row['appointment_id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align:center;">No appointments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <!-- VIEW MODAL -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('viewModal')">&times;</span>
            <h2>Appointment Details</h2>
            <p><b>ID:</b> <span id="view_id"></span></p>
            <p><b>Name:</b> <span id="view_name"></span></p>
            <p><b>Email:</b> <span id="view_email"></span></p>
            <p><b>Phone:</b> <span id="view_phone"></span></p>
            <p><b>Vehicle:</b> <span id="view_vehicle"></span></p>
            <p><b>Service:</b> <span id="view_service"></span></p>
            <p><b>Date:</b> <span id="view_date"></span></p>
            <p><b>Message:</b> <span id="view_message"></span></p>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Edit Appointment</h2>
            <form method="POST" action="">
                <input type="hidden" name="appointment_id" id="edit_id">

                <label for="edit_name">Full Name</label>
                <input type="text" name="name" id="edit_name" required>

                <label for="edit_email">Email</label>
                <input type="email" name="email" id="edit_email" required>

                <label for="edit_phone">Phone</label>
                <input type="text" name="phone" id="edit_phone" required>

                <label for="edit_vehicle_model">Vehicle Model</label>
                <input type="text" name="vehicle_model" id="edit_vehicle_model" required>

                <label for="edit_service_type">Service Type</label>
                <select name="service_type" id="edit_service_type" required>
                    <option value="General Service">General Service</option>
                    <option value="Engine Repair">Engine Repair</option>
                    <option value="Oil Change">Oil Change</option>
                    <option value="Car Wash">Car Wash</option>
                    <option value="AC Repair">AC Repair</option>
                    <option value="Painting">Painting</option>
                </select>

                <label for="edit_appointment_date">Appointment Date</label>
                <input type="date" name="appointment_date" id="edit_appointment_date" required>

                <label for="edit_message">Message</label>
                <textarea name="message" id="edit_message" rows="3"></textarea>

                <button type="submit" name="update_appointment">Update Appointment</button>
            </form>
        </div>
    </div>

    <script>
        function openViewModal(id, name, email, phone, vehicle, service, date, message) {
            document.getElementById('view_id').textContent = id;
            document.getElementById('view_name').textContent = name;
            document.getElementById('view_email').textContent = email;
            document.getElementById('view_phone').textContent = phone;
            document.getElementById('view_vehicle').textContent = vehicle;
            document.getElementById('view_service').textContent = service;
            document.getElementById('view_date').textContent = date;
            document.getElementById('view_message').textContent = message;
            document.getElementById('viewModal').style.display = 'block';
        }

        function openEditModal(id, name, email, phone, vehicle, service, date, message) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('edit_vehicle_model').value = vehicle;
            document.getElementById('edit_service_type').value = service;
            document.getElementById('edit_appointment_date').value = date;
            document.getElementById('edit_message').value = message;
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

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('current-date').textContent = new Date().toLocaleDateString();
        });
    </script>
</body>
</html>
