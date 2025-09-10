// Initialize AOS animations
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
    
    // Floating emojis animation
    if (document.getElementById('success-message')) {
        createFloatingEmojis();
    }
});

// Create floating emojis for success message
function createFloatingEmojis() {
    const emojis = ['😊', '😄', '🤩', '🥳', '🎉', '👍', '🌟'];
    const container = document.getElementById('success-message');
    
    for (let i = 0; i < 10; i++) {
        const emoji = document.createElement('span');
        emoji.textContent = emojis[Math.floor(Math.random() * emojis.length)];
        emoji.className = 'floating-emoji absolute text-2xl';
        
        // Random position
        const left = Math.random() * 100;
        const animationDuration = 2 + Math.random() * 3;
        
        emoji.style.left = `${left}%`;
        emoji.style.bottom = '0';
        emoji.style.opacity = '0';
        emoji.style.transform = 'translateY(0)';
        
        container.appendChild(emoji);
        
        // Animate
        gsap.to(emoji, {
            y: -100,
            opacity: 1,
            duration: animationDuration,
            ease: 'power1.out',
            onComplete: () => {
                gsap.to(emoji, {
                    opacity: 0,
                    duration: 0.5,
                    onComplete: () => emoji.remove()
                });
            }
        });
    }
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
        }
    });
});