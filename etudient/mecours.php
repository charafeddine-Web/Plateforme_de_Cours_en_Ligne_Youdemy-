<?php
require_once '../autoload.php';
use Classes\Inscription;
session_start();


if (!isset($_SESSION['id_user']) || (isset($_SESSION['id_role']) && $_SESSION['id_role'] !== 2)) {
  header("Location: ../index.php");
  exit;
}
if (isset($_SESSION['id_user'])){
    $etudient=$_SESSION['id_user'];
};
$insecription = new Inscription();
$mecours=$insecription->getAllInscriptionsEtudient($etudient);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicons/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicons/favicon-16x16.png" />
    <link rel="manifest" href="../assets/images/favicons/site.webmanifest" />
    <meta name="description" content="Crsine HTML Template For Car Services" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/vendors/animate/animate.min.css" />
    <link rel="stylesheet" href="../assets/vendors/animate/custom-animate.css" />
    <link rel="stylesheet" href="../assets/vendors/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="../assets/vendors/jarallax/jarallax.css" />
    <link rel="stylesheet" href="../assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css" />
    <link rel="stylesheet" href="../assets/vendors/nouislider/nouislider.min.css" />
    <link rel="stylesheet" href="../assets/vendors/nouislider/nouislider.pips.css" />
    <link rel="stylesheet" href="../assets/vendors/odometer/odometer.min.css" />
    <link rel="stylesheet" href="../assets/vendors/swiper/swiper.min.css" />
    <link rel="stylesheet" href="../assets/vendors/icomoon-icons/style.css">
    <link rel="stylesheet" href="../assets/vendors/tiny-slider/tiny-slider.min.css" />
    <link rel="stylesheet" href="../assets/vendors/reey-font/stylesheet.css" />
    <link rel="stylesheet" href="../assets/vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="../assets/vendors/owl-carousel/owl.theme.default.min.css" />
    <link rel="stylesheet" href="../assets/vendors/twentytwenty/twentytwenty.css" />

    <!-- template styles -->
    <link rel="stylesheet" href="../assets/css/zilom.css" />
    <link rel="stylesheet" href="../assets/css/zilom-responsive.css" />
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 10px 15px;
            margin: 0 5px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #333;
        }

        .pagination a.active {
            background-color: indigo;
            color: white;
        }

        .pagination a:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Navigation Bar -->
    <nav class="bg-indigo-600 shadow-lg fixed w-full top-0 left-0 z-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="#"><img src="../assets/images/resources/logo-1.png" alt="" /></a>

                <!-- Hamburger Button for Mobile -->
                <button id="hamburger" class="lg:hidden text-white">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Menu Items (Hidden on Mobile) -->
                <div class="hidden lg:flex space-x-6">
                    <a href="indexEtu.php" class="text-white flex items-center hover:text-gray-200">
                        <i class="fas fa-book mr-2"></i>All Courses
                    </a>
                    <a href="mecours.php" class="text-white flex items-center hover:text-gray-200">
                        <i class="fas fa-folder-open mr-2"></i>My Courses
                    </a>
                    <a href="#" class="text-white flex items-center hover:text-gray-200">
                        <i class="fas fa-user-circle mr-2"></i>Profile
                    </a>
                </div>

                <div class="relative">
                    <input type="text" placeholder="Search courses..."
                        class="py-2 md:px-4 rounded-full border border-gray-300 focus:outline-none focus:ring focus:ring-indigo-300">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
            </div>
        </div>
    </nav>
<div id="sidebar" class="lg:hidden fixed inset-0 bg-gray-800 bg-opacity-75 z-20 hidden">
        <div class="flex justify-end p-4">
            <button id="close-sidebar" class="text-white text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="flex flex-col items-center">
            <a href="indexEtu.php" class="text-white py-2">All Courses</a>
            <a href="mecours.php" class="text-white py-2">My Courses</a>
            <a href="#" class="text-white py-2">Profile</a>
        </div>
    </div>

    <section class="section-title text-center mt-40 w-full">
                <h2 class="section-title__title">Explore Your Courses</h2>
        
    </section>
    

    </div>

    <!-- Footer -->
    <footer class=" mt-10">
        <div class="container mx-auto px-4 py-4 text-center text-black">
            &copy; 2025 Zilom . All rights reserved, by Tbibzat Charaf Eddine.
        </div>
    </footer>

   <script>
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const closeSidebar = document.getElementById('close-sidebar');

        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('hidden');
        });
    </script>
</body>

</html>
