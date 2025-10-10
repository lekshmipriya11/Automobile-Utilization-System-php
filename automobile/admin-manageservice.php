<?php
include('dbconnection.php');

// Handle delete request
if (isset($_GET['delete_id'])) {
  $id = intval($_GET['delete_id']);
  $stmt = $con->prepare("DELETE FROM service WHERE service_id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
  echo "<script>alert('Service deleted successfully'); window.location='admin-manageservice.php';</script>";
}

// Handle service update
if (isset($_POST['update_service'])) {
  $id = intval($_POST['service_id']);
  $service_name = trim($_POST['service_name']);
  $description = trim($_POST['description']);
  $price = trim($_POST['price']);

  $stmt = $con->prepare("UPDATE service SET service_name=?, description=?, price=? WHERE service_id=?");
  $stmt->bind_param("sssi", $service_name, $description, $price, $id);
  $stmt->execute();
  $stmt->close();
  echo "<script>alert('Service updated successfully'); window.location='admin-manageservice.php';</script>";
}

// Fetch all services
$result = $con->query("SELECT * FROM service ORDER BY service_id ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Red Clover | Manage Services</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    /* Sidebar */
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

    /* Main Content */
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

    /* Table */
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

    /* Modal */
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

    .modal h2 {
      color: #ff4d00;
      text-align: center;
      margin-bottom: 20px;
    }

    .modal label {
      display: block;
      margin: 8px 0 4px;
      color: #ccc;
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
      <h1>Manage Services</h1>
      <div>Welcome, Admin | <span id="current-date"></span></div>
    </div>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Service Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['service_id'] ?></td>
              <td><?= htmlspecialchars($row['service_name']) ?></td>
              <td><?= htmlspecialchars($row['description']) ?></td>
              <td><?= htmlspecialchars($row['price']) ?></td>
              <td>
                <button class="action-btn view-btn" onclick="openViewModal('<?= htmlspecialchars($row['service_name']) ?>','<?= htmlspecialchars($row['description']) ?>','<?= htmlspecialchars($row['price']) ?>')">View</button>
                <button class="action-btn edit-btn" onclick="openEditModal('<?= $row['service_id'] ?>','<?= htmlspecialchars($row['service_name']) ?>','<?= htmlspecialchars($row['description']) ?>','<?= htmlspecialchars($row['price']) ?>')">Edit</button>
                <a href="?delete_id=<?= $row['service_id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this service?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" style="text-align:center;">No services found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>

  <!-- VIEW MODAL -->
  <div id="viewModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('viewModal')">&times;</span>
      <h2>Service Details</h2>
      <p><b>Service Name:</b> <span id="view_name"></span></p>
      <p><b>Description:</b> <span id="view_desc"></span></p>
      <p><b>Price:</b> <span id="view_price"></span></p>
    </div>
  </div>

  <!-- EDIT MODAL -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('editModal')">&times;</span>
      <h2>Edit Service</h2>
      <form method="POST" action="">
        <input type="hidden" name="service_id" id="edit_id">
        <label for="edit_name">Service Name</label>
        <input type="text" name="service_name" id="edit_name" required>
        <label for="edit_desc">Description</label>
        <textarea name="description" id="edit_desc" rows="3" required></textarea>
        <label for="edit_price">Price</label>
        <input type="text" name="price" id="edit_price" required>
        <button type="submit" name="update_service">Update Service</button>
      </form>
    </div>
  </div>

  <script>
    // Display current date
    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('current-date').textContent = new Date().toLocaleDateString();
    });

    // View Modal
    function openViewModal(name, desc, price) {
      document.getElementById('view_name').textContent = name;
      document.getElementById('view_desc').textContent = desc;
      document.getElementById('view_price').textContent = price;
      document.getElementById('viewModal').style.display = 'block';
    }

    // Edit Modal
    function openEditModal(id, name, desc, price) {
      document.getElementById('edit_id').value = id;
      document.getElementById('edit_name').value = name;
      document.getElementById('edit_desc').value = desc;
      document.getElementById('edit_price').value = price;
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