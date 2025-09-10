<?php
// Start session and include necessary files
session_start();

// Check if auth functions exist, if not define dummy ones
if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    function getCurrentUserId() {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    }
    
    function getCurrentUserPoints() {
        return isset($_SESSION['points']) ? $_SESSION['points'] : 2350; // Default for demo
    }
}

// Handle reward redemption
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redeem_reward'])) {
    $rewardId = $_POST['reward_id'];
    $rewardPoints = $_POST['reward_points'];
    $currentPoints = getCurrentUserPoints();
    
    if ($currentPoints >= $rewardPoints) {
        // Successfully redeemed
        $_SESSION['points'] = $currentPoints - $rewardPoints;
        $redeemSuccess = "Reward redeemed successfully!";
    } else {
        $redeemError = "You don't have enough points to redeem this reward.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards Marketplace - SmilePoint</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .reward-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .reward-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .progress-bar {
            transition: width 1s ease-in-out;
        }
        .category-btn.active {
            background-color: #7c3aed;
            color: white;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen">
    <!-- Include Header -->
    <?php 
    // Simulate the header include
    $isLoggedIn = isLoggedIn();
    $userPoints = getCurrentUserPoints();
    ?>
   <?php require_once 'config/database.php'; ?>
   <?php require_once 'includes/auth.php'; ?>
    <?php include 'includes/header.php'; ?>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Notifications -->
        <?php if (isset($redeemSuccess)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline"><?php echo $redeemSuccess; ?></span>
            </div>
        <?php endif; ?>
        
        <?php if (isset($redeemError)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline"><?php echo $redeemError; ?></span>
            </div>
        <?php endif; ?>

        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Rewards Marketplace</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Redeem your hard-earned smile points for exclusive discounts, gift cards, and donations to charity</p>
        </div>

        <!-- User Points Balance -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 text-center">
            <h3 class="text-2xl font-semibold text-gray-800 mb-2">Your Smile Points Balance</h3>
            <div class="text-4xl font-bold text-purple-600 mb-4">
                <i class="fas fa-coins text-yellow-500 mr-2"></i> <?php echo $userPoints; ?>
            </div>
            <p class="text-gray-600">Earn more points by completing daily challenges and smiling more!</p>
        </div>

        <!-- Categories -->
        <div class="flex flex-wrap justify-center gap-4 mb-12">
            <button class="category-btn active px-6 py-2 bg-purple-600 text-white rounded-full font-medium" data-category="all">All Rewards</button>
            <button class="category-btn px-6 py-2 bg-white text-purple-600 border border-purple-600 rounded-full font-medium" data-category="gift_card">Gift Cards</button>
            <button class="category-btn px-6 py-2 bg-white text-purple-600 border border-purple-600 rounded-full font-medium" data-category="discount">Discounts</button>
            <button class="category-btn px-6 py-2 bg-white text-purple-600 border border-purple-600 rounded-full font-medium" data-category="donation">Donations</button>
            <button class="category-btn px-6 py-2 bg-white text-purple-600 border border-purple-600 rounded-full font-medium" data-category="experience">Experiences</button>
        </div>

        <!-- Rewards Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <!-- Reward 1 -->
            <div class="reward-card bg-white rounded-xl shadow-md overflow-hidden" data-category="gift_card">
                <div class="h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                    <i class="fas fa-gift text-white text-6xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">$10 Amazon Gift Card</h3>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium"><i class="fas fa-coins mr-1"></i> 1,000</span>
                    </div>
                    <p class="text-gray-600 mb-6">Get a $10 Amazon gift card delivered instantly to your email</p>
                    <form method="POST" action="">
                        <input type="hidden" name="reward_id" value="1">
                        <input type="hidden" name="reward_points" value="1000">
                        <button type="submit" name="redeem_reward" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-xl transition duration-300">
                            Redeem Now
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reward 2 -->
            <div class="reward-card bg-white rounded-xl shadow-md overflow-hidden" data-category="physical">
                <div class="h-48 bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center">
                    <i class="fas fa-tshirt text-white text-6xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Premium T-Shirt</h3>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium"><i class="fas fa-coins mr-1"></i> 1,500</span>
                    </div>
                    <p class="text-gray-600 mb-6">High-quality cotton t-shirt with exclusive Smile Points design</p>
                    <form method="POST" action="">
                        <input type="hidden" name="reward_id" value="2">
                        <input type="hidden" name="reward_points" value="1500">
                        <button type="submit" name="redeem_reward" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-xl transition duration-300">
                            Redeem Now
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reward 3 -->
            <div class="reward-card bg-white rounded-xl shadow-md overflow-hidden" data-category="donation">
                <div class="h-48 bg-gradient-to-r from-red-400 to-pink-500 flex items-center justify-center">
                    <i class="fas fa-heart text-white text-6xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Donate to Charity</h3>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium"><i class="fas fa-coins mr-1"></i> 2,000</span>
                    </div>
                    <p class="text-gray-600 mb-6">Donate to Children's Education Foundation in your name</p>
                    <form method="POST" action="">
                        <input type="hidden" name="reward_id" value="3">
                        <input type="hidden" name="reward_points" value="2000">
                        <button type="submit" name="redeem_reward" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-xl transition duration-300">
                            Donate Now
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reward 4 -->
            <div class="reward-card bg-white rounded-xl shadow-md overflow-hidden" data-category="discount">
                <div class="h-48 bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center justify-center">
                    <i class="fas fa-mug-hot text-white text-6xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Coffee Shop Discount</h3>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium"><i class="fas fa-coins mr-1"></i> 500</span>
                    </div>
                    <p class="text-gray-600 mb-6">Get 20% off your next purchase at participating coffee shops</p>
                    <form method="POST" action="">
                        <input type="hidden" name="reward_id" value="4">
                        <input type="hidden" name="reward_points" value="500">
                        <button type="submit" name="redeem_reward" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-xl transition duration-300">
                            Get Discount
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reward 5 -->
            <div class="reward-card bg-white rounded-xl shadow-md overflow-hidden" data-category="experience">
                <div class="h-48 bg-gradient-to-r from-purple-400 to-indigo-500 flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-white text-6xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Movie Tickets</h3>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium"><i class="fas fa-coins mr-1"></i> 1,800</span>
                    </div>
                    <p class="text-gray-600 mb-6">Two tickets to any movie at your local cinema</p>
                    <form method="POST" action="">
                        <input type="hidden" name="reward_id" value="5">
                        <input type="hidden" name="reward_points" value="1800">
                        <button type="submit" name="redeem_reward" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-xl transition duration-300">
                            Get Tickets
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reward 6 -->
            <div class="reward-card bg-white rounded-xl shadow-md overflow-hidden" data-category="experience">
                <div class="h-48 bg-gradient-to-r from-teal-400 to-green-500 flex items-center justify-center">
                    <i class="fas fa-book text-white text-6xl"></i>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Online Course</h3>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium"><i class="fas fa-coins mr-1"></i> 3,000</span>
                    </div>
                    <p class="text-gray-600 mb-6">Access to premium online course of your choice</p>
                    <form method="POST" action="">
                        <input type="hidden" name="reward_id" value="6">
                        <input type="hidden" name="reward_points" value="3000">
                        <button type="submit" name="redeem_reward" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-xl transition duration-300">
                            Enroll Now
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Progress Section -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-12">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Your Progress</h3>
            <div class="mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-700">Next reward: $5 Starbucks Card (800 points)</span>
                    <span class="text-gray-700"><?php echo min($userPoints, 800); ?>/800</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-green-500 h-4 rounded-full progress-bar" style="width: <?php echo (min($userPoints, 800) / 800) * 100; ?>%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-700">Annual goal: 5,000 points</span>
                    <span class="text-gray-700"><?php echo $userPoints; ?>/5,000</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-purple-600 h-4 rounded-full progress-bar" style="width: <?php echo ($userPoints / 5000) * 100; ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Recent Activity</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <i class="fas fa-plus text-blue-600"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">Earned points</h4>
                            <p class="text-sm text-gray-600">Completed daily challenge</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-green-600">+50 points</p>
                        <p class="text-sm text-gray-600">2 hours ago</p>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-gray-100 p-3 rounded-full mr-4">
                            <i class="fas fa-exchange-alt text-gray-600"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">Redeemed reward</h4>
                            <p class="text-sm text-gray-600">$5 Amazon Gift Card</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-red-600">-500 points</p>
                        <p class="text-sm text-gray-600">1 day ago</p>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <i class="fas fa-plus text-blue-600"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">Earned points</h4>
                            <p class="text-sm text-gray-600">Weekly goal achieved</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-green-600">+200 points</p>
                        <p class="text-sm text-gray-600">3 days ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <?php include 'includes/footer.php'; ?>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Category filtering
        document.addEventListener('DOMContentLoaded', function() {
            const categoryButtons = document.querySelectorAll('.category-btn');
            const rewardCards = document.querySelectorAll('.reward-card');
            
            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');
                    
                    // Update active button
                    categoryButtons.forEach(btn => btn.classList.remove('active', 'bg-purple-600', 'text-white'));
                    categoryButtons.forEach(btn => btn.classList.add('bg-white', 'text-purple-600'));
                    this.classList.add('active', 'bg-purple-600', 'text-white');
                    this.classList.remove('bg-white', 'text-purple-600');
                    
                    // Filter rewards
                    rewardCards.forEach(card => {
                        if (category === 'all' || card.getAttribute('data-category') === category) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
            
            // Animate progress bars
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        });
    </script>
</body>
</html>