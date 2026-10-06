// resources/js/components/parallax.js

/**
 * Advanced Parallax Effects
 */
class ParallaxEffect {
    constructor() {
        this.elements = [];
        this.init();
    }
    
    init() {
        this.elements = Array.from(document.querySelectorAll('[data-parallax]'));
        
        if (this.elements.length === 0) return;
        
        this.handleScroll = this.handleScroll.bind(this);
        this.handleMouseMove = this.handleMouseMove.bind(this);
        
        window.addEventListener('scroll', this.handleScroll, { passive: true });
        window.addEventListener('mousemove', this.handleMouseMove, { passive: true });
    }
    
    handleScroll() {
        const scrolled = window.pageYOffset;
        
        this.elements.forEach(el => {
            const speed = parseFloat(el.dataset.parallaxSpeed) || 0.5;
            const direction = el.dataset.parallaxDirection || 'vertical';
            const yPos = -(scrolled * speed);
            
            if (direction === 'horizontal') {
                el.style.transform = `translate3d(${yPos}px, 0, 0)`;
            } else if (direction === 'diagonal') {
                el.style.transform = `translate3d(${yPos * 0.5}px, ${yPos}px, 0)`;
            } else {
                el.style.transform = `translate3d(0, ${yPos}px, 0)`;
            }
        });
    }
    
    handleMouseMove(e) {
        this.elements.forEach(el => {
            if (el.dataset.parallaxMouse !== 'true') return;
            
            const mouseX = e.clientX;
            const mouseY = e.clientY;
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            
            const moveX = (mouseX - windowWidth / 2) / windowWidth * 20;
            const moveY = (mouseY - windowHeight / 2) / windowHeight * 20;
            
            const currentTransform = el.style.transform || '';
            const baseTransform = currentTransform.match(/translate3d\(([^)]+)\)/);
            
            if (baseTransform) {
                el.style.transform = `translate3d(${moveX}px, ${moveY}px, 0) ${currentTransform.replace(/translate3d\([^)]+\)/, '')}`;
            } else {
                el.style.transform += ` translate3d(${moveX}px, ${moveY}px, 0)`;
            }
        });
    }
    
    destroy() {
        window.removeEventListener('scroll', this.handleScroll);
        window.removeEventListener('mousemove', this.handleMouseMove);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    window.parallaxEffect = new ParallaxEffect();
});

export default ParallaxEffect;