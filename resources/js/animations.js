// resources/js/animations.js

/**
 * AOS-like animation system for scroll-triggered animations
 */
class ScrollAnimator {
    constructor() {
        this.elements = [];
        this.observer = null;
        this.init();
    }
    
    init() {
        // Find all elements with data-animate attribute
        this.elements = Array.from(document.querySelectorAll('[data-animate]'));
        
        if (this.elements.length === 0) return;
        
        // Set initial state
        this.elements.forEach(el => {
            el.style.opacity = '0';
            el.style.willChange = 'transform, opacity';
        });
        
        // Create intersection observer
        this.observer = new IntersectionObserver(
            (entries) => this.handleIntersection(entries),
            {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            }
        );
        
        // Observe elements
        this.elements.forEach(el => this.observer.observe(el));
    }
    
    handleIntersection(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const animation = el.dataset.animate || 'fade-in-up';
                const delay = el.dataset.animateDelay || 0;
                const duration = el.dataset.animateDuration || 800;
                
                // Apply animation
                setTimeout(() => {
                    el.style.animation = `${animation} ${duration}ms ease-out forwards`;
                    el.style.opacity = '';
                    el.style.willChange = '';
                }, delay);
                
                // Stop observing after animation
                if (!el.dataset.animateRepeat) {
                    this.observer.unobserve(el);
                }
            }
        });
    }
    
    destroy() {
        if (this.observer) {
            this.observer.disconnect();
        }
    }
}

/**
 * Parallax Manager
 */
class ParallaxManager {
    constructor() {
        this.elements = [];
        this.init();
    }
    
    init() {
        this.elements = Array.from(document.querySelectorAll('[data-parallax]'));
        
        if (this.elements.length === 0) return;
        
        this.handleScroll = this.handleScroll.bind(this);
        window.addEventListener('scroll', this.handleScroll, { passive: true });
    }
    
    handleScroll() {
        const scrolled = window.pageYOffset;
        
        this.elements.forEach(el => {
            const speed = parseFloat(el.dataset.parallax) || 0.5;
            const yPos = -(scrolled * speed);
            el.style.transform = `translate3d(0, ${yPos}px, 0)`;
        });
    }
    
    destroy() {
        window.removeEventListener('scroll', this.handleScroll);
    }
}

/**
 * Reveal on scroll
 */
class RevealOnScroll {
    constructor() {
        this.elements = [];
        this.init();
    }
    
    init() {
        this.elements = Array.from(document.querySelectorAll('[data-reveal]'));
        
        if (this.elements.length === 0) return;
        
        // Set initial state
        this.elements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
        });
        
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const delay = el.dataset.revealDelay || 0;
                        
                        setTimeout(() => {
                            el.style.opacity = '1';
                            el.style.transform = 'translateY(0)';
                        }, delay);
                        
                        observer.unobserve(el);
                    }
                });
            },
            {
                threshold: 0.15,
                rootMargin: '0px 0px -30px 0px'
            }
        );
        
        this.elements.forEach(el => observer.observe(el));
    }
}

/**
 * Text scramble effect
 */
class TextScramble {
    constructor(element) {
        this.element = element;
        this.chars = '!<>-_\\/[]{}—=+*^?#________';
        this.originalText = element.textContent;
        this.interval = null;
    }
    
    scramble() {
        let iteration = 0;
        const maxIterations = 10;
        
        clearInterval(this.interval);
        
        this.interval = setInterval(() => {
            this.element.textContent = this.originalText
                .split('')
                .map((char, index) => {
                    if (index < iteration) {
                        return this.originalText[index];
                    }
                    return this.chars[Math.floor(Math.random() * this.chars.length)];
                })
                .join('');
            
            iteration += 1 / 3;
            
            if (iteration >= this.originalText.length) {
                clearInterval(this.interval);
                this.element.textContent = this.originalText;
            }
        }, 50);
    }
}

/**
 * Initialize all animations
 */
document.addEventListener('DOMContentLoaded', () => {
    // Initialize scroll animator
    window.scrollAnimator = new ScrollAnimator();
    
    // Initialize parallax
    window.parallaxManager = new ParallaxManager();
    
    // Initialize reveal on scroll
    window.revealOnScroll = new RevealOnScroll();
    
    // Initialize text scramble on hover
    document.querySelectorAll('[data-scramble]').forEach(el => {
        const scrambler = new TextScramble(el);
        
        el.addEventListener('mouseenter', () => scrambler.scramble());
    });
});

// Export classes for use in other modules
export { ScrollAnimator, ParallaxManager, RevealOnScroll, TextScramble };