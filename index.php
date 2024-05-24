<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sound and Light booking System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* Reset default margin and padding */
        body, ul {
            margin: 0;
            padding: 0;
            font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif; 
        }

        /* CSS for navigation bar */
        .navbar {
            background-color: rgba(51, 51, 51, 0.7); /* Set background color with opacity */
            color: #fff;
            padding: 20px 4px;
            position: fixed; /* Make the navbar fixed */
            width: 100%; /* Occupy full width of the viewport */
            top: 0; /* Stick to the top of the viewport */
            z-index: 1000; /* Ensure the navbar is above other content */
        }
        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1300px;
            margin: 0 auto;
        }
        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 5px;
            display: flex;
        }
        .navbar ul li {
            margin-right: 5px;
        }
        .navbar ul li:last-child {
            margin-right: 0;
        }
        .navbar ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .navbar ul li a:hover {
            background-color: #555;
        }
        .navbar ul li a.active {
            background-color: #f9f9ff;
            color:black;
        }

        /* Logo styles */
        .logo {
            font-size: 20px;
            font-weight: bold;
            font-family: 'Lucida Console', monospace; /* Apply Lucida Console font to the logo */
        }

        /* Button styles */
        .button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-family: 'Lucida Console', monospace; /* Apply Lucida Console font to the button */
        }
        .button:hover {
            background-color: #0056b3;
        }

        /* Content styles */
        .content {
            min-height: calc(86vh - 50px); /* Ensure a minimum height to fill the remaining viewport height after considering the navbar */
            overflow-y: auto; /* Enable vertical scrolling if content exceeds viewport height */
            padding: 70px 20px;
        }

        /* Home content styles */
        #home {
            background-size: cover;
            background-position: center;
            text-align: center;
            position: relative;
        }

        .home-content {
            position: absolute;
            top: 45%;
            left: 0; /* Position the content on the left side */
            transform: translateY(-50%);
            color: #fff;
            width: 50%; /* Set the width of the content */
            padding: 0 20px; /* Add some padding */
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
        }

        .home-content h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .home-content p {
            font-size: 15px;
            margin-bottom: 60px;
        }

        .logo-images {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
        }

        .logo-images img {
            width: 100px; /* Adjust the size as needed */
            margin-bottom: 10px;
        }

        /* About content styles */
        #about-content {
            width: 50%;
            float: right; /* Position the about content on the right side */
            text-align: center;
            color: #000; /* Change text color to black */
            padding: 50px 50px;
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
        }

        #about-images {
            width: 50%;
            float: left; /* Position the images on the left side */
            text-align: center;
            padding: 100px 50px;
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
        }

        #about-images img {
            max-width: 100%;
            height: auto;
            display: block;
            margin-bottom: 0;
        }

        /* Responsive adjustments */
        @media only screen and (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
                text-align: center;
            }
            .navbar ul {
                margin-top: 10px;
            }
            .navbar ul li {
                margin: 5px 0;
            }
            .content {
                padding-top: 110px; /* Adjust padding for smaller screens */
                min-height: calc(90vh - 110px); /* Adjust minimum height accordingly */
            }
            #home-content,
            #about-content,
            #about-images {
                width: 100%;
                float: none;
                text-align: center;
            }
        }
        #services {
    text-align: center;
}

.service-columns {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 30px;
}

.service-column {
    width: calc(25% - 20px);
    margin: 10px;
    border: 1px solid #ddd;
    padding: 20px;
    box-sizing: border-box;
}

.service-column img {
    width: 100%;
    height: 300px; /* Set a fixed height for all images */
    object-fit: cover; /* Ensure the images cover the entire space */
    margin-bottom: 15px;
}

.service-column h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

.service-column .button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.service-column .button:hover {
    background-color: #0056b3;
}
.contact-info {
    display: flex;
    justify-content: space-between;
    align-items: center; /* Center vertically */
    padding:20px 20px;
    margin-left: 350px;
    margin-right: 150px;
}

.contact-details,
.contact-links {
    margin-top: 5px;
    width: 45%;
    text-align: left; /* Change text alignment to left */
}

.contact-links p {
    margin-top: 5px;
    text-align: left; /* Change text alignment to left */
}
@media only screen and (max-width: 768px) {
    .service-columns {
        flex-direction: column; /* Change to a single column layout */
        align-items: center; /* Center items horizontally */
    }

    .service-column {
        width: 100%; /* Occupy full width */
        margin: 10px 0; /* Adjust margin */
    }
}
@media only screen and (max-width: 768px) {
    .contact-info {
        flex-direction: column; /* Change to a single column layout */
        align-items: center; /* Center items horizontally */
        margin-left: 0; /* Remove left margin */
        margin-right: 0; /* Remove right margin */
        padding: 20px; /* Adjust padding */
    }

    .contact-details,
    .contact-links {
        width: 100%; /* Occupy full width */
        text-align: center; /* Center text horizontally */
    }

    .contact-links p {
        text-align: center; /* Center text horizontally */
    }
    .contact-details h3,
    .contact-links h3 {
        font-size: 16px; /* Adjust font size for smaller screens */
    }

    .contact-details p,
    .contact-links p {
        font-size: 12px; /* Adjust font size for smaller screens */
    }
}


    </style>
