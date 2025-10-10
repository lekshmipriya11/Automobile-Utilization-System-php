<?php
session_start();

// ---------- Fixed Admin Credentials ----------
$admin_username = "admin";
$admin_password = "admin123"; // Change as needed

$error = '';

// ---------- Handle Login Submission ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === $admin_username && $password === $admin_password) {
        // Successful login
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin_username;

        // Redirect to admin dashboard
        header("Location: admin-dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Red Clover | Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ---------- Base Styles ---------- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: url('bugatti.jpg') no-repeat center center/cover fixed;
            color: #fff;
            /* min-height: 100vh; */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        a {
            text-decoration: none;
        }

        /* ---------- Navbar ---------- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: rgba(0, 0, 0, 0.85);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: #ff4d00;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .logo i {
            margin-right: 10px;
        }

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .nav-links a {
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 4px;
            transition: 0.3s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            background: #ff4d00;
            color: #fff;
        }

        /* ---------- Login Form ---------- */
        /* Add space between navbar and login form */
        .login-container-wrapper {
            margin-top: 100px;
            /* Adjust as needed */
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .login-container {
            background: rgba(15, 15, 15, 0.85);
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 77, 0, 0.3);
            text-align: center;

        }

        .login-container h1 {
            font-size: 32px;
            color: #ff4d00;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #ddd;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #ff4d00;
        }

        .form-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border-radius: 8px;
            border: 1px solid #333;
            background: rgba(50, 50, 50, 0.7);
            color: #fff;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #ff4d00;
            box-shadow: 0 0 0 3px rgba(255, 77, 0, 0.2);
            background: rgba(60, 60, 60, 0.7);
        }

        .btn {
            width: 100%;
            padding: 15px;
            background: #ff4d00;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #e04400;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 77, 0, 0.4);
        }

        .error-msg {
            background: rgba(58, 26, 20, 0.9);
            color: #ffd0c2;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .login-link {
            margin-top: 15px;
            color: #aaa;
        }

        .login-link a {
            color: #ff4d00;
            font-weight: 500;
        }

        @media(max-width:768px) {
            .navbar {
                flex-direction: column;
                padding: 15px 20px;
            }

            .nav-links {
                margin-top: 10px;
                gap: 10px;
            }

            .login-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo"><i class="fas fa-car"></i> Red Clover</div>
        <div class="nav-links">
            <a href="home.php">Home</a>
            <a href="about.html">About</a>
            <a href="services.php">Services</a>
            <a href="contact.html">Contact</a>
            <a href="user_login.html">Login</a>
            <a href="user_registration.html">Register</a>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="login-container-wrapper">
        <div class="login-container">
            <h1>Admin Login</h1>

            <?php if ($error): ?>
                <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" placeholder="Enter admin username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Enter password" required>
                    </div>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>

            <div class="login-link">
                <p>Back to <a href="home.php">Home</a></p>
            </div>
        </div>
    </div>


</body>

</html>