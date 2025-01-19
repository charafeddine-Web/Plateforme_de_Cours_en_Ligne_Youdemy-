<?php
require_once '../autoload.php';
use Classes\Cours;

$courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($courseId <= 0) {
    echo "Invalid course ID.";
    exit;
}

$course = Cours::getCoursById($courseId);

if (!$course) {
    echo "Course not found.";
    exit;
}
$instructorName = htmlspecialchars($course['enseignant_nom']);
$categoryName = htmlspecialchars($course['categorie_nom']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/zilom.css" />
    <link rel="stylesheet" href="../assets/css/zilom-responsive.css" />
    <title>Course Details || Udemey</title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicons/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicons/favicon-16x16.png" />
    <link rel="manifest" href="../assets/images/favicons/site.webmanifest" />
    <meta name="description" content="Crsine HTML Template For Car Services" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/vendors/animate/animate.min.css"/>
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
        .course-details-container {
            padding: 2rem;
            background-color: #f9f9f9;
        }

        .course-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .course-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            margin-bottom: 1rem;
        }

.course-details__review-box:hover, .course-details__comment-single:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}


    </style>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Navigation Bar -->
    <nav class="bg-indigo-600 shadow-lg fixed w-full top-0 left-0 z-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="#"><img src="../assets/images/resources/logo-1.png" alt="" /></a>

                <button id="hamburger" class="lg:hidden text-white">
                    <i class="fas fa-bars"></i>
                </button>

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
    
    <!-- Sidebar for Mobile -->
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
    <div class="course-details-container mt-20">
    <div class="course-header bg-gradient-to-r from-indigo-600 to-indigo-500 text-white p-8 rounded-lg shadow-lg">
    <h2 class="text-4xl font-semibold"><?= htmlspecialchars($course['titre']) ?></h2>
    <p class="text-xl mt-4"><?= htmlspecialchars($course['description']) ?></p>
</div>


        <div class="course-content grid grid-cols-1 md:grid-cols-3 gap-8 mt-8 px-4 md:px-8">
    <!-- Course Image or Video -->
    <div class="course-image-container md:col-span-1 ">
        <?php if ($course['type'] == 'video'): ?>
            <div class="relative h-64 rounded-lg overflow-hidden shadow-lg">
                <video class="w-full h-full object-cover" controls autoplay>
                    <source src="../enseignant/uploads/videos/<?= htmlspecialchars($course['contenu']) ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php else: ?>
            <div class="relative h-64 bg-gray-100 flex items-center justify-center p-4 rounded-lg shadow-lg my-20">
                <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg text-center">
                    <h4 class="text-xl font-semibold text-indigo-600 mb-4">Course Content</h4>
                    <p class="text-lg text-gray-700 h-80 overflow-y-auto"><?= htmlspecialchars($course['contenu']); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="course-details md:col-span-2 space-y-6">
        <h3 class="text-3xl font-semibold text-indigo-600 hover:text-indigo-800 transition duration-300 ease-in-out"><?= htmlspecialchars($course['titre']) ?></h3>
        <p class="text-lg text-gray-600 mt-2"><?= htmlspecialchars($course['description']) ?></p>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center space-x-3 p-4 bg-white shadow-md rounded-lg transition duration-300 ease-in-out hover:shadow-lg hover:bg-indigo-50">
                <i class="fas fa-user-circle text-indigo-600 text-2xl"></i>
                <p class="text-md font-medium text-gray-700"><?= $instructorName ?></p>
            </div>
            
            <div class="flex items-center space-x-3 p-4 bg-white shadow-md rounded-lg transition duration-300 ease-in-out hover:shadow-lg hover:bg-indigo-50">
                <i class="fas fa-folder-open text-indigo-600 text-2xl"></i>
                <p class="text-md font-medium text-gray-700"><?= $categoryName ?></p>
            </div>
        </div>


    </div>
</div>


        <div class="course-details__reviews">
    <h3 class="course-details__reviews-title">Reviews</h3>
    <div class="course-details__progress-review">
        <div class="row">
            <div class="col-xl-7 col-lg-7 col-md-7">
                <div class="course-details__progress">
                    <div class="course-details__progress-item">
                        <p class="course-details__progress-text">Excellent</p>
                        <div class="course-details__progress-bar">
                            <span style="width: 90%;"></span>
                        </div>
                        <p class="course-details__progress-count">2</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5">
                <div class="course-details__review-box">
                    <h2 class="course-details__review-count">4.6</h2>
                    <div class="course-details__review-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="course-details__review-text">30 reviews</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Comments -->
    <div class="course-details__comment">
        <!-- Individual comment -->
        <div class="course-details__comment-single">
            <div class="course-details__comment-img">
                <img src="../assets/images/resources/course-details-comment-img1.png" alt=""/>
            </div>
            <div class="course-details__comment-text">
                <h3 class="course-details__comment-text-name">David Marks</h3>
                <p>3 hours ago</p>
                <div class="course-details__comment-review-stars">
                    <i class="fas fa-star"></i>
                    <!-- Add more stars -->
                </div>
                <p class="course-details__comment-text-bottom">Cursus massa at urnaaculis estie...</p>
            </div>
        </div>
    </div>
    <!-- Add Review Form -->
    <div class="course-details__add-review bg-white p-6 rounded-lg shadow-md mt-8">
    <h2 class="text-2xl font-semibold text-indigo-600 mb-4">Add a Review</h2>
    <p class="text-lg text-gray-700 mb-4">
        Rate this Course?
        <a href="#" class="fas fa-star text-yellow-500 active inline-block ml-2"></a>
        <a href="#" class="fas fa-star text-yellow-500 active inline-block ml-2"></a>
        <a href="#" class="fas fa-star text-yellow-500 active inline-block ml-2"></a>
        <a href="#" class="fas fa-star text-yellow-500 active inline-block ml-2"></a>
        <a href="#" class="fas fa-star text-yellow-500 active inline-block ml-2"></a>
    </p>

    <div class="course-details__add-review-form">
        <form action="../assets/inc/sendemail.php" method="post" class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <input type="text" name="name" placeholder="Your name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div>
                    <input type="email" name="email" placeholder="Email address" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                </div>
            </div>

            <div>
                <textarea name="message" placeholder="Write your message" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" rows="4" required></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="w-full py-3 px-6 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
                    Submit Review
                </button>
            </div>
        </form>
    </div>
</div>

</div>

    </div>

    <!-- Footer -->
    <footer class="bg-indigo-600 mt-10">
        <div class="container mx-auto px-4 py-4 text-center text-white">
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
