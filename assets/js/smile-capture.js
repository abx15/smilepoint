document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('capture-btn');
    const retryBtn = document.getElementById('retry-btn');
    const countdown = document.getElementById('countdown');
    const countdownNumber = document.getElementById('countdown-number');
    const resultContainer = document.getElementById('result-container');
    const smileScore = document.getElementById('smile-score');
    const smileBar = document.getElementById('smile-bar');
    const smileFeedback = document.getElementById('smile-feedback');
    const formSmileScore = document.getElementById('form-smile-score');
    const formImageData = document.getElementById('form-image-data');
    const successMessage = document.getElementById('success-message');

    // For demo purposes - in a real app you would use Face API.js or similar
    let stream = null;
    let countdownInterval = null;

    // Start camera
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
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

    // Capture button click handler
    captureBtn.addEventListener('click', function () {
        startCountdown();
    });

    // Retry button click handler
    retryBtn.addEventListener('click', function () {
        resultContainer.classList.add('hidden');
        captureBtn.classList.remove('hidden');
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
        countdown.classList.add('hidden');

        // Set canvas dimensions to match video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Draw video frame to canvas
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Stop video stream
        video.pause();
        video.srcObject = null;

        // For demo purposes - generate a random smile score 
        const randomSmileScore = Math.floor(Math.random() * 91) + 10;


        // Display results
        displayResults(randomSmileScore);

        // Convert canvas to data URL for form submission
        const imageData = canvas.toDataURL('image/png');
        formImageData.value = imageData;
        formSmileScore.value = randomSmileScore;
    }

    // Display smile detection results
    function displayResults(score) {
        resultContainer.classList.remove('hidden');
        captureBtn.classList.add('hidden');
        retryBtn.classList.remove('hidden');

        // Animate score display
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

            // Update feedback based on score
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
                smileBar.className = "bg-gray-400 h-4 rounded-full";
            }

        }, 20);
    }

    // Hide success message after 5 seconds
    if (successMessage) {
        setTimeout(() => {
            successMessage.classList.add('hidden');
        }, 5000);
    }

    // Clean up camera stream when leaving page
    window.addEventListener('beforeunload', function () {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    });
});

async function analyzeSmile(canvas) {
    try {
        // Load models if not already loaded
        await faceapi.nets.tinyFaceDetector.loadFromUri('/models');
        await faceapi.nets.faceLandmark68Net.loadFromUri('/models');
        await faceapi.nets.faceExpressionNet.loadFromUri('/models');

        const detections = await faceapi.detectAllFaces(
            canvas,
            new faceapi.TinyFaceDetectorOptions()
        ).withFaceLandmarks().withFaceExpressions();

        let score = 30; // Default score

        if (detections.length > 0) {
            const expressions = detections[0].expressions;
            const smileConfidence = expressions.happy;
            score = Math.min(100, Math.floor(smileConfidence * 100) + 20);
        }

        displayResults(score);
    } catch (error) {
        console.error("Face detection error:", error);
        // Fallback to basic detection
        const brightness = calculateAverageBrightness(
            canvas.getContext('2d').getImageData(0, 0, canvas.width, canvas.height)
        );
        const adjustedScore = brightness > 160 ?
            Math.floor(Math.random() * 21) + 80 :
            Math.floor(Math.random() * 50) + 30;
        displayResults(adjustedScore);
    }
}