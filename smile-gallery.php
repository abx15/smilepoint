<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$user = getUserData($pdo, $_SESSION['user_id']);

// Pagination logic
$perPage = 12;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// Get total count
$totalSmiles = $pdo->prepare("SELECT COUNT(*) FROM smile_logs WHERE user_id = ?");
$totalSmiles->execute([$user['id']]);
$totalCount = $totalSmiles->fetchColumn();

// Get paginated smile logs - FIXED VERSION
$stmt = $pdo->prepare("SELECT * FROM smile_logs WHERE user_id = :user_id ORDER BY timestamp DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':user_id', $user['id'], PDO::PARAM_INT);
$stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->execute();
$smiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate stats
$averageScore = $pdo->prepare("SELECT AVG(smile_score) FROM smile_logs WHERE user_id = ?");
$averageScore->execute([$user['id']]);
$avgScore = round($averageScore->fetchColumn(), 1);

$bestScore = $pdo->prepare("SELECT MAX(smile_score) FROM smile_logs WHERE user_id = ?");
$bestScore->execute([$user['id']]);
$maxScore = $bestScore->fetchColumn();
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Stats -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-purple-600">Your Smile Journey</h1>
                <p class="text-gray-600">Relive your happiest moments</p>
            </div>
            
            <div class="flex flex-wrap gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 min-w-[180px]">
                    <p class="text-sm text-gray-500">Total Smiles</p>
                    <p class="text-2xl font-bold text-purple-600"><?= $totalCount ?></p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 min-w-[180px]">
                    <p class="text-sm text-gray-500">Average Score</p>
                    <p class="text-2xl font-bold text-purple-600"><?= $avgScore ?>%</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 min-w-[180px]">
                    <p class="text-sm text-gray-500">Best Score</p>
                    <p class="text-2xl font-bold text-purple-600"><?= $maxScore ?>%</p>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <a href="profile.php" class="inline-flex items-center text-purple-600 hover:text-purple-800 mb-6 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Back to Profile
        </a>

        <!-- Empty State -->
        <?php if (empty($smiles)): ?>
            <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="mx-auto w-24 h-24 bg-purple-50 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-smile-beam text-purple-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-800 mb-2">Your smile gallery is empty</h3>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">Complete smile challenges to start collecting your happy moments</p>
                <a href="smile-capture.php" class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg transition-colors">
                    <i class="fas fa-camera mr-2"></i> Start Your First Challenge
                </a>
            </div>
        
        <!-- Smile Grid -->
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($smiles as $smile): ?>
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 group">
                        <!-- Image Container -->
                        <div class="relative aspect-square overflow-hidden">
                            <?php if ($smile['image_url']): ?>
                                <img src="<?= htmlspecialchars($smile['image_url']) ?>" 
                                     alt="Your smile on <?= date('M j, Y', strtotime($smile['timestamp'])) ?>" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-br from-purple-50 to-blue-50 flex items-center justify-center">
                                    <i class="fas fa-smile-beam text-purple-300 text-6xl"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Date Badge -->
                            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-md shadow-sm">
                                <span class="text-xs font-medium text-gray-700">
                                    <?= date('M j, Y', strtotime($smile['timestamp'])) ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Details -->
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="font-medium text-gray-800">
                                    <?= date('g:i A', strtotime($smile['timestamp'])) ?>
                                </h3>
                                <span class="bg-purple-100 text-purple-800 text-sm font-semibold px-2.5 py-0.5 rounded-full">
                                    <?= $smile['smile_score'] ?>%
                                </span>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                                <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full" 
                                     style="width: <?= $smile['smile_score'] ?>%"></div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex justify-between gap-2">
                                <button onclick="shareSmile('<?= $smile['image_url'] ?>', <?= $smile['smile_score'] ?>)" 
                                        class="flex-1 bg-green-50 hover:bg-green-100 text-green-700 py-1.5 rounded-md text-sm transition-colors">
                                    <i class="fab fa-whatsapp mr-1"></i> Share
                                </button>
                                <a href="smile-capture.php" class="flex-1 bg-purple-50 hover:bg-purple-100 text-purple-700 py-1.5 rounded-md text-sm text-center transition-colors">
                                    <i class="fas fa-redo mr-1"></i> Retry
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalCount > $perPage): ?>
                <div class="mt-10 flex justify-center">
                    <div class="flex gap-1">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 bg-white border border-gray-200 rounded-l-md hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php
                        $totalPages = ceil($totalCount / $perPage);
                        $startPage = max(1, $page - 2);
                        $endPage = min($totalPages, $page + 2);
                        
                        for ($i = $startPage; $i <= $endPage; $i++):
                        ?>
                            <a href="?page=<?= $i ?>" class="px-4 py-2 border-t border-b border-gray-200 <?= $i == $page ? 'bg-purple-50 text-purple-600 font-medium border-purple-200' : 'bg-white hover:bg-gray-50' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 bg-white border border-gray-200 rounded-r-md hover:bg-gray-50">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</main>

<script>
function shareSmile(imageUrl, score) {
    const message = `I scored ${score}% on SmilePoint! 😊\n` + 
                   `Can you beat my happiness score?\n` +
                   `Join me at: ${window.location.origin}`;
    
    if(imageUrl) {
        // For web
        window.open(`https://wa.me/?text=${encodeURIComponent(message + '\n\n' + imageUrl)}`);
    } else {
        // For mobile devices
        window.open(`whatsapp://send?text=${encodeURIComponent(message)}`);
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>