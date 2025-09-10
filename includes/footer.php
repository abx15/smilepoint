<footer class="bg-gradient-to-b from-white to-gray-50 border-t border-gray-200 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 py-12">
            <!-- Logo and Description -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <i class="fas fa-smile-beam text-2xl text-purple-600 mr-2"></i>
                    <span class="text-xl font-bold text-gray-800">SmilePoint</span>
                </div>
                <p class="text-gray-600 text-sm">
                    Making the world happier, one smile at a time. Join our mission to spread joy and positivity.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-500 hover:text-purple-600 transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-purple-600 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-purple-600 transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-purple-600 transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="index.php" class="text-gray-600 hover:text-purple-600 transition-colors text-sm">Home</a></li>
                    <li><a href="leaderboard.php" class="text-gray-600 hover:text-purple-600 transition-colors text-sm">Leaderboard</a></li>
                    <li><a href="smile-capture.php" class="text-gray-600 hover:text-purple-600 transition-colors text-sm">Smile Challenge</a></li>
                    <li><a href="profile.php" class="text-gray-600 hover:text-purple-600 transition-colors text-sm">My Profile</a></li>
                </ul>
            </div>

            <!-- Resources -->
            <div>
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-4">Resources</h3>
                <ul class="space-y-2">
                    <li><a href="blog.php" class="text-gray-600 hover:text-purple-600 transition-colors text-sm">Blog</a></li>
                    <li><a href="faq.php" class="text-gray-600 hover:text-purple-600 transition-colors text-sm">FAQs</a></li>
                    <li><a href="privacy.php" class="text-gray-600 hover:text-purple-600 transition-colors text-sm">Privacy Policy</a></li>
                    <li><a href="terms.php" class="text-gray-600 hover:text-purple-600 transition-colors text-sm">Terms of Service</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-4">Stay Updated</h3>
                <p class="text-gray-600 text-sm mb-4">Subscribe to our newsletter for happiness tips and updates</p>
                <form class="flex">
                    <input type="email" placeholder="Your email" class="px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-purple-500 focus:border-purple-500 text-sm w-full">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-r-lg text-sm transition-colors">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Copyright and Bottom Bar -->
        <div class="border-t border-gray-200 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-500 text-sm text-center md:text-left mb-4 md:mb-0">
                    &copy; <?php echo date('Y'); ?> <strong>SmilePoint</strong>. All rights reserved.
                    <span class="text-purple-600">Spread joy, one smile at a time!</span><br>
                    <span class="text-gray-400">Developed by
                        <a href="https://github.com/abx15" target="_blank" class="text-purple-600 hover:underline font-medium">
                            Arun Kumar Bind
                        </a>
                    </span>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-gray-500 hover:text-purple-600 text-sm transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-500 hover:text-purple-600 text-sm transition-colors">Terms of Service</a>
                    <a href="contact.php" class="text-gray-500 hover:text-purple-600 text-sm transition-colors">Contact Us</a>
                </div>
            </div>
        </div>

    </div>
</footer>

<!-- Back to Top Button -->
<button id="back-to-top" class="fixed bottom-6 right-6 bg-purple-600 text-white p-3 rounded-full shadow-lg hover:bg-purple-700 transition-colors opacity-0 invisible transition-all duration-300">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
<script src="assets/js/animations.js"></script>
<script src="assets/js/main.js"></script>

<!-- Back to Top Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.getElementById('back-to-top');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>
</body>

</html>