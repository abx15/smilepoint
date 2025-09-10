<?php
// Check if auth functions exist, if not define dummy ones
if (!function_exists('isLoggedIn')) {
    function isLoggedIn()
    {
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmilePoint - Gamified Emotion-Based Engagement Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen">
    <header class="bg-white shadow-sm" x-data="{ open: false }">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="index.php" class="text-xl font-bold text-purple-600 flex items-center">
                    <i class="fas fa-smile-beam mr-2"></i> SmilePoint
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-4">
                    <?php if (isLoggedIn()): ?>
                        <a href="profile.php" class="text-gray-700 hover:text-purple-600 text-sm font-medium">
                            <i class="fas fa-user mr-1"></i> Profile
                        </a>
                        <a href="leaderboard.php" class="text-gray-700 hover:text-purple-600 text-sm font-medium">
                            <i class="fas fa-trophy mr-1"></i> Leaderboard
                        </a>
                        <a href="smile-capture.php" class="text-gray-700 hover:text-purple-600 text-sm font-medium">
                            <i class="fas fa-camera mr-1"></i> Smile Challenge
                        </a>
                        <a href="logout.php" class="text-gray-700 hover:text-purple-600 text-sm font-medium">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </a>
                    <?php else: ?>
                        <a href="register.php" class="text-gray-700 hover:text-purple-600 text-sm font-medium">
                            <i class="fas fa-user-plus mr-1"></i> Register
                        </a>
                        <a href="login.php" class="text-gray-700 hover:text-purple-600 text-sm font-medium">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                        <a href="demo.php"
                            class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700 transition duration-300">
                            <i class="fas fa-play mr-1"></i> Try Demo
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-gray-700 hover:text-purple-600 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Dropdown Menu -->
            <div x-show="open" class="md:hidden mt-2 space-y-2 bg-white p-4 rounded-lg shadow-lg" x-transition>
                <?php if (isLoggedIn()): ?>
                    <a href="profile.php" class="block text-gray-700 hover:text-purple-600 text-sm font-medium">
                        <i class="fas fa-user mr-1"></i> Profile
                    </a>
                    <a href="leaderboard.php" class="block text-gray-700 hover:text-purple-600 text-sm font-medium">
                        <i class="fas fa-trophy mr-1"></i> Leaderboard
                    </a>
                    <a href="smile-capture.php" class="block text-gray-700 hover:text-purple-600 text-sm font-medium">
                        <i class="fas fa-camera mr-1"></i> Smile Challenge
                    </a>
                    <a href="logout.php" class="block text-gray-700 hover:text-purple-600 text-sm font-medium">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </a>
                <?php else: ?>
                    <a href="register.php" class="block text-gray-700 hover:text-purple-600 text-sm font-medium">
                        <i class="fas fa-user-plus mr-1"></i> Register
                    </a>
                    <a href="login.php" class="block text-gray-700 hover:text-purple-600 text-sm font-medium">
                        <i class="fas fa-sign-in-alt mr-1"></i> Login
                    </a>
                    <a href="demo.php" class="block bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700 transition duration-300">
                        <i class="fas fa-play mr-1"></i> Try Demo
                    </a>
                <?php endif; ?>
            </div>
        </nav>
    </header>