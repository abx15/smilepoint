<style>
    /* Base Animations */
    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }

        33% {
            transform: translate(30px, -50px) scale(1.1);
        }

        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }

        100% {
            transform: translate(0px, 0px) scale(1);
        }
    }

    @keyframes float {
        0% {
            transform: translateY(0px) rotate(0deg);
        }

        50% {
            transform: translateY(-20px) rotate(5deg);
        }

        100% {
            transform: translateY(0px) rotate(0deg);
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    /* Animation Classes */
    .animate-blob {
        animation: blob 8s infinite ease-in-out;
    }

    .animate-float {
        animation: float 6s infinite ease-in-out;
    }

    .animate-pulse {
        animation: pulse 2s infinite;
    }

    /* Animation Delays */
    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .animation-delay-4000 {
        animation-delay: 4s;
    }

    /* Hover Effects */
    .hover-rotate {
        transition: transform 0.3s ease;
    }

    .hover-rotate:hover {
        transform: rotate(2deg);
    }

    /* Bounce Animation (for emoji elements) */
    .animate-bounce {
        animation: bounce 2s infinite;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-15px);
        }
    }
</style>


<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';
?>

<main class="overflow-hidden">
    <section class="relative py-28 px-4 bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <div class="absolute top-20 left-20 w-72 h-72 rounded-full bg-purple-300 mix-blend-multiply filter blur-3xl opacity-60 animate-blob"></div>
                <div class="absolute top-60 right-32 w-64 h-64 rounded-full bg-blue-300 mix-blend-multiply filter blur-3xl opacity-60 animate-blob animation-delay-2000"></div>
                <div class="absolute bottom-20 left-1/2 w-80 h-80 rounded-full bg-pink-300 mix-blend-multiply filter blur-3xl opacity-60 animate-blob animation-delay-4000"></div>

                <div class="absolute top-1/4 right-1/4 text-6xl opacity-20 animate-float">😊</div>
                <div class="absolute bottom-1/3 left-1/4 text-5xl opacity-20 animate-float animation-delay-1500">🌟</div>
                <div class="absolute top-1/3 right-1/3 text-7xl opacity-20 animate-float animation-delay-3000">😍</div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right" data-aos-duration="800" data-aos-delay="100">
                    <div class="inline-flex items-center bg-gradient-to-r from-purple-100 to-blue-100 text-purple-800 px-4 py-1.5 rounded-full text-sm font-semibold mb-6 transform transition hover:scale-105 hover:shadow-sm">
                        <span class="mr-2">✨</span> Happiness Guaranteed
                        <span class="ml-2 px-2 py-0.5 bg-white/80 rounded-full text-xs font-bold shadow-inner">NEW</span>
                    </div>

                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Your Smile, <span class="relative">
                            <span class="text-purple-600">Our Passion</span>
                            <span class="absolute -bottom-2 left-0 w-full h-2 bg-yellow-300/40 -rotate-1"></span>
                        </span>
                        <br>
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-purple-500 via-pink-500 to-blue-500">Earn While You Beam</span>
                    </h1>

                    <p class="text-xl text-gray-700 mb-8 max-w-lg">
                        Join the revolution where every genuine smile earns you points, rewards, and contributes to a happier world community.
                    </p>

                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mb-10">
                        <a href="register.php" class="relative group bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-8 py-4 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <span class="relative z-10 flex items-center justify-center">
                                <i class="fas fa-smile-wink mr-3 text-lg"></i> Start Smiling Now
                            </span>
                            <span class="absolute inset-0 bg-gradient-to-r from-purple-700 to-pink-600 rounded-lg opacity-0 group-hover:opacity-100 transition duration-300"></span>
                        </a>
                        <a href="demo.php" class="flex items-center justify-center bg-white/90 border-2 border-purple-600 text-purple-600 hover:bg-white hover:shadow-md px-8 py-4 rounded-lg font-medium transition duration-300 transform hover:scale-105 group">
                            <span class="mr-2">See Live Demo</span>
                            <i class="fas fa-play text-purple-600 group-hover:text-purple-700 transition-transform duration-300 group-hover:translate-x-1"></i>
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-gray-600">
                        <div class="flex items-center">
                            <div class="flex -space-x-3">
                                <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm" src="https://randomuser.me/api/portraits/women/44.jpg" alt="User">
                                <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm" src="https://randomuser.me/api/portraits/men/32.jpg" alt="User">
                                <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm" src="https://randomuser.me/api/portraits/women/68.jpg" alt="User">
                            </div>
                            <span class="ml-3 text-sm">
                                Trusted by <span class="font-bold text-purple-600">10,000+</span> happy users
                            </span>
                        </div>
                        <div class="flex items-center text-sm bg-white px-3 py-1.5 rounded-full shadow-sm border border-gray-100">
                            <div class="relative mr-2 w-4 h-4">
                                <div class="absolute inset-0 bg-green-400 rounded-full animate-ping opacity-75"></div>
                                <div class="absolute inset-0 bg-green-500 rounded-full"></div>
                            </div>
                            <span>500+ smiles detected daily</span>
                        </div>
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-duration="800" class="relative">
                    <div class="relative bg-white rounded-3xl p-1.5 shadow-2xl transform transition duration-500 hover:scale-[1.02] hover:shadow-2xl">
                        <!-- Decorative Elements -->
                        <div class="absolute -top-5 -right-5 bg-yellow-400 rounded-full w-24 h-24 flex items-center justify-center shadow-lg animate-bounce z-10">
                            <span class="text-5xl">😊</span>
                        </div>
                        <div class="absolute -bottom-5 -left-5 bg-green-400 rounded-full w-24 h-24 flex items-center justify-center shadow-lg animate-bounce z-10" style="animation-delay: 0.2s">
                            <span class="text-5xl">👍</span>
                        </div>
                        <div class="absolute top-1/2 -right-6 bg-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full transform rotate-90">
                            TRENDING NOW
                        </div>

                        <div class="overflow-hidden rounded-2xl border-8 border-white relative">
                            <img src="assets/images/smile-demo.png" alt="SmilePoint Demo" class="w-full h-auto object-cover">

                            <div class="absolute top-6 right-6 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-xl shadow-md flex items-center">
                                <div class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded mr-2">
                                    +98%
                                </div>
                                <span class="font-bold text-gray-800">Happiness Score</span>
                            </div>

                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/60 to-transparent p-6">
                                <div class="text-white">
                                    <p class="text-sm font-light mb-1">Today's Happiness Leader</p>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-xl font-bold">Priya from Mumbai</h4>
                                            <div class="flex items-center">
                                                <p class="text-yellow-300 font-medium mr-3">🌟 3,450 Points</p>
                                                <span class="text-xs bg-yellow-500/20 px-2 py-0.5 rounded">TOP 0.5%</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center bg-purple-600 rounded-full w-12 h-12">
                                            <i class="fas fa-crown text-yellow-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -bottom-6 right-10 bg-white px-4 py-2 rounded-full shadow-lg flex items-center border border-gray-100">
                        <div class="bg-purple-100 text-purple-800 p-1 rounded-full mr-2">
                            <i class="fas fa-medal text-sm"></i>
                        </div>
                        <span class="text-sm font-medium">50+ Achievements</span>
                    </div>
                </div>
            </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="bg-gray-50 p-6 rounded-xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-4xl font-bold text-purple-600 mb-2">15K+</div>
                    <div class="text-gray-600">Smiles Recorded</div>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-4xl font-bold text-purple-600 mb-2">92%</div>
                    <div class="text-gray-600">Happiness Increase</div>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-4xl font-bold text-purple-600 mb-2">50+</div>
                    <div class="text-gray-600">Countries</div>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-4xl font-bold text-purple-600 mb-2">4.9★</div>
                    <div class="text-gray-600">User Rating</div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-flex items-center bg-blue-100 text-blue-800 px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-lightbulb mr-2"></i> How It Works
                </span>
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Spread Joy in Just 3 Steps</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Our scientifically-proven method boosts your mood while contributing to a happier world
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-100 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="bg-blue-100 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto transform transition duration-300 hover:rotate-6">
                            <div class="bg-blue-500 w-16 h-16 rounded-xl flex items-center justify-center text-white text-3xl">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                        <span class="bg-blue-500 text-white text-lg font-bold w-8 h-8 flex items-center justify-center rounded-full">1</span>
                    </div>
                    <h3 class="text-2xl font-semibold text-center mb-3 text-gray-800">Create Your Profile</h3>
                    <p class="text-gray-600 text-center mb-4">Join our community in under 30 seconds</p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> No credit card needed
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Personalized dashboard
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Privacy first approach
                        </li>
                    </ul>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-100 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex justify-between items-start mb-4">
                        <div class="bg-purple-100 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto transform transition duration-300 hover:rotate-6">
                            <div class="bg-purple-500 w-16 h-16 rounded-xl flex items-center justify-center text-white text-3xl">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        <span class="bg-purple-500 text-white text-lg font-bold w-8 h-8 flex items-center justify-center rounded-full">2</span>
                    </div>
                    <h3 class="text-2xl font-semibold text-center mb-3 text-gray-800">Smile & Earn</h3>
                    <p class="text-gray-600 text-center mb-4">Our AI analyzes your smile in real-time</p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> 2-15 points per smile
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> 10 attempts daily
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Bonus streaks
                        </li>
                    </ul>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-100 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="bg-green-100 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto transform transition duration-300 hover:rotate-6">
                            <div class="bg-green-500 w-16 h-16 rounded-xl flex items-center justify-center text-white text-3xl">
                                <i class="fas fa-trophy"></i>
                            </div>
                        </div>
                        <span class="bg-green-500 text-white text-lg font-bold w-8 h-8 flex items-center justify-center rounded-full">3</span>
                    </div>
                    <h3 class="text-2xl font-semibold text-center mb-3 text-gray-800">Rise & Shine</h3>
                    <p class="text-gray-600 text-center mb-4">Track your progress and compete</p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Global leaderboards
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Weekly challenges
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Exclusive rewards
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">



        <section class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen py-12 px-4">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl font-bold text-center text-gray-800 mb-4">Smile Points Features</h1>
                <p class="text-lg text-center text-gray-600 mb-12">Discover exciting ways to use your smile points</p>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="feature-card border border-gray-200 p-8 rounded-2xl relative" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon-container bg-purple-100 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-gift text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold mb-3 text-gray-800">Rewards Marketplace</h3>
                        <p class="text-gray-600 mb-6">Redeem your smile points for exclusive discounts, gift cards, and donations to charity</p>
                       <button 
    class="btn-primary w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-xl"
    onclick="window.location.href='Rewards.php';"
