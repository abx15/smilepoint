// assets/js/smile-demo.js
document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('demo-video');
    const canvas = document.getElementById('demo-canvas');
    const captureBtn = document.getElementById('demo-capture-btn');
    const countdown = document.getElementById('demo-countdown');
    const countdownNumber = document.getElementById('demo-countdown-number');
    const resultContainer = document.getElementById('demo-result-container');
    const instructions = document.getElementById('demo-instructions');
    const smileScore = document.getElementById('demo-smile-score');
    const smileBar = document.getElementById('demo-smile-bar');
    const smileFeedback = document.getElementById('demo-smile-feedback');
    const tryAgainBtn = document.getElementById('demo-try-again-btn');

    let stream = null;
    let countdownInterval = null;

    // Start camera
    function startCamera() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({
                video: {
                    width: 640,
                    height: 480,
                    facingMode: 'user' // Front camera
                }
            })
                .then(function (mediaStream) {
                    stream = mediaStream;
                    video.srcObject = mediaStream;
                    video.play();
                })
                .catch(function (error) {
                    console.error("Camera error: ", error);
                    alert("Could not access the camera. Please make sure you've granted camera permissions.");
                });
        } else {
            alert("Sorry, your browser doesn't support camera access.");
        }
    }

    // Initialize camera
    startCamera();

    // Capture button click handler
    captureBtn.addEventListener('click', function () {
        startCountdown();
    });

    // Try again button click handler
    tryAgainBtn.addEventListener('click', function () {
        resultContainer.classList.add('hidden');
        instructions.classList.remove('hidden');
        video.srcObject = stream;
        video.play();
    });

    // Start countdown
    function startCountdown() {
        captureBtn.disabled = true;
        countdown.classList.remove('hidden');
        let count = 3;

        countdownInterval = setInterval(() => {
            countdownNumber.textContent = count;

            if (count === 0) {
                clearInterval(countdownInterval);
                captureImage();
                return;
            }

            count--;
        }, 1000);
    }

    // Capture image from video
    function captureImage() {
        try {
            // Hide countdown
            countdown.classList.add('hidden');

            // Set canvas dimensions to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Get canvas context once
            const context = canvas.getContext('2d');

            // Draw video frame to canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Stop video stream
            if (video.srcObject) {
                video.pause();
                video.srcObject = null;
            }

            // Analyze the image for smile detection
            analyzeSmile(canvas);
        } catch (error) {
            console.error("Error capturing image:", error);
            // Fallback to basic detection if face API fails
            const brightness = calculateAverageBrightness(
                canvas.getContext('2d').getImageData(0, 0, canvas.width, canvas.height)
            );
            const adjustedScore = brightness > 160 ?
                Math.floor(Math.random() * 21) + 80 :
                Math.floor(Math.random() * 50) + 30;
            displayResults(adjustedScore);

            // Reset camera
            video.srcObject = stream;
            video.play();
        }
    }

    // Analyze the captured image for smile detection
    function analyzeSmile(canvas) {
        const context = canvas.getContext('2d');
        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);

        // Calculate average brightness
        const brightness = calculateAverageBrightness(imageData);

        // Determine if the user is smiling based on brightness
        // You can adjust this threshold based on your tests
        let score;

        if (brightness > 200) {
            // Very bright - strong smile
            score = Math.floor(Math.random() * 11) + 90; // 90–100
        } else if (brightness > 180) {
            score = Math.floor(Math.random() * 11) + 80; // 80–90
        } else if (brightness > 160) {
            score = Math.floor(Math.random() * 11) + 70; // 70–80
        } else if (brightness > 130) {
            score = Math.floor(Math.random() * 11) + 50; // 50–60
        } else if (brightness > 100) {
            score = Math.floor(Math.random() * 11) + 30; // 30–40
        } else {
            // Very dark - likely no smile
            score = Math.floor(Math.random() * 21) + 10; // 10–30
        }

        displayResults(score);
    }


    function calculateAverageBrightness(imageData) {
        let sum = 0;
        const data = imageData.data;
        let count = 0;

        // Sample every 16th pixel (i += 4 * 16)
        for (let i = 0; i < data.length; i += 64) {
            const r = data[i];
            const g = data[i + 1];
            const b = data[i + 2];

            // Average RGB
            const brightness = (r + g + b) / 3;
            sum += brightness;
            count++;
        }

        return Math.floor(sum / count);
    }

    function displayResults(score) {
        resultContainer.classList.remove('hidden');
        instructions.classList.add('hidden');
        captureBtn.disabled = false;

        let currentScore = 0;

        const scoreInterval = setInterval(() => {
            if (currentScore >= score) {
                clearInterval(scoreInterval);
                currentScore = score;
            } else {
                currentScore += 2;
            }

            smileScore.textContent = currentScore + '%';
            smileBar.style.width = currentScore + '%';

            // Update feedback and bar color based on currentScore
            if (currentScore >= 90) {
                smileFeedback.textContent = "Incredible! You light up the room! 🌟";
                smileBar.className = "bg-green-600 h-4 rounded-full";
            } else if (currentScore >= 80) {
                smileFeedback.textContent = "Wow! That's an amazing smile! 😍";
                smileBar.className = "bg-green-500 h-4 rounded-full";
            } else if (currentScore >= 70) {
                smileFeedback.textContent = "Great smile! Keep it up! 😊";
                smileBar.className = "bg-emerald-500 h-4 rounded-full";
            } else if (currentScore >= 60) {
                smileFeedback.textContent = "Nice! You're almost there! 😁";
                smileBar.className = "bg-blue-500 h-4 rounded-full";
            } else if (currentScore >= 50) {
                smileFeedback.textContent = "Good effort! Smile a bit more! 🙂";
                smileBar.className = "bg-yellow-400 h-4 rounded-full";
            } else if (currentScore >= 40) {
                smileFeedback.textContent = "Getting better! Try again! 😅";
                smileBar.className = "bg-orange-400 h-4 rounded-full";
            } else if (currentScore >= 30) {
                smileFeedback.textContent = "You're halfway there! 😐";
                smileBar.className = "bg-orange-500 h-4 rounded-full";
            } else if (currentScore >= 20) {
                smileFeedback.textContent = "Almost a smile! Let's go! 😬";
                smileBar.className = "bg-red-400 h-4 rounded-full";
            } else if (currentScore >= 10) {
                smileFeedback.textContent = "Don't be shy, give us a smile! 😶";
                smileBar.className = "bg-red-500 h-4 rounded-full";
            } else {
                smileFeedback.textContent = "Hmm… no smile detected! Try again! 😕";
                smileBar.className = "bg-gray-500 h-4 rounded-full";
            }
        }, 20);
    }

    // Clean up camera stream when leaving page
    window.addEventListener('beforeunload', function () {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    });
});

