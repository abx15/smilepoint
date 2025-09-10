<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

// Initialize variables
$success = false;
$errors = [];
$formData = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'subject' => '',
    'message' => '',
    'consent' => false
];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and store form data
    $formData = [
        'name' => trim($_POST['name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'subject' => trim($_POST['subject'] ?? ''),
        'message' => trim($_POST['message'] ?? ''),
        'consent' => isset($_POST['consent'])
    ];

    // Validate inputs
    if (empty($formData['name'])) {
        $errors['name'] = 'Please enter your name';
    }

    if (empty($formData['email'])) {
        $errors['email'] = 'Please enter your email';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email';
    }

    if (empty($formData['subject'])) {
        $errors['subject'] = 'Please select a subject';
    }

    if (empty($formData['message'])) {
        $errors['message'] = 'Please enter your message';
    }

    if (!$formData['consent']) {
        $errors['consent'] = 'Please agree to our privacy policy';
    }

    // If no errors, save to database
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_submissions 
                                  (name, email, phone, subject, message) 
                                  VALUES (:name, :email, :phone, :subject, :message)");
            
            $stmt->execute([
                ':name' => $formData['name'],
                ':email' => $formData['email'],
                ':phone' => $formData['phone'],
                ':subject' => $formData['subject'],
                ':message' => $formData['message']
            ]);
            
            $success = true;
            // Clear form data on success
            $formData = [
                'name' => '',
                'email' => '',
                'phone' => '',
                'subject' => '',
                'message' => '',
                'consent' => false
            ];
        } catch (PDOException $e) {
            $errors['database'] = 'Error saving your message. Please try again later.';
            error_log('Contact Form Error: ' . $e->getMessage());
        }
    }
}
?>

<!-- Contact Form Section -->
<section class="py-20 bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="inline-flex items-center bg-purple-100 text-purple-800 px-4 py-1 rounded-full text-sm font-semibold mb-4">
                <i class="fas fa-envelope mr-2"></i> Get In Touch
            </span>
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Contact Us</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Have questions or feedback? We'd love to hear from you!
            </p>
        </div>

        <?php if (!empty($errors['database'])): ?>
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i> <?= htmlspecialchars($errors['database']) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i> Your message has been sent successfully! We'll get back to you soon.
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="grid md:grid-cols-2">
                <!-- Contact Info -->
                <div class="bg-gradient-to-b from-purple-600 to-blue-600 p-10 text-white">
                    <h3 class="text-2xl font-bold mb-6">Contact Information</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-white/20 p-2 rounded-lg mr-4">
                                <i class="fas fa-map-marker-alt text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Our Location</h4>
                                <p class="text-white/80">Bhadohi, Uttar Pradesh, India</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-white/20 p-2 rounded-lg mr-4">
                                <i class="fas fa-envelope text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Email Us</h4>
                                <p class="text-white/80">contact@smilepoint.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-white/20 p-2 rounded-lg mr-4">
                                <i class="fas fa-phone-alt text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Call Us</h4>
                                <p class="text-white/80">+91 98765 43210</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-10 pt-6 border-t border-white/20">
                        <h4 class="font-semibold mb-4">Follow Us</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-white/10 hover:bg-white/20 w-10 h-10 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="bg-white/10 hover:bg-white/20 w-10 h-10 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="bg-white/10 hover:bg-white/20 w-10 h-10 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="bg-white/10 hover:bg-white/20 w-10 h-10 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="p-10">
                    <form id="contactForm" method="POST" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 rounded-lg border <?= isset($errors['name']) ? 'border-red-500' : 'border-gray-300' ?> focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                placeholder="Enter your name"
                                value="<?= htmlspecialchars($formData['name']) ?>">
                            <?php if (isset($errors['name'])): ?>
                                <div class="text-red-500 text-sm mt-1"><?= htmlspecialchars($errors['name']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 rounded-lg border <?= isset($errors['email']) ? 'border-red-500' : 'border-gray-300' ?> focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                placeholder="Enter your email"
                                value="<?= htmlspecialchars($formData['email']) ?>">
                            <?php if (isset($errors['email'])): ?>
                                <div class="text-red-500 text-sm mt-1"><?= htmlspecialchars($errors['email']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                placeholder="Enter your phone number"
                                value="<?= htmlspecialchars($formData['phone']) ?>">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject *</label>
                            <select id="subject" name="subject" required
                                class="w-full px-4 py-3 rounded-lg border <?= isset($errors['subject']) ? 'border-red-500' : 'border-gray-300' ?> focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                                <option value="" disabled selected>Select a subject</option>
                                <option value="general" <?= $formData['subject'] === 'general' ? 'selected' : '' ?>>General Inquiry</option>
                                <option value="feedback" <?= $formData['subject'] === 'feedback' ? 'selected' : '' ?>>Feedback/Suggestions</option>
                                <option value="support" <?= $formData['subject'] === 'support' ? 'selected' : '' ?>>Technical Support</option>
                                <option value="business" <?= $formData['subject'] === 'business' ? 'selected' : '' ?>>Business Inquiry</option>
                                <option value="other" <?= $formData['subject'] === 'other' ? 'selected' : '' ?>>Other</option>
                            </select>
                            <?php if (isset($errors['subject'])): ?>
                                <div class="text-red-500 text-sm mt-1"><?= htmlspecialchars($errors['subject']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Your Message *</label>
                            <textarea id="message" name="message" rows="4" required
                                class="w-full px-4 py-3 rounded-lg border <?= isset($errors['message']) ? 'border-red-500' : 'border-gray-300' ?> focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                placeholder="Enter your message"><?= htmlspecialchars($formData['message']) ?></textarea>
                            <?php if (isset($errors['message'])): ?>
                                <div class="text-red-500 text-sm mt-1"><?= htmlspecialchars($errors['message']) ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" id="consent" name="consent" required
                                    class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                    <?= $formData['consent'] ? 'checked' : '' ?>>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="consent" class="text-gray-700">
                                    I agree to the <a href="privacy.php" class="text-purple-600 hover:underline">privacy policy</a> *
                                </label>
                            </div>
                        </div>
                        <?php if (isset($errors['consent'])): ?>
                            <div class="text-red-500 text-sm mt-1"><?= htmlspecialchars($errors['consent']) ?></div>
                        <?php endif; ?>
                        
                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                            <i class="fas fa-paper-plane mr-2"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>