>
    Explore Rewards
</button>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-card border border-gray-200 p-8 rounded-2xl relative" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon-container bg-blue-100 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-users text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold mb-3 text-gray-800">Team Challenges</h3>
                        <p class="text-gray-600 mb-6">Create groups with friends or coworkers and compete in weekly smile challenges</p>
                        <button class="btn-primary w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-xl">
                            Join Challenge
                        </button>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card border border-gray-200 p-8 rounded-2xl relative" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon-container bg-green-100 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-heart text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold mb-3 text-gray-800">Mood Tracking</h3>
                        <p class="text-gray-600 mb-6">Advanced analytics to track your happiness trends and personalized recommendations</p>
                        <button class="btn-primary w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-xl">
                            Track Mood
                        </button>
                    </div>
                </div>

                <div class="mt-16 text-center">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">How to Earn Smile Points</h2>
                    <div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mb-4 mx-auto">
                                <i class="fas fa-smile text-yellow-500"></i>
                            </div>
                            <h3 class="font-semibold text-lg mb-2">Complete Activities</h3>
                            <p class="text-gray-600">Earn points by completing daily smile challenges and activities</p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4 mx-auto">
                                <i class="fas fa-tasks text-red-500"></i>
                            </div>
                            <h3 class="font-semibold text-lg mb-2">Achieve Goals</h3>
                            <p class="text-gray-600">Reach your weekly goals to earn bonus smile points</p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4 mx-auto">
                                <i class="fas fa-user-friends text-indigo-500"></i>
                            </div>
                            <h3 class="font-semibold text-lg mb-2">Refer Friends</h3>
                            <p class="text-gray-600">Get points for each friend who joins using your referral code</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="mt-12 text-center" data-aos="fade-up">
            <p class="text-gray-600 mb-6">Have suggestions for features you'd love to see?</p>
            <a href="contact.php" class="inline-flex items-center border-2 border-purple-600 text-purple-600 hover:bg-purple-50 px-6 py-3 rounded-lg font-medium transition duration-300">
                <i class="far fa-lightbulb mr-2"></i> Share Your Ideas
            </a>
        </div>
        </div>
    </section>

    <!-- Enhanced Testimonial Section -->
    <section class="py-20 bg-gradient-to-br from-purple-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-flex items-center bg-pink-100 text-pink-800 px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-heart mr-2"></i> Love From Our Community
                </span>
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Real Stories, Real Smiles</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Don't just take our word for it - hear from our happy users
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-lg transition duration-300" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 text-xl mr-1">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-xs text-gray-500 ml-2">2 days ago</span>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"I started using SmilePoint during a difficult time in my life. The daily smile challenges gave me something positive to focus on. Now I'm in the top 10% globally!"</p>
                    <div class="flex items-center">
                        <img class="w-12 h-12 rounded-full mr-4" src="https://randomuser.me/api/portraits/women/32.jpg" alt="User">
                        <div>
                            <h4 class="font-semibold text-gray-800">Priya K.</h4>
                            <p class="text-sm text-gray-500">Mumbai, India</p>
                            <div class="flex mt-1">
                                <span class="bg-purple-100 text-purple-800 text-xs px-2 py-0.5 rounded-full">Top 10%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-lg transition duration-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 text-xl mr-1">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-xs text-gray-500 ml-2">1 week ago</span>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"As a teacher, I introduced SmilePoint to my students. Their engagement and classroom mood have improved dramatically. We now have weekly smile competitions!"</p>
                    <div class="flex items-center">
                        <img class="w-12 h-12 rounded-full mr-4" src="https://randomuser.me/api/portraits/men/54.jpg" alt="User">
                        <div>
                            <h4 class="font-semibold text-gray-800">Rahul S.</h4>
                            <p class="text-sm text-gray-500">Delhi, India</p>
                            <div class="flex mt-1">
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full">Educator</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-lg transition duration-300" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 text-xl mr-1">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-xs text-gray-500 ml-2">3 weeks ago</span>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"My remote team uses SmilePoint to start our meetings. It's become our digital icebreaker and has significantly improved our team's energy and connection."</p>
                    <div class="flex items-center">
                        <img class="w-12 h-12 rounded-full mr-4" src="https://randomuser.me/api/portraits/women/68.jpg" alt="User">
                        <div>
                            <h4 class="font-semibold text-gray-800">Ananya P.</h4>
                            <p class="text-sm text-gray-500">Bangalore, India</p>
                            <div class="flex mt-1">
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">Team Leader</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced CTA Section -->
    <section class="relative py-24 bg-gradient-to-r from-purple-600 to-blue-600 text-white overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-white mix-blend-overlay filter blur-3xl opacity-30 animate-blob"></div>
                <div class="absolute top-1/2 right-1/3 w-64 h-64 rounded-full bg-white mix-blend-overlay filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
                <div class="absolute bottom-1/4 left-1/2 w-64 h-64 rounded-full bg-white mix-blend-overlay filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold mb-6" data-aos="fade-up">Ready to Transform Your Mood?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto opacity-90" data-aos="fade-up" data-aos-delay="100">
                Join thousands who are boosting their happiness daily with SmilePoint
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4" data-aos="fade-up" data-aos-delay="200">
                <a href="register.php" class="bg-white text-purple-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-bold text-lg transition duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center">
                    <i class="fas fa-smile-beam mr-2"></i> Start Free Today
                </a>
                <a href="demo.php" class="border-2 border-white text-white hover:bg-white hover:bg-opacity-10 px-8 py-4 rounded-lg font-bold text-lg transition duration-300 transform hover:scale-105 flex items-center justify-center">
                    <i class="fas fa-play-circle mr-2"></i> Watch Demo
                </a>
            </div>
            <p class="mt-6 text-sm text-white/80" data-aos="fade-up" data-aos-delay="300">
                No credit card required • 7-day happiness guarantee
            </p>
        </div>
    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    });
</script>
<?php require_once 'includes/footer.php'; ?>