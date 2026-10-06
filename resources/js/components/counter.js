// resources/js/components/counter.js

/**
 * Animated Counter
 */
class AnimatedCounter {
    constructor() {
        this.counters = [];
        this.observer = null;
        this.init();
    }
    
    init() {
        this.counters = Array.from(document.querySelectorAll('[data-counter]'));
        
        if (this.counters.length === 0) return;
        
        this.createObserver();
    }
    
    createObserver() {
        this.observer = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        this.animateCounter(counter);
                        this.observer.unobserve(counter);
                    }
                });
            },
            {
                threshold: 0.5,
                rootMargin: '0px'
            }
        );
        
        this.counters.forEach(counter => this.observer.observe(counter));
    }
    
    animateCounter(element) {
        const target = parseInt(element.dataset.counter);
        const duration = parseInt(element.dataset.duration) || 2000;
        const prefix = element.dataset.prefix || '';
        const suffix = element.dataset.suffix || '';
        const separator = element.dataset.separator || '';
        
        if (isNaN(target)) return;
        
        const startTime = performance.now();
        const startValue = 0;
        
        const update = (currentTime) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Ease out cubic for smooth deceleration
            const easeProgress = 1 - Math.pow(1 - progress, 3);
            
            const currentValue = Math.floor(startValue + (target - startValue) * easeProgress);
            
            // Format number with separator
            let displayValue = currentValue.toString();
            if (separator) {
                displayValue = currentValue.toLocaleString();
            }
            
            element.textContent = `${prefix}${displayValue}${suffix}`;
            
            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                // Final value
                let finalValue = target.toString();
                if (separator) {
                    finalValue = target.toLocaleString();
                }
                element.textContent = `${prefix}${finalValue}${suffix}`;
                
                // Dispatch event
                element.dispatchEvent(new CustomEvent('counter-complete', {
                    detail: { value: target }
                }));
            }
        };
        
        requestAnimationFrame(update);
    }
    
    reset() {
        this.counters.forEach(counter => {
            counter.textContent = '0';
        });
        
        if (this.observer) {
            this.observer.disconnect();
        }
        
        this.createObserver();
    }
    
    destroy() {
        if (this.observer) {
            this.observer.disconnect();
        }
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    window.animatedCounter = new AnimatedCounter();
});

export default AnimatedCounter;