<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (isLoggedIn()) {
    header('Location: profile.php');
    exit();
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: smile-capture.php');
            exit();
        } else {
            $errors['login'] = 'Invalid email or password';
        }
    }
}

require_once 'includes/header.php';
?>

<main class="py-12">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden p-8" data-aos="zoom-in">
        <h2 class="text-3xl font-bold text-center text-purple-600 mb-8">Welcome Back!</h2>
        
        <?php if (isset($errors['login'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo $errors['login']; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                <?php if (isset($errors['email'])): ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo $errors['email']; ?></p>
                <?php endif; ?>
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                <?php if (isset($errors['password'])): ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo $errors['password']; ?></p>
                <?php endif; ?>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>
                
                <div class="text-sm">
                    <a href="#" class="font-medium text-purple-600 hover:text-purple-500">Forgot password?</a>
                </div>
            </div>
            
            <div>
                <button type="submit" class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition duration-300">
                    Sign in
                </button>
            </div>
            
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account? <a href="register.php" class="font-medium text-purple-600 hover:text-purple-500">Register now</a>
                </p>
            </div>
        </form>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>