// Mobile menu toggle (if needed)
document.addEventListener('DOMContentLoaded', function () {
    // Toggle mobile menu
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Confetti effect for smile success
    if (window.location.search.includes('success=1')) {
        setTimeout(() => {
            createConfetti();
        }, 1000);
    }
});

// Confetti effect
function createConfetti() {
    const confettiSettings = {
        particleCount: 100,
        spread: 70,
        origin: { y: 0.6 },
        colors: ['#8b5cf6', '#ec4899', '#f59e0b', '#10b981', '#3b82f6']
    };

    // Using a simple confetti implementation (you could use a library like canvas-confetti)
    const confettiContainer = document.createElement('div');
    confettiContainer.className = 'fixed inset-0 pointer-events-none z-50 overflow-hidden';
    document.body.appendChild(confettiContainer);

    for (let i = 0; i < confettiSettings.particleCount; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'absolute w-2 h-2 rounded-full';
        confetti.style.backgroundColor = confettiSettings.colors[Math.floor(Math.random() * confettiSettings.colors.length)];
        confetti.style.left = `${50 + (Math.random() - 0.5) * confettiSettings.spread * 2}%`;
        confetti.style.top = '60%';
        confetti.style.opacity = '0';
        confettiContainer.appendChild(confetti);

        const angle = (Math.random() - 0.5) * Math.PI * 0.5;
        const velocity = 5 + Math.random() * 5;
        const rotation = Math.random() * 360;
        const rotationSpeed = (Math.random() - 0.5) * 20;

        gsap.to(confetti, {
            y: `-=${window.innerHeight * 0.6}`,
            x: `+=${Math.sin(angle) * velocity * 50}`,
            rotation: rotation + rotationSpeed * 5,
            opacity: 1,
            duration: 2 + Math.random() * 2,
            ease: 'power1.out',
            onComplete: () => {
                confetti.remove();
                if (i === confettiSettings.particleCount - 1) {
                    confettiContainer.remove();
                }
            }
        });
    }
}