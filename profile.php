<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$user = getUserData($pdo, $_SESSION['user_id']);

// Get user's smile history (last 5)
$stmt = $pdo->prepare("SELECT * FROM smile_logs WHERE user_id = ? ORDER BY timestamp DESC LIMIT 5");
$stmt->execute([$user['id']]);
$smileHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get current active challenge
$currentChallenge = $pdo->query("SELECT * FROM smile_challenges WHERE CURDATE() BETWEEN start_date AND end_date LIMIT 1")->fetch();

// Calculate charity stats
$pointsPerChild = 100;
$childrenHelped = floor($user['points'] / $pointsPerChild);
$progress = ($user['points'] % $pointsPerChild);

// Handle profile update
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $city = trim($_POST['city']);
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validate name
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }

    // Validate city
    if (empty($city)) {
        $errors['city'] = 'City is required';
    }

    // Validate password change if any field is filled
    if (!empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword)) {
        if (empty($currentPassword)) {
            $errors['current_password'] = 'Current password is required';
        } elseif (!password_verify($currentPassword, $user['password'])) {
            $errors['current_password'] = 'Current password is incorrect';
        }

        if (empty($newPassword)) {
            $errors['new_password'] = 'New password is required';
        } elseif (strlen($newPassword) < 6) {
            $errors['new_password'] = 'Password must be at least 6 characters';
        }

        if ($newPassword !== $confirmPassword) {
            $errors['confirm_password'] = 'Passwords do not match';
        }
    }

    if (empty($errors)) {
        // Update profile
        $updateFields = ['name' => $name, 'city' => $city];
        $updateQuery = "UPDATE users SET name = :name, city = :city";

        // Update password if changed
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateFields['password'] = $hashedPassword;
            $updateQuery .= ", password = :password";
        }

        $updateQuery .= " WHERE id = :id";
        $updateFields['id'] = $user['id'];

        $stmt = $pdo->prepare($updateQuery);
        if ($stmt->execute($updateFields)) {
            $success = true;
            $user = getUserData($pdo, $user['id']); // Refresh user data

            // Update session with new name
            $_SESSION['user_name'] = $user['name'];
        }
    }
}

require_once 'includes/header.php';
?>

