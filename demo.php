<?php
require_once 'includes/auth.php'; 
require_once 'includes/header.php';
?>

<main class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-purple-600 mb-2" data-aos="fade-down">SmilePoint Demo</h1>
            <p class="text-lg text-gray-600" data-aos="fade-down" data-aos-delay="100">
                Try out the Smile Challenge without creating an account!
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden p-6" data-aos="zoom-in">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <div class="relative bg-gray-100 rounded-lg overflow-hidden mb-4" id="demo-camera-container">
                        <video id="demo-video" width="100%" height="auto" autoplay playsinline class="w-full"></video>
                        <canvas id="demo-canvas" class="hidden"></canvas>
                        <div id="demo-countdown"
                            class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <span class="text-white text-6xl font-bold" id="demo-countdown-number">3</span>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button id="demo-capture-btn"
                            class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                            <i class="fas fa-camera mr-2"></i> Try Smile Challenge
                        </button>
                    </div>
                </div>

                <div>
                    <div id="demo-instructions" class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-blue-800 mb-3">How it works:</h3>
                        <ol class="list-decimal list-inside space-y-2 text-blue-700">
                            <li>Click the "Try Smile Challenge" button</li>
                            <li>Smile when the countdown reaches 1</li>
                            <li>See your smile score (demo version)</li>
                        </ol>
                        <div class="mt-4 p-3 bg-blue-100 rounded-lg">
                            <p class="text-blue-800"><i class="fas fa-info-circle mr-2"></i> To save your scores and
                                compete with others, please <a href="register.php"
                                    class="font-medium text-blue-800 underline">register an account</a>.</p>
                        </div>
                    </div>

                    <div id="demo-result-container" class="hidden mt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Your Demo Smile Score</h3>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium">Smile Detection:</span>
                                <span class="font-bold" id="demo-smile-score">0%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div id="demo-smile-bar" class="bg-purple-600 h-4 rounded-full" style="width: 0%"></div>
                            </div>
                            <p class="mt-3 text-sm text-gray-600" id="demo-smile-feedback"></p>
                        </div>
                        <div class="mt-4 text-center">
                            <button id="demo-try-again-btn" class="text-purple-600 hover:text-purple-800 font-medium">
                                <i class="fas fa-redo mr-1"></i> Try Again
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Ready to join the fun?</h2>
            <a href="register.php"
                class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-medium transition duration-300 transform hover:scale-105">
                Create Your Account Now
            </a>
        </div>
    </div>
</main>

<script src="assets/js/smile-demo.js"></script>

<?php require_once 'includes/footer.php'; ?>