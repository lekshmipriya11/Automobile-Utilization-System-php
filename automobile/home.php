<?php
// Start session and include database connection
session_start();
include('dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Red Clover | Premium Automobile Services</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
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

    /* Navbar */
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
    /* Hero Section */
    .hero {
      height: 80vh;
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

    .hero h1 {
      font-size: 3.5rem;
      margin-bottom: 20px;
      color: #ff4d00;
    }

    .hero p {
      font-size: 1.2rem;
      margin-bottom: 30px;
      color: #ddd;
    }

    .hero-btn {
      padding: 15px 30px;
      background: #ff4d00;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin: 0 10px;
    }

    .hero-btn:hover {
      background: #e04400;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255, 77, 0, 0.4);
    }

    .hero-btn.outline {
      background: transparent;
      border: 2px solid #ff4d00;
      color: #ff4d00;
    }

    .hero-btn.outline:hover {
      background: #ff4d00;
      color: white;
    }

    .hero-buttons {
      display: flex;
      justify-content: center;
    }

    /* Services Section (Dynamic) */
    .services {
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
    }

    .service-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 25px rgba(255, 77, 0, 0.2);
    }

    .service-card i {
      font-size: 3rem;
      color: #ff4d00;
      margin-bottom: 20px;
    }

    .service-card h3 {
      font-size: 1.5rem;
      margin-bottom: 15px;
    }

    .service-card p {
      color: #aaa;
      margin-bottom: 15px;
    }

    .service-price {
      color: #ff4d00;
      font-weight: bold;
      font-size: 1.2rem;
      margin-bottom: 10px;
    }

    .hero-btn.small {
      font-size: 14px;
      padding: 10px 20px;
    }

    /* About Section */
    .about {
      padding: 80px 50px;
      background: rgba(15, 15, 15, 0.95);
    }

    .about-content {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 50px;
      align-items: center;
    }

    .about-text h2 {
      font-size: 2.5rem;
      color: #ff4d00;
      margin-bottom: 20px;
    }

    .about-text p {
      color: #ddd;
      margin-bottom: 20px;
      line-height: 1.6;
    }

    .about-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-top: 30px;
    }

    .stat {
      text-align: center;
    }

    .stat .number {
      font-size: 2.5rem;
      color: #ff4d00;
      font-weight: 700;
    }

    .stat .label {
      color: #aaa;
    }

    .about-image {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .about-image img {
      width: 100%;
      height: auto;
      display: block;
    }

    /* Testimonials */
    .testimonials {
      padding: 80px 50px;
      background: rgba(20, 20, 20, 0.95);
    }

    .testimonials-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
    }

    .testimonial-card {
      background: rgba(30, 30, 30, 0.8);
      border-radius: 10px;
      padding: 30px;
      position: relative;
    }

    .testimonial-card .quote {
      position: absolute;
      top: 20px;
      right: 20px;
      font-size: 3rem;
      color: #ff4d00;
      opacity: 0.2;
    }

    .testimonial-text {
      color: #ddd;
      margin-bottom: 20px;
      line-height: 1.6;
    }

    .testimonial-author {
      display: flex;
      align-items: center;
    }

    .author-image {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      overflow: hidden;
      margin-right: 15px;
    }

    .author-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .author-details h4 {
      color: #ff4d00;
      margin-bottom: 5px;
    }

    .author-details p {
      color: #aaa;
      font-size: 0.9rem;
    }

    /* CTA */
    .cta {
      padding: 80px 50px;
      background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1500&q=80');
      background-size: cover;
      background-position: center;
      text-align: center;
    }

    .cta h2 {
      font-size: 2.5rem;
      color: #ff4d00;
      margin-bottom: 20px;
    }

    .cta p {
      color: #ddd;
      max-width: 700px;
      margin: 0 auto 30px;
      font-size: 1.1rem;
    }

    /* Footer */
    .footer {
      background: rgba(0, 0, 0, 0.95);
      padding: 50px;
    }

    .footer-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      margin-bottom: 30px;
    }

    .footer-column h3 {
      color: #ff4d00;
      margin-bottom: 20px;
      font-size: 1.5rem;
    }

    .footer-column p,
    .footer-column li {
      color: #aaa;
      margin-bottom: 10px;
      line-height: 1.6;
    }

    .footer-column ul {
      list-style: none;
    }

    .footer-column ul li {
      margin-bottom: 10px;
    }

    .footer-column ul li a {
      color: #aaa;
      text-decoration: none;
      transition: color 0.3s;
    }

    .footer-column ul li a:hover {
      color: #ff4d00;
    }

    .footer-bottom {
      text-align: center;
      padding-top: 30px;
      border-top: 1px solid #333;
    }

    .footer-bottom p {
      color: #aaa;
    }

    .social-icons {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    .social-icons a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background: #333;
      color: #ff4d00;
      border-radius: 50%;
      transition: all 0.3s ease;
    }

    .social-icons a:hover {
      background: #ff4d00;
      color: white;
      transform: translateY(-3px);
    }

    /* Responsive */
    @media(max-width:992px) {
      .about-content {
        grid-template-columns: 1fr
      }

      .hero h1 {
        font-size: 2.5rem
      }
    }

    @media(max-width:768px) {
      .navbar {
        padding: 15px 20px;
        flex-direction: column
      }

      .nav-links {
        margin-top: 15px;
        gap: 10px
      }

      .hero {
        height: auto;
        padding: 80px 20px
      }

      .services,
      .about,
      .testimonials,
      .cta {
        padding: 60px 20px
      }

      .hero h1 {
        font-size: 2rem
      }

      .hero-buttons {
        flex-direction: column;
        gap: 15px
      }

      .hero-btn {
        margin: 5px 0
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
        <a href="home.php"  class="active"><i class="fas fa-home"></i> Home</a>
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

  <!-- Hero -->
  <section class="hero">
    <div class="hero-content">
      <h1>Premium Automobile Services</h1>
      <p>Experience the finest automotive care with our expert team. From routine maintenance to complex repairs, we've got you covered.</p>
      <div class="hero-buttons">
        <form action="services.php" method="GET" style="display:inline;">
          <button type="submit" class="hero-btn">Our Services</button>
        </form>
        <form action="appointment.php" method="GET" style="display:inline;">
          <button type="submit" class="hero-btn outline">Book Appointment</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Services Section (Dynamic from DB) -->
  <section class="services">
    <div class="section-title">
      <h2>Our Services</h2>
      <p>We offer a comprehensive range of automotive services to keep your vehicle running smoothly</p>
    </div>
    <div class="services-grid">
      <?php
      $result = $con->query("SELECT * FROM service ORDER BY service_name ASC");
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '
          <div class="service-card">
            <i class="fas fa-tools"></i>
            <h3>' . htmlspecialchars($row['service_name']) . '</h3>
            <p>' . htmlspecialchars($row['description']) . '</p>
            <div class="service-price">₹' . htmlspecialchars($row['price']) . '</div>
            <form action="appointment.php" method="GET">
              <input type="hidden" name="service_id" value="' . $row['service_id'] . '">
              <button type="submit" class="hero-btn small outline">Book Now</button> </form> </div> ';
        }
      } else {
        echo "<p style='text-align:center; color:#aaa;'>No services available at the moment.</p>";
      } ?> </div>
  </section> <!-- About Section -->
  <section class="about">
    <div class="about-content">
      <div class="about-text">
        <h2>About Red Clover</h2>
        <p>Founded in 2005, Red Clover Automobile Services has been a trusted name in automotive care for over 15 years...</p>
        <div class="about-stats">
          <div class="stat">
            <div class="number">15+</div>
            <div class="label">Years Experience</div>
          </div>
          <div class="stat">
            <div class="number">5,000+</div>
            <div class="label">Happy Customers</div>
          </div>
          <div class="stat">
            <div class="number">100+</div>
            <div class="label">Services Offered</div>
          </div>
        </div>
      </div>
      <div class="about-image"> <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Red Clover Auto Shop"> </div>
    </div>
  </section> <!-- Testimonials -->
  <section class="testimonials">
    <div class="section-title">
      <h2>What Our Customers Say</h2>
      <p>Don't just take our word for it - hear from our satisfied customers</p>
    </div>
    <div class="testimonials-grid"> <!-- Add testimonial cards here as in the second page --> </div>
  </section> <!-- CTA -->
  <section class="cta">
    <h2>Ready to Experience the Red Clover Difference?</h2>
    <p>Schedule your service appointment today and discover why thousands of customers trust us with their vehicles</p> <button class="hero-btn">Book Appointment Now</button>
  </section> <!-- Footer -->
  <footer class="footer">
    <div class="footer-content"> <!-- Footer content same as second page --> </div>
    <div class="footer-bottom">
      <p>&copy; <?php echo date('Y'); ?> Red Clover Automobile Services. All rights reserved.</p>
    </div>
  </footer>
 <script>
        // Toggle dropdown menu
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('show-dropdown');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            const logo = document.querySelector('.logo');
            
            if (!logo.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show-dropdown');
            }
        });
        
        // Keep dropdown open when clicking on it
        document.getElementById('dropdownMenu').addEventListener('click', function(event) {
            event.stopPropagation();
        });
        
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
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