<main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4" data-aos="fade-down">
            <div>
                <h1 class="text-3xl font-bold text-purple-600 mb-2">Your Profile</h1>
                <p class="text-lg text-gray-600">Manage your account and smile journey</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                    <i class="fas fa-trophy mr-1"></i> Rank #<?php
                                                                $stmt = $pdo->prepare("SELECT COUNT(*) as rank FROM users WHERE points > ?");
                                                                $stmt->execute([$user['points']]);
                                                                echo $stmt->fetch(PDO::FETCH_ASSOC)['rank'] + 1;
                                                                ?>
                </span>
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                    <i class="fas fa-star mr-1"></i> <?= $user['points'] ?> Points
                </span>
            </div>
        </div>

        <?php if ($success): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-lg" data-aos="fade-up">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p class="font-medium">Profile updated successfully!</p>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column - Profile Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Profile Information Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-right">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user-circle mr-2 text-purple-600"></i>
                            Profile Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <form action="profile.php" method="POST">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name Field -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 transition duration-300">
                                    <?php if (isset($errors['name'])): ?>
                                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['name'] ?></p>
                                    <?php endif; ?>
                                </div>

                                <!-- Email Field (disabled) -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" id="email" value="<?= htmlspecialchars($user['email']) ?>"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-100 cursor-not-allowed" disabled>
                                </div>

                                <!-- City Field -->
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Your City</label>
                                    <select id="city" name="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 transition duration-300">
                                        <option value="">Select State/UT</option>
                                        <!-- 28 Indian States -->
                                        <option value="Andhra Pradesh" <?= $user['city'] == 'Andhra Pradesh' ? 'selected' : '' ?>>Andhra Pradesh</option>
                                        <option value="Arunachal Pradesh" <?= $user['city'] == 'Arunachal Pradesh' ? 'selected' : '' ?>>Arunachal Pradesh</option>
                                        <option value="Assam" <?= $user['city'] == 'Assam' ? 'selected' : '' ?>>Assam</option>
                                        <option value="Bihar" <?= $user['city'] == 'Bihar' ? 'selected' : '' ?>>Bihar</option>
                                        <option value="Chhattisgarh" <?= $user['city'] == 'Chhattisgarh' ? 'selected' : '' ?>>Chhattisgarh</option>
                                        <option value="Goa" <?= $user['city'] == 'Goa' ? 'selected' : '' ?>>Goa</option>
                                        <option value="Gujarat" <?= $user['city'] == 'Gujarat' ? 'selected' : '' ?>>Gujarat</option>
                                        <option value="Haryana" <?= $user['city'] == 'Haryana' ? 'selected' : '' ?>>Haryana</option>
                                        <option value="Himachal Pradesh" <?= $user['city'] == 'Himachal Pradesh' ? 'selected' : '' ?>>Himachal Pradesh</option>
                                        <option value="Jharkhand" <?= $user['city'] == 'Jharkhand' ? 'selected' : '' ?>>Jharkhand</option>
                                        <option value="Karnataka" <?= $user['city'] == 'Karnataka' ? 'selected' : '' ?>>Karnataka</option>
                                        <option value="Kerala" <?= $user['city'] == 'Kerala' ? 'selected' : '' ?>>Kerala</option>
                                        <option value="Madhya Pradesh" <?= $user['city'] == 'Madhya Pradesh' ? 'selected' : '' ?>>Madhya Pradesh</option>
                                        <option value="Maharashtra" <?= $user['city'] == 'Maharashtra' ? 'selected' : '' ?>>Maharashtra</option>
                                        <option value="Manipur" <?= $user['city'] == 'Manipur' ? 'selected' : '' ?>>Manipur</option>
                                        <option value="Meghalaya" <?= $user['city'] == 'Meghalaya' ? 'selected' : '' ?>>Meghalaya</option>
                                        <option value="Mizoram" <?= $user['city'] == 'Mizoram' ? 'selected' : '' ?>>Mizoram</option>
                                        <option value="Nagaland" <?= $user['city'] == 'Nagaland' ? 'selected' : '' ?>>Nagaland</option>
                                        <option value="Odisha" <?= $user['city'] == 'Odisha' ? 'selected' : '' ?>>Odisha</option>
                                        <option value="Punjab" <?= $user['city'] == 'Punjab' ? 'selected' : '' ?>>Punjab</option>
                                        <option value="Rajasthan" <?= $user['city'] == 'Rajasthan' ? 'selected' : '' ?>>Rajasthan</option>
                                        <option value="Sikkim" <?= $user['city'] == 'Sikkim' ? 'selected' : '' ?>>Sikkim</option>
                                        <option value="Tamil Nadu" <?= $user['city'] == 'Tamil Nadu' ? 'selected' : '' ?>>Tamil Nadu</option>
                                        <option value="Telangana" <?= $user['city'] == 'Telangana' ? 'selected' : '' ?>>Telangana</option>
                                        <option value="Tripura" <?= $user['city'] == 'Tripura' ? 'selected' : '' ?>>Tripura</option>
                                        <option value="Uttar Pradesh" <?= $user['city'] == 'Uttar Pradesh' ? 'selected' : '' ?>>Uttar Pradesh</option>
                                        <option value="Uttarakhand" <?= $user['city'] == 'Uttarakhand' ? 'selected' : '' ?>>Uttarakhand</option>
                                        <option value="West Bengal" <?= $user['city'] == 'West Bengal' ? 'selected' : '' ?>>West Bengal</option>

                                        <!-- 8 Union Territories -->
                                        <option value="Andaman and Nicobar Islands" <?= $user['city'] == 'Andaman and Nicobar Islands' ? 'selected' : '' ?>>Andaman and Nicobar Islands</option>
                                        <option value="Chandigarh" <?= $user['city'] == 'Chandigarh' ? 'selected' : '' ?>>Chandigarh</option>
                                        <option value="Dadra and Nagar Haveli and Daman and Diu" <?= $user['city'] == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' ?>>Dadra and Nagar Haveli and Daman and Diu</option>
                                        <option value="Delhi" <?= $user['city'] == 'Delhi' ? 'selected' : '' ?>>Delhi</option>
                                        <option value="Jammu and Kashmir" <?= $user['city'] == 'Jammu and Kashmir' ? 'selected' : '' ?>>Jammu and Kashmir</option>
                                        <option value="Ladakh" <?= $user['city'] == 'Ladakh' ? 'selected' : '' ?>>Ladakh</option>
                                        <option value="Lakshadweep" <?= $user['city'] == 'Lakshadweep' ? 'selected' : '' ?>>Lakshadweep</option>
                                        <option value="Puducherry" <?= $user['city'] == 'Puducherry' ? 'selected' : '' ?>>Puducherry</option>
                                    </select>

                                    <?php if (isset($errors['city'])): ?>
                                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['city'] ?></p>
                                    <?php endif; ?>
                                </div>

                                <!-- Points Display -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Smile Points</label>
                                    <div class="flex items-center">
                                        <span class="text-3xl font-bold text-purple-600 mr-3"><?= number_format($user['points']) ?></span>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2.5 rounded-full"
                                                style="width: <?= min(100, ($user['points'] / 1000) * 100) ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Change Section -->
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-lock mr-2 text-purple-600"></i>
                                    Change Password
                                </h3>
                                <div class="space-y-4">
                                    <!-- Current Password -->
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                        <input type="password" id="current_password" name="current_password"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 transition duration-300">
                                        <?php if (isset($errors['current_password'])): ?>
                                            <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['current_password'] ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- New Password -->
                                    <div>
                                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                        <input type="password" id="new_password" name="new_password"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 transition duration-300">
                                        <?php if (isset($errors['new_password'])): ?>
                                            <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['new_password'] ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                        <input type="password" id="confirm_password" name="confirm_password"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 transition duration-300">
                                        <?php if (isset($errors['confirm_password'])): ?>
                                            <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i><?= $errors['confirm_password'] ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-8">
                                <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-medium shadow-md transition duration-300 transform hover:scale-105">
                                    <i class="fas fa-save mr-2"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Smile Challenge Card -->
                <?php if ($currentChallenge): ?>
                    <div class="bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl shadow-md overflow-hidden border border-yellow-200" data-aos="fade-up">
                        <div class="px-6 py-4 border-b border-yellow-200 bg-yellow-100/50">
                            <h2 class="text-xl font-semibold text-yellow-800 flex items-center">
                                <i class="fas fa-fire mr-2 text-yellow-600"></i>
                                <?= htmlspecialchars($currentChallenge['name']) ?>
                            </h2>
                        </div>
                        <div class="p-6">
                            <p class="text-yellow-700 mb-4">
                                <i class="fas fa-info-circle mr-1"></i> Score <?= $currentChallenge['min_score'] ?>+ to earn a special badge!<br>
                                <span class="text-sm">Ends on <?= date('F j, Y', strtotime($currentChallenge['end_date'])) ?></span>
                            </p>

                            <?php
                            // Check if user earned it
                            $stmt = $pdo->prepare("SELECT COUNT(*) as attempts FROM smile_logs 
                                              WHERE user_id = ? AND smile_score >= ? 
                                              AND timestamp BETWEEN ? AND ?");
                            $stmt->execute([
                                $user['id'],
                                $currentChallenge['min_score'],
                                $currentChallenge['start_date'],
                                $currentChallenge['end_date']
                            ]);
                            $attempts = $stmt->fetch()['attempts'];
                            ?>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <?php if ($attempts > 0): ?>
                                        <img src="/assets/<?= $currentChallenge['badge_image'] ?>" class="h-16 mr-4" alt="Challenge Badge">
                                        <div>
                                            <p class="font-bold text-green-600">Challenge Completed!</p>
                                            <p class="text-sm text-yellow-700"><?= $attempts ?> successful attempts</p>
                                        </div>
                                    <?php else: ?>
                                        <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-lock text-gray-500 text-2xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-yellow-800">Complete the challenge to unlock</p>
                                            <p class="text-sm text-yellow-700"><?= $currentChallenge['min_score'] ?>+ points needed</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <a href="smile-capture.php" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                                    <i class="fas fa-camera mr-1"></i> Try Now
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column - Stats and Recent Activity -->
            <div class="space-y-6">
                <!-- Stats Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-left">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-chart-bar mr-2 text-purple-600"></i>
                            Your Stats
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Total Smiles -->
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <p class="text-sm text-purple-700 mb-1">Total Smiles</p>
                                <p class="text-2xl font-bold text-purple-600">
                                    <?php
                                    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM smile_logs WHERE user_id = ?");
                                    $stmt->execute([$user['id']]);
                                    echo number_format($stmt->fetch(PDO::FETCH_ASSOC)['total']);
                                    ?>
                                </p>
                            </div>

                            <!-- Today's Smiles -->
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm text-blue-700 mb-1">Today's Smiles</p>
                                <p class="text-2xl font-bold text-blue-600">
                                    <?= $user['smile_count_today'] ?? 0 ?>/10
                                </p>
                            </div>

                            <!-- Member Since -->
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-green-700 mb-1">Member Since</p>
                                <p class="text-xl font-bold text-green-600">
                                    <?= date('M Y', strtotime($user['created_at'])) ?>
                                </p>
                            </div>

                            <!-- Average Score -->
                            <div class="bg-pink-50 p-4 rounded-lg">
                                <p class="text-sm text-pink-700 mb-1">Avg. Score</p>
                                <p class="text-2xl font-bold text-pink-600">
                                    <?php
                                    $stmt = $pdo->prepare("SELECT AVG(smile_score) as avg_score FROM smile_logs WHERE user_id = ?");
                                    $stmt->execute([$user['id']]);
                                    echo round($stmt->fetch(PDO::FETCH_ASSOC)['avg_score']);
                                    ?>%
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charity Card -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-md overflow-hidden border border-blue-200" data-aos="fade-left" data-aos-delay="100">
                    <div class="px-6 py-4 border-b border-blue-200 bg-blue-100/50">
                        <h2 class="text-xl font-semibold text-blue-800 flex items-center">
                            <i class="fas fa-hands-helping mr-2 text-blue-600"></i>
                            Smile for Education
                        </h2>
                    </div>
                    <div class="p-6">
                        <p class="text-blue-700 mb-4">
                            <i class="fas fa-info-circle mr-1"></i> Every <strong><?= $pointsPerChild ?> points</strong> = ₹10 donated to educate underprivileged children
                        </p>

                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-blue-800 mb-1">
                                <span>Progress to next donation</span>
                                <span><?= $progress ?>/<?= $pointsPerChild ?></span>
                            </div>
                            <div class="w-full bg-blue-200 rounded-full h-2.5">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-2.5 rounded-full"
                                    style="width: <?= ($progress / $pointsPerChild) * 100 ?>%"></div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-blue-200 shadow-inner">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-blue-900"><?= $childrenHelped ?> children helped</p>
                                    <p class="text-sm text-blue-600">₹<?= $childrenHelped * 10 ?> donated</p>
                                </div>
                                <i class="fas fa-child text-4xl text-blue-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Smiles Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-left" data-aos-delay="200">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-history mr-2 text-purple-600"></i>
                            Recent Smiles
                        </h2>
                    </div>
                    <div class="p-6">
                        <?php if (empty($smileHistory)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-smile-beam text-gray-300 text-4xl mb-2"></i>
                                <p class="text-gray-500">No smile history yet</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach ($smileHistory as $log): ?>
                                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition duration-200">
                                        <div class="flex items-center">
                                            <div class="bg-gradient-to-br from-purple-100 to-pink-100 w-12 h-12 rounded-lg flex items-center justify-center mr-3">
                                                <span class="text-xl"><?= $log['smile_score'] > 80 ? '😊' : '🙂' ?></span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800">
                                                    <?= date('M j, g:i a', strtotime($log['timestamp'])) ?>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    Score: <?= $log['smile_score'] ?>%
                                                </p>
                                            </div>
                                        </div>
                                        <span class="bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-full text-sm font-semibold">
                                            +<?= $log['smile_score'] > 50 ? 10 : 5 ?> pts
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="mt-6 text-center">
                                <a href="smile-gallery.php" class="inline-flex items-center text-purple-600 hover:text-purple-800 font-medium transition duration-300">
                                    <span class="mr-2">View Full Smile Gallery</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>