</head>
<body>

<div class="navbar">
    <div class="navbar-content">
        <div class="logo">SOUND & LIGHT BOOKING SYSTEM</div>
        <ul>
            <li><a href="#home" class="nav-link">Home</a></li>
            <li><a href="#about" class="nav-link">About</a></li>
            <li><a href="#services" class="nav-link">Services</a></li>
            <li><a href="#contact-us" class="nav-link">Contact Us</a></li>
            <?php
            if (isset($_SESSION['email'])) {
                // If logged in, redirect to user or admin page
                $userEmail = $_SESSION['email'];
                $xml = simplexml_load_file('data.xml');
                foreach ($xml->user as $user) {
                    if ($user->email == $userEmail) {
                        if ($user->role == "admin") {
                            echo '<li><a href="admin_home.php" class="button">Login</a></li>';
                        } else {
                            echo '<li><a href="user_home.php" class="button">Login</a></li>';
                        }
                        break;
                    }
                }
            } else {
                // If not logged in, display login button
                echo '<li><a href="login.php" class="button">Login</a></li>';
            }
            ?>
        </ul>
    </div>
</div>

<div class="container">
    <div id="home" class="content" style="background-image: url('images/design.png');">
        <div class="home-content">
            <h1>Welcome to SOUND & LIGHT BOOKING SYSTEM</h1>
            <p>Discover the best sound and light services for your events.</p>
            <?php
    if (isset($_SESSION['email'])) {
    // If logged in, redirect to user or admin page
    $userEmail = $_SESSION['email'];
    $xml = simplexml_load_file('data.xml');
    foreach ($xml->user as $user) {
        if ($user->email == $userEmail) {
            if ($user->role == "admin") {
                echo '<li style="list-style-type: none;"><a href="admin_home.php" class="button">Book Now</a></li>';
            } else {
                echo '<li style="list-style-type: none;"><a href="user_home.php" class="button">Book Now</a></li>';
            }
            break;
        }
    }
} else {
    // If not logged in, display login button
    echo '<li style="list-style-type: none;"><a href="login.php" class="button">Book Now</a></li>';
}
?>
        </div>
    </div>

    <div id="about" class="content">
        <div id="about-content">
            <h2>About Us</h2>
            <p>We are a leading provider of sound and light services for events. Our team is dedicated to delivering exceptional experiences and making every event memorable. With years of expertise in the industry, we pride ourselves on our ability to create immersive atmospheres that captivate audiences and elevate the overall event experience. </p>
            <p>Whether it's a corporate conference, a wedding celebration, or a music festival, we tailor our services to meet the unique needs and vision of each client. From state-of-the-art sound systems to dazzling lighting designs, we ensure that every aspect of the event is flawlessly executed, leaving a lasting impression on guests. </p>
            <p>Our commitment to excellence extends beyond just the technical aspects of our services; we also prioritize customer satisfaction and strive to exceed expectations with our professionalism and attention to detail. By choosing us as your sound and light partner, you can trust that your event will be in capable hands, allowing you to relax and enjoy the moment while we work tirelessly behind the scenes to bring your vision to life.</p>
        </div>
        <div id="about-images">
            <img src="images/se.png" alt="About Image 1">      
        </div>
    </div>

    <div id="services" class="content">
    <h2 style="text-align: center;">Services</h2>
    <p style="text-align: center;">From intimate gatherings to grand celebrations, our services cater to a diverse range of events, ensuring that each occasion is meticulously curated to reflect your unique vision and style.</p><br>

    <div class="service-columns">
        <div class="service-column">
            <img src="images/wedding.jpg" alt="Service 1">
            <h3>Wedding Party</h3><br>
            <?php
    if (isset($_SESSION['email'])) {
    // If logged in, redirect to user or admin page
    $userEmail = $_SESSION['email'];
    $xml = simplexml_load_file('data.xml');
    foreach ($xml->user as $user) {
        if ($user->email == $userEmail) {
            if ($user->role == "admin") {
                echo '<li style="list-style-type: none;"><a href="admin_home.php" class="button">Book Now</a></li>';
            } else {
                echo '<li style="list-style-type: none;"><a href="user_home.php" class="button">Book Now</a></li>';
            }
            break;
        }
    }
} else {
    // If not logged in, display login button
    echo '<li style="list-style-type: none;"><a href="login.php" class="button">Book Now</a></li>';
}
?>
        </div>
        <div class="service-column">
            <img src="images/birthday.jpg" alt="Service 2">
            <h3>Birthday Party</h3><br>
            <?php
    if (isset($_SESSION['email'])) {
    // If logged in, redirect to user or admin page
    $userEmail = $_SESSION['email'];
    $xml = simplexml_load_file('data.xml');
    foreach ($xml->user as $user) {
        if ($user->email == $userEmail) {
            if ($user->role == "admin") {
                echo '<li style="list-style-type: none;"><a href="admin_home.php" class="button">Book Now</a></li>';
            } else {
                echo '<li style="list-style-type: none;"><a href="user_home.php" class="button">Book Now</a></li>';
            }
            break;
        }
    }
} else {
    // If not logged in, display login button
    echo '<li style="list-style-type: none;"><a href="login.php" class="button">Book Now</a></li>';
}
?>
        </div>
        <div class="service-column">
            <img src="images/music.avif" alt="Service 3">
            <h3>Music Fiestival</h3><br>
            <?php
    if (isset($_SESSION['email'])) {
    // If logged in, redirect to user or admin page
    $userEmail = $_SESSION['email'];
    $xml = simplexml_load_file('data.xml');
    foreach ($xml->user as $user) {
        if ($user->email == $userEmail) {
            if ($user->role == "admin") {
                echo '<li style="list-style-type: none;"><a href="admin_home.php" class="button">Book Now</a></li>';
            } else {
                echo '<li style="list-style-type: none;"><a href="user_home.php" class="button">Book Now</a></li>';
            }
            break;
        }
    }
} else {
    // If not logged in, display login button
    echo '<li style="list-style-type: none;"><a href="login.php" class="button">Book Now</a></li>';
}
?>
        </div>
        <div class="service-column">
            <img src="images/fiesta.jpg" alt="Service 4">
            <h3>Fiesta</h3><br>
            <?php
    if (isset($_SESSION['email'])) {
    // If logged in, redirect to user or admin page
    $userEmail = $_SESSION['email'];
    $xml = simplexml_load_file('data.xml');
    foreach ($xml->user as $user) {
        if ($user->email == $userEmail) {
            if ($user->role == "admin") {
                echo '<li style="list-style-type: none;"><a href="admin_home.php" class="button">Book Now</a></li>';
            } else {
                echo '<li style="list-style-type: none;"><a href="user_home.php" class="button">Book Now</a></li>';
            }
            break;
        }
    }
} else {
    // If not logged in, display login button
    echo '<li style="list-style-type: none;"><a href="login.php" class="button">Book Now</a></li>';
}
?>
        </div>
    </div>
