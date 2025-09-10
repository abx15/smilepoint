<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$user = getUserData($pdo, $_SESSION['user_id']);

// Get top 100 users with pagination
$perPage = 20;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

$leaderboard = $pdo->query("SELECT id, name, city, points, profile_image FROM users ORDER BY points DESC LIMIT $perPage OFFSET $offset")->fetchAll(PDO::FETCH_ASSOC);

// Get total user count for pagination
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

// Find current user's position
$userRank = $pdo->prepare("SELECT COUNT(*) as rank FROM users WHERE points > ?");
$userRank->execute([$user['points']]);
$userRank = $userRank->fetch(PDO::FETCH_ASSOC)['rank'] + 1;

// Get real top cities data
$topCities = $pdo->query("SELECT city, COUNT(*) as user_count, SUM(points) as total_points FROM users WHERE city IS NOT NULL GROUP BY city ORDER BY total_points DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php';
?>

<main class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-10" data-aos="fade-down">
            <h1 class="text-4xl font-bold text-purple-600 mb-3">Global Happiness Leaderboard</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Discover the most joyful members of our community
            </p>
        </div>

        <!-- User Rank Card -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-xl text-white p-6 mb-8" data-aos="fade-up">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0 text-center md:text-left">
                    <h2 class="text-2xl font-bold mb-1">Your Current Rank</h2>
                    <p class="opacity-90">Out of <?= number_format($totalUsers) ?> users worldwide</p>
                </div>
                <div class="flex items-center">
                    <div class="text-center px-6">
                        <div class="text-5xl font-bold">#<?= $userRank ?></div>
                        <div class="text-sm opacity-80">Rank</div>
                    </div>
                    <div class="h-16 w-px bg-white/30 mx-4"></div>
                    <div class="text-center px-6">
                        <div class="text-5xl font-bold"><?= number_format($user['points']) ?></div>
                        <div class="text-sm opacity-80">Points</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaderboard Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-10" data-aos="fade-up" data-aos-delay="100">
            <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center">
                <div class="mb-4 sm:mb-0">
                    <h2 class="text-xl font-semibold text-gray-800">Top Contributors</h2>
                    <p class="text-gray-600 text-sm">Updated every 15 minutes</p>
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-gray-500 mr-3">Filter:</span>
                    <select class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:ring-purple-500 focus:border-purple-500">
                        <option>Global</option>
                        <option>My Country</option>
                        <option>My City</option>
                        <option>Friends</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Rank</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Location</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($leaderboard as $index => $row): 
                            $globalRank = $offset + $index + 1;
                        ?>
                            <tr class="<?= $row['id'] === $user['id'] ? 'bg-purple-50 font-medium' : '' ?> hover:bg-gray-50 transition-colors">
                                <!-- Rank Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">#<?= $globalRank ?></span>
                                        <?php if ($globalRank <= 3): ?>
                                            <span class="ml-2 text-lg">
                                                <?= $globalRank === 1 ? '🥇' : ($globalRank === 2 ? '🥈' : '🥉') ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                
                                <!-- User Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 relative">
                                            <?php if (!empty($row['profile_image'])): ?>
                                                <img class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm" src="<?= htmlspecialchars($row['profile_image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                                            <?php else: ?>
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-100 to-blue-100 flex items-center justify-center text-purple-600 font-semibold border-2 border-white shadow-sm">
                                                    <?= strtoupper(substr($row['name'], 0, 1)) ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($globalRank <= 3): ?>
                                                <div class="absolute -bottom-1 -right-1 bg-yellow-400 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold text-white">
                                                    <?= $globalRank ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($row['name']) ?></div>
                                            <div class="text-xs text-gray-500 sm:hidden"><?= htmlspecialchars($row['city'] ?? 'Unknown') ?></div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Location Column -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                        <?= htmlspecialchars($row['city'] ?? 'Unknown') ?>
                                    </div>
                                </td>
                                
                                <!-- Points Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-semibold text-purple-600"><?= number_format($row['points']) ?></span>
                                        <div class="ml-2 w-16 hidden md:block">
                                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                <div class="bg-purple-600 h-1.5 rounded-full" style="width: <?= min(100, $row['points'] / 1000 * 100) ?>%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Actions Column -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="profile.php?id=<?= $row['id'] ?>" class="text-purple-600 hover:text-purple-900 inline-flex items-center">
                                        View
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalUsers > $perPage): ?>
                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium"><?= $offset + 1 ?></span> to <span class="font-medium"><?= min($offset + $perPage, $totalUsers) ?></span> of <span class="font-medium"><?= number_format($totalUsers) ?></span> users
                    </div>
                    <div class="flex space-x-2">
                        <a href="?page=<?= max(1, $page - 1) ?>" class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium <?= $page <= 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50' ?>">
                            Previous
                        </a>
                        <a href="?page=<?= $page + 1 ?>" class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium <?= $offset + $perPage >= $totalUsers ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50' ?>">
                            Next
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- Progress Chart -->
            <div class="bg-white p-6 rounded-xl shadow-md" data-aos="fade-right">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Your Monthly Progress</h3>
                    <select class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:ring-purple-500 focus:border-purple-500">
                        <option>Last 6 Months</option>
                        <option>This Year</option>
                        <option>All Time</option>
                    </select>
                </div>
                <div class="h-64">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>
            
            <!-- Top Cities Chart -->
            <div class="bg-white p-6 rounded-xl shadow-md" data-aos="fade-left">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Happiest Cities</h3>
                    <span class="text-sm text-gray-500">By Total Points</span>
                </div>
                <div class="h-64">
                    <canvas id="citiesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Achievement Callout -->
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-xl shadow-lg p-6 text-center" data-aos="fade-up">
            <h3 class="text-2xl font-bold text-white mb-2">Reach the Top 10!</h3>
            <p class="text-yellow-100 mb-4 max-w-2xl mx-auto">
                You're <?= number_format($userRank - 10) ?> positions away from joining the elite group of happiest people
            </p>
            <a href="smile-capture.php" class="inline-block bg-white text-yellow-700 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition-colors">
                <i class="fas fa-camera mr-2"></i> Earn More Points
            </a>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // User progress chart
    const progressCtx = document.getElementById('progressChart').getContext('2d');
    const progressChart = new Chart(progressCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Your Points',
                data: [
                    <?= round($user['points'] * 0.2) ?>,
                    <?= round($user['points'] * 0.35) ?>,
                    <?= round($user['points'] * 0.5) ?>,
                    <?= round($user['points'] * 0.7) ?>,
                    <?= round($user['points'] * 0.85) ?>,
                    <?= $user['points'] ?>
                ],
                backgroundColor: 'rgba(124, 58, 237, 0.1)',
                borderColor: 'rgba(124, 58, 237, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Top cities chart
    const citiesCtx = document.getElementById('citiesChart').getContext('2d');
    const citiesChart = new Chart(citiesCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_column($topCities, 'city')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($topCities, 'total_points')) ?>,
                backgroundColor: [
                    'rgba(124, 58, 237, 0.8)',
                    'rgba(74, 222, 128, 0.8)',
                    'rgba(249, 115, 22, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(244, 63, 94, 0.8)'
                ],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw.toLocaleString()} points`;
                        }
                    }
                }
            }
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>