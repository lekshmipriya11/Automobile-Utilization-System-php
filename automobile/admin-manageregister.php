<?php
include('dbconnection.php'); // Database connection

// Handle update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = intval($_POST['user_id']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    $stmt = $con->prepare("UPDATE user_registration SET username=?, email=?, phone=?, address=? WHERE user_id=?");
    $stmt->bind_param("ssssi", $username, $email, $phone, $address, $user_id);
    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully'); window.location='admin-manageregister.php';</script>";
    } else {
        echo "<script>alert('Update failed');</script>";
    }
    $stmt->close();
}

// Fetch all users
$result = $con->query("SELECT * FROM user_registration ORDER BY user_id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Red Clover | Manage Customers</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
* {margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif;}
body {display: flex; min-height: 100vh; background: url('bugatti.jpg') no-repeat center center/cover; color: #fff;}

/* Sidebar */
.sidebar {background:rgba(0,0,0,0.9); width:250px; padding:30px 20px; position:fixed; top:0; bottom:0;}
.logo {font-size:26px; color:#ff4d00; font-weight:700; margin-bottom:40px; display:flex; align-items:center; gap:8px;}
.sidebar-menu {list-style:none;}
.sidebar-menu li {margin:15px 0;}
.sidebar-menu a {text-decoration:none; color:#ddd; display:block; padding:10px 15px; border-radius:6px; transition:.3s;}
.sidebar-menu a:hover, .sidebar-menu a.active {background:#ff4d00; color:#fff;}
.submenu {list-style:none; margin-left:20px; display:none;}
.dropdown:hover .submenu {display:block;}

/* Main Content */
.main-content {margin-left:270px; flex:1; padding:40px;}
h1 {color:#ff4d00; margin-bottom:20px; text-align:center;}
table {width:100%; border-collapse:collapse; background:rgba(30,30,30,0.8); border-radius:10px; overflow:hidden;}
th,td {padding:12px 15px; border-bottom:1px solid #333; text-align:left; color:#ccc;}
th {background:#1f1f1f; color:#ff4d00;}
tr:hover {background:rgba(255,77,0,0.2);}
.action-btn {padding:5px 10px; border:none; border-radius:4px; cursor:pointer; color:#fff; margin-right:5px;}
.view-btn {background:#ff4d00;}
.edit-btn {background:#ff4d00;}
.delete-btn {background:#e04400;}
@media(max-width:992px){.sidebar{width:100%; position:relative; border-bottom:1px solid #333;} .main-content{margin-left:0; padding:25px;}}

/* Modal */
.modal {display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; overflow:auto;
background-color:rgba(0,0,0,0.8);}
.modal-content {background-color:#1f1f1f; margin:10% auto; padding:20px; border-radius:8px; width:400px; 
box-shadow:0 0 10px rgba(0,0,0,0.5);}
.close {color:#aaa; float:right; font-size:22px; font-weight:bold; cursor:pointer;}
.close:hover {color:#fff;}
.modal h2 {color:#ff4d00; text-align:center; margin-bottom:20px;}
.modal label {display:block; margin:8px 0 4px; color:#ccc;}
.modal input, .modal textarea {width:100%; padding:8px; border:none; border-radius:4px; background:#333; color:#fff;}
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
<div class="main-content">
  <h1>Manage Customers</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Username</th><th>Email</th><th>Phone</th><th>Address</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['user_id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['address']) ?></td>
            <td>
              <button 
                class="action-btn view-btn" 
                onclick="openViewModal(<?= $row['user_id'] ?>, '<?= htmlspecialchars($row['username']) ?>', '<?= htmlspecialchars($row['email']) ?>', '<?= htmlspecialchars($row['phone']) ?>', '<?= htmlspecialchars($row['address']) ?>')">
                View
              </button>

              <button 
                class="action-btn edit-btn" 
                onclick="openEditModal(<?= $row['user_id'] ?>, '<?= htmlspecialchars($row['username']) ?>', '<?= htmlspecialchars($row['email']) ?>', '<?= htmlspecialchars($row['phone']) ?>', '<?= htmlspecialchars($row['address']) ?>')">
                Edit
              </button>

              <form action="admin-deleteuser.php" method="GET" style="display:inline;">
                <input type="hidden" name="id" value="<?= $row['user_id'] ?>">
                <button type="submit" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">
                  Delete
                </button>
              </form>
            </td>

          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="7" style="text-align:center;">No customers found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- VIEW MODAL -->
<div id="viewModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('viewModal')">&times;</span>
    <h2>View Customer</h2>
    <p><b>ID:</b> <span id="view_id"></span></p>
    <p><b>Username:</b> <span id="view_username"></span></p>
    <p><b>Email:</b> <span id="view_email"></span></p>
    <p><b>Phone:</b> <span id="view_phone"></span></p>
    <p><b>Address:</b> <span id="view_address"></span></p>
  </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('editModal')">&times;</span>
    <h2>Edit Customer</h2>
    <form method="POST" action="">
      <input type="hidden" id="edit_id" name="user_id">
      <label>Username</label>
      <input type="text" id="edit_username" name="username" required>
      <label>Email</label>
      <input type="email" id="edit_email" name="email" required>
      <label>Phone</label>
      <input type="text" id="edit_phone" name="phone">
      <label>Address</label>
      <textarea id="edit_address" name="address" rows="3"></textarea>
      <button type="submit" name="update_user">Update</button>
    </form>
  </div>
</div>

<script>
function openViewModal(id, username, email, phone, address){
  document.getElementById('view_id').textContent = id;
  document.getElementById('view_username').textContent = username;
  document.getElementById('view_email').textContent = email;
  document.getElementById('view_phone').textContent = phone;
  document.getElementById('view_address').textContent = address;
  document.getElementById('viewModal').style.display = 'block';
}

function openEditModal(id, username, email, phone, address){
  document.getElementById('edit_id').value = id;
  document.getElementById('edit_username').value = username;
  document.getElementById('edit_email').value = email;
  document.getElementById('edit_phone').value = phone;
  document.getElementById('edit_address').value = address;
  document.getElementById('editModal').style.display = 'block';
}

function closeModal(modalId){
  document.getElementById(modalId).style.display = 'none';
}

window.onclick = function(event){
  if(event.target.classList.contains('modal')){
    event.target.style.display='none';
  }
}
</script>
</body>
</html>