</div>
<div id="contact-us" class="content" style="background-image: url('images/f.png');">
    <h2 style="text-align: center;">Contact Us</h2>
    <div class="contact-info">
        <div class="contact-details">
            <h3><i class="fas fa-map-marker-alt"></i> Address</h3>
            <p>21 Magsaysay St. Isok 1, Boact Marinduque</p><br>
            <h3><i class="fas fa-phone"></i> Phone</h3>
            <p>+63 (917-843-2749)</p>
        </div>
        <div class="contact-links">
            <h3><i class="far fa-envelope"></i> Email</h3>
            <p>rrc_pro.light_sound@yahoo.com</p><br>
            <h3><i class="fab fa-facebook"></i> Facebook</h3>
            <p><a href="https://www.facebook.com/rrcpro.marinduque" target="_blank">@RRC.MARINDUQUE</a></p>
        </div>
    </div>
</div>

</div>

<script>
    // Add active class to the current navbar link based on the hash in the URL
    document.addEventListener("DOMContentLoaded", function() {
        var navbarLinks = document.querySelectorAll(".navbar ul li a");
        var sections = document.querySelectorAll(".content");
        var navbarHeight = document.querySelector(".navbar").offsetHeight;

        // Function to set active link based on hash in URL
        function setActiveLink() {
            var currentHash = window.location.hash;
            if (!currentHash) {
                // If no hash is present, manually set the Home link as active
                navbarLinks.forEach(function(link) {
                    if (link.getAttribute("href") === "#home") {
                        link.classList.add("active");
                    }
                });
            } else {
                navbarLinks.forEach(function(link) {
                    if (link.getAttribute("href") === currentHash) {
                        link.classList.add("active");
                    }
                });
            }
        }

        // Set initial active state based on hash in URL
        setActiveLink();

        // Update active link on scroll
        window.addEventListener("scroll", function() {
            var current = "";

            sections.forEach(function(section) {
                var sectionTop = section.offsetTop - navbarHeight;
                var sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop && pageYOffset < sectionTop + sectionHeight) {
                    current = section.getAttribute("id");
                }
            });

            navbarLinks.forEach(function(link) {
                link.classList.remove("active");
                if (link.getAttribute("href").substring(1) === current) {
                    link.classList.add("active");
                }
            });
        });
    });
</script>

</body>
</html>
