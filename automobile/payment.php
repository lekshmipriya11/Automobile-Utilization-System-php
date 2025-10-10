<?php
session_start();
include('dbconnection.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Get appointment ID and price
$appointment_id = isset($_GET['appointment_id']) ? intval($_GET['appointment_id']) : 0;
$price = isset($_GET['price']) ? floatval($_GET['price']) : 500;

// Fetch appointment details
$stmt = $con->prepare("SELECT * FROM appointments WHERE appointment_id=?");
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

if (!$appointment) {
    die("<h3 style='color:red; text-align:center;'>Invalid appointment.</h3>");
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $price;
    $method = trim($_POST['payment_method']);
    $status = 'Paid';

    $stmt = $con->prepare("INSERT INTO payment (appointment_id, amount, payment_method, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idss", $appointment_id, $amount, $method, $status);

    if ($stmt->execute()) {
        echo "<script>
            alert('Payment successful! Your appointment is confirmed.');
            window.location='home.php';
        </script>";
        exit;
    } else {
        $error = "Failed to process payment. Please try again.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | Red Clover</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- GLOBAL --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

          
        body {
            background-image: url(bugatti.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- NAVBAR --- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 50px;
            background: rgba(0, 0, 0, 0.85);
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.5);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 26px;
            font-weight: 700;
            color: #ff4d00;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .logo i {
            margin-right: 8px;
            color: #ff4d00;
        }

        .nav-links {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #fff;
            font-size: 17px;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ff4d00;
        }

        .nav-links a.active {
            background: #ff4d00;
            color: #fff;
        }

        /* --- Profile Dropdown --- */
        .profile-dropdown {
            position: relative;
            padding-top: 10px;

        }

        .profile-dropdown i {
            font-size: 22px;
            cursor: pointer;
        }

        .profile-content {
            display: none;
            position: absolute;
            right: 0;
            top: 35px;
            background: rgba(20, 20, 20, 0.98);
            border: 1px solid #ff4d00;
            border-radius: 8px;
            min-width: 160px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        .profile-content a {
            display: block;
            padding: 12px 15px;
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
        }

        .profile-content a:hover {
            background: #ff4d00;
            padding-left: 20px;
        }

        .show-dropdown {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- PAYMENT FORM --- */
        .payment-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
        }

        .form-container {
            background: rgba(25, 25, 25, 0.95);
            padding: 35px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
            text-align: center;
        }

        .form-container h2 {
            color: #ff4d00;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            text-align: left;
            color: #ccc;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border-radius: 6px;
            border: 1px solid #444;
            background: #2c2c2c;
            color: #fff;
            font-size: 15px;
        }

        input[readonly] {
            background: #222;
            color: #aaa;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background: #ff4d00;
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #e04400;
        }

        .error {
            color: #ff4d00;
            margin-bottom: 10px;
        }

        .success {
            color: #00ff7f;
            margin-bottom: 10px;
        }

        @media(max-width: 600px) {
            .form-container {
                width: 90%;
            }

            .navbar {
                flex-direction: column;
                padding: 15px 20px;
            }

            .nav-links {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
  <nav class="navbar">
    <div class="logo-dropdown">
      <div class="logo" onclick="toggleDropdown()">
        <i class="fas fa-car"></i>
        <span>Red Clover</span>
        <i class="fas fa-chevron-down" style="margin-left: 10px; font-size: 16px;"></i>
      </div>
      <div class="dropdown-content" id="dropdownMenu">
        <a href="home.php"><i class="fas fa-home"></i> Home</a>
        <a href="about.html"><i class="fas fa-info-circle"></i> About</a>
        <a href="services.php"><i class="fas fa-tools"></i> Services</a>
        <a href="contact.html"><i class="fas fa-envelope"></i> Contact</a>
        <a href="staff_login.html"><i class="fas fa-sign-in-alt"></i> Staff Login</a>
        <a href="staff_signup.html"><i class="fas fa-sign-in-alt"></i> Staff Signup</a>
        <a href="user_login.html"><i class="fas fa-sign-in-alt"></i> Login</a>
        <a href="user_registration.html"><i class="fas fa-user-plus"></i> Register</a>
        <a href="admin_login.php"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a>
      </div>
    </div>
    <div class="nav-links">
      <a href="home.php" class="active">Home</a>
      <a href="about.html">About</a>
      <a href="services.php">Services</a>
      <a href="contact.html">Contact</a>
     <div class="profile-dropdown">
                <i class="fas fa-user-circle" onclick="toggleProfileDropdown()"></i>
                <div class="profile-content" id="profileMenu">
                    <a href="user_login.html"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <a href="user_registration.html"><i class="fas fa-user-plus"></i> Register</a>
                </div>
            </div>
    </div>
  </nav>

    <!-- Payment Form -->
    <div class="payment-wrapper">
        <div class="form-container">
            <h2>Payment for <?php echo htmlspecialchars($appointment['service_type']); ?></h2>

            <?php if ($error) echo "<p class='error'>$error</p>"; ?>
            <?php if ($success) echo "<p class='success'>$success</p>"; ?>

            <form method="POST">
                <label>Amount (₹)</label>
                <input type="text" name="amount" value="<?php echo $price; ?>" readonly>

                <label>Payment Method</label>
                <select name="payment_method" required>
                    <option value="">--Select--</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="UPI">UPI</option>
                    <option value="Cash">Cash</option>
                </select>

                <button type="submit">Pay Now</button>
            </form>
        </div>
    </div>

    <script>
        function toggleProfileDropdown() {
            const profileMenu = document.getElementById('profileMenu');
            profileMenu.classList.toggle('show-dropdown');
        }

        document.addEventListener('click', function (event) {
            const profileMenu = document.getElementById('profileMenu');
            const profileIcon = document.querySelector('.profile-dropdown i');

            if (!profileIcon.contains(event.target) && !profileMenu.contains(event.target)) {
                profileMenu.classList.remove('show-dropdown');
            }
        });
    </script>

</body>
</html>
