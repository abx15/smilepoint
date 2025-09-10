<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$user = getUserData($pdo, $_SESSION['user_id']);

$today = date('Y-m-d');
$canSmileToday = true;
$message = '';

if ($user['last_smile_date'] === $today && $user['smile_count_today'] >= 10) {
    $canSmileToday = false;
    $message = "You've already smiled 10 times today! Come back tomorrow for more points.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $canSmileToday) {
    $smileScore = isset($_POST['smile_score']) ? (int) $_POST['smile_score'] : 0;
    $imageData = $_POST['image_data'] ?? '';

    // Save image if provided
    $imagePath = '';
    if (!empty($imageData)) {
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $imageBinary = base64_decode($imageData);

        $fileName = 'smile_' . $user['id'] . '_' . time() . '.png';
        $filePath = 'uploads/' . $fileName;

        if (file_put_contents($filePath, $imageBinary)) {
            $imagePath = $filePath;
        }
    }

    // Decide points and type
    $pointsToAdd = $smileScore > 50 ? rand(2, 15) : 1;
    $type = $smileScore > 50 ? 'smile' : 'attempt';

    // Update user points
    $stmt = $pdo->prepare("UPDATE users SET points = points + ?, last_smile_date = ?, smile_count_today = smile_count_today + 1 WHERE id = ?");
    $stmt->execute([$pointsToAdd, $today, $user['id']]);

    // Log the smile attempt
    $stmt = $pdo->prepare("INSERT INTO smile_logs (user_id, image_url, smile_score) VALUES (?, ?, ?)");
    $stmt->execute([$user['id'], $imagePath, $smileScore]);

    // Redirect with success, points and type
    header("Location: smile-capture.php?success=1&points=$pointsToAdd&type=$type");
    exit();
}

require_once 'includes/header.php';
?>

<main class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Heading -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-purple-600 mb-2" data-aos="fade-down">Smile Challenge</h1>
            <p class="text-lg text-gray-600" data-aos="fade-down" data-aos-delay="100">
                Smile for the camera and earn points! You can participate up to 10 times per day.
            </p>
            <div class="mt-4">
                <span class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                    Current Points: <?php echo $user['points']; ?>
                </span>
            </div>
        </div>

        <!-- Success Message -->
        <?php if (isset($_GET['success']) && isset($_GET['points']) && isset($_GET['type'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-8 text-center"
                id="success-message">
                <p class="font-bold">Success!</p>
                <?php if ($_GET['type'] === 'smile'): ?>
                    <p>You earned <?= htmlspecialchars($_GET['points']) ?> points for your beautiful smile! 😁</p>
                <?php else: ?>
                    <p>You earned 1 points for attempting the selfie. Keep smiling! 🙂</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Limit Reached -->
        <?php if (!$canSmileToday): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-8 text-center">
                <p class="font-bold">Daily Limit Reached</p>
                <p><?php echo $message; ?></p>
                <a href="leaderboard.php" class="mt-2 inline-block text-purple-600 hover:text-purple-800 font-medium">
                    Check the leaderboard instead <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        <?php else: ?>

            <!-- Smile Capture Box -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden p-6" data-aos="zoom-in">
                <div class="grid md:grid-cols-2 gap-8 items-center">

                    <!-- Camera -->
                    <div>
                        <div class="relative bg-gray-100 rounded-lg overflow-hidden mb-4" id="camera-container">
                            <video id="video" width="100%" height="auto" autoplay playsinline class="w-full"></video>
                            <canvas id="canvas" class="hidden"></canvas>
                            <div id="countdown"
                                class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                <span class="text-white text-6xl font-bold" id="countdown-number">3</span>
                            </div>
                        </div>

                        <div class="flex justify-center space-x-4">
                            <button id="capture-btn"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                                <i class="fas fa-camera mr-2"></i> Capture Smile
                            </button>
                            <button id="retry-btn"
                                class="border border-purple-600 text-purple-600 hover:bg-purple-50 px-6 py-2 rounded-lg font-medium transition duration-300 hidden">
                                <i class="fas fa-redo mr-2"></i> Retry
                            </button>
                        </div>
                    </div>

                    <!-- Instructions + Result -->
                    <div>
                        <div id="instructions" class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-blue-800 mb-3">How to play:</h3>
                            <ol class="list-decimal list-inside space-y-2 text-blue-700">
                                <li>Make sure your face is clearly visible</li>
                                <li>Click "Capture Smile" button</li>
                                <li>Smile when the countdown reaches 1</li>
                                <li>Earn <strong>up to 15 points</strong> for a good smile or <strong>2 points</strong> just
                                    for trying!</li>
                            </ol>
                            <div class="mt-4 p-3 bg-blue-100 rounded-lg">
                                <p class="text-blue-800"><i class="fas fa-info-circle mr-2"></i> You can participate up to
                                    10 times per day.</p>
                            </div>
                        </div>

                        <!-- Smile Score Result -->
                        <div id="result-container" class="hidden mt-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3">Your Smile Score</h3>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium">Smile Detection:</span>
                                    <span class="font-bold" id="smile-score">0%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-4">
                                    <div id="smile-bar" class="bg-purple-600 h-4 rounded-full" style="width: 0%"></div>
                                </div>
                                <p class="mt-3 text-sm text-gray-600" id="smile-feedback"></p>
                            </div>

                            <!-- Submit Form -->
                            <form id="smile-form" method="POST" class="mt-4">
                                <input type="hidden" name="smile_score" id="form-smile-score">
                                <input type="hidden" name="image_data" id="form-image-data">
                                <button type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md font-medium transition duration-300">
                                    <i class="fas fa-check-circle mr-2"></i> Submit Smile
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<!-- Smile JS -->
<script src="assets/js/smile-capture.js"></script>

<!-- Auto-hide success message -->
<script>
    const successBox = document.getElementById('success-message');
    if (successBox) {
        setTimeout(() => {
            successBox.style.display = 'none';
        }, 5000); // hides after 5 seconds
    }
</script>

<?php require_once 'includes/footer.php'; ?>