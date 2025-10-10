<?php
// services.php
session_start();
include('dbconnection.php');

// Fetch services from the database
$services = [];
$query = "SELECT * FROM service ORDER BY service_name ASC"; // correct table name
$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // No 'features' column in table, so create empty array
        $row['features'] = [];
        // No 'icon' column, assign default icon
        $row['icon'] = 'fas fa-tools';
        $services[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Red Clover | Our Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS from your original file */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #0f0f0f;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: rgba(0, 0, 0, 0.85);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: #ff4d00;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            position: relative;
            cursor: pointer;
        }

        .logo i {
            margin-right: 10px;
            color: #ff4d00;
        }

        .logo-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: rgba(15, 15, 15, 0.98);
            min-width: 220px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ff4d00;
            margin-top: 10px;
            transition: opacity 0.3s ease;
        }

        .dropdown-content a {
            color: #fff;
            padding: 14px 18px;
            text-decoration: none;
            display: block;
            transition: 0.3s;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dropdown-content a:last-child {
            border-bottom: none;
        }

        .dropdown-content a:hover {
            background-color: #ff4d00;
            padding-left: 22px;
        }

        .dropdown-content a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
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

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 4px;
            transition: all 0.3s ease;
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

        .services-hero {
            height: 50vh;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1500&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 20px;
        }

        .hero-content {
            max-width: 800px;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            color: #ff4d00;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #ddd;
        }

        .services-section {
            padding: 80px 50px;
            background: rgba(20, 20, 20, 0.95);
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: #ff4d00;
            margin-bottom: 15px;
        }

        .section-title p {
            color: #aaa;
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .service-card {
            background: rgba(30, 30, 30, 0.8);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            border-bottom: 3px solid #ff4d00;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 77, 0, 0.1) 0%, rgba(255, 77, 0, 0) 100%);
            z-index: 1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(255, 77, 0, 0.2);
        }

        .service-card:hover::before {
            opacity: 1;
        }

        .service-card i {
            font-size: 3rem;
            color: #ff4d00;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .service-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }

        .service-card p {
            color: #aaa;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .service-features {
            text-align: left;
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
        }

        .service-features li {
            color: #ddd;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .service-features li i {
            font-size: 1rem;
            margin-right: 10px;
            margin-bottom: 0;
            color: #ff4d00;
        }

        .service-price {
            font-size: 1.5rem;
            color: #ff4d00;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .service-price span {
            font-size: 1rem;
            color: #aaa;
            font-weight: 400;
        }

        .btn {
            padding: 12px 25px;
            background: #ff4d00;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .btn:hover {
            background: #e04400;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 77, 0, 0.4);
        }

        @media(max-width:992px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:768px) {
            .navbar {
                padding: 15px 20px;
                flex-direction: column;
            }

            .nav-links {
                margin-top: 15px;
                gap: 10px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .services-hero {
                height: auto;
                padding: 80px 20px;
            }

            .services-section {
                padding: 60px 20px;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .services-grid {
                grid-template-columns: 1fr;
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
        <a href="services.php" class="active"><i class="fas fa-tools"></i> Services</a>
        <a href="contact.html"><i class="fas fa-envelope"></i> Contact</a>
        <a href="staff_login.html"><i class="fas fa-sign-in-alt"></i> Staff Login</a>
        <a href="staff_signup.html"><i class="fas fa-sign-in-alt"></i> Staff Signup</a>
        <a href="user_login.html"><i class="fas fa-sign-in-alt"></i> Login</a>
        <a href="user_registration.html"><i class="fas fa-user-plus"></i> Register</a>
        <a href="admin_login.php"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a>
      </div>
    </div>
    <div class="nav-links">
      <a href="home.php">Home</a>
      <a href="about.html">About</a>
      <a href="services.php" class="active">Services</a>
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
    <!-- Hero -->
    <section class="services-hero">
        <div class="hero-content">
            <h1>Our Premium Services</h1>
            <p>Experience the finest automotive care with our comprehensive range of services.</p>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="services-section">
        <div class="section-title">
            <h2>Our Services</h2>
            <p>Explore our premium automotive services</p>
        </div>
        <div class="services-grid">
            <?php if (empty($services)): ?>
                <p style="grid-column:1/-1;text-align:center;padding:40px;">No services available at the moment. Please check back later.</p>
            <?php else: ?>
                <?php foreach ($services as $service): ?>
                    <div class="service-card">
                        <i class="<?php echo $service['icon']; ?>"></i>
                        <h3><?php echo $service['service_name']; ?></h3>
                        <p><?php echo $service['description']; ?></p>

                        <div class="service-price">From Rs<?php echo $service['price']; ?></div>
                        <button class="btn book-btn" data-service="<?php echo $service['service_name']; ?>" data-price="<?php echo $service['price']; ?>">Book Now</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <script>
        function toggleDropdown() {
            document.getElementById('dropdownMenu').classList.toggle('show-dropdown');
        }

        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('dropdownMenu');
            const logo = document.querySelector('.logo');
            if (!logo.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show-dropdown');
            }
        });

        // Handle Book Now button clicks
        const bookButtons = document.querySelectorAll('.book-btn');
        bookButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const service = btn.getAttribute('data-service');
                const price = btn.getAttribute('data-price');
                // Redirect to appointment.php with GET parameters
                window.location.href = `appointment.php?service=${encodeURIComponent(service)}&price=${encodeURIComponent(price)}`;
            });
        });
    </script>

    <script>
        function toggleDropdown() {
            document.getElementById('dropdownMenu').classList.toggle('show-dropdown');
        }
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('dropdownMenu');
            const logo = document.querySelector('.logo');
            if (!logo.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show-dropdown');
            }
        });
    </script>
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