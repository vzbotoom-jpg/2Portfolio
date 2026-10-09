// resources/js/app.js

import './animations';
import './cursor-effects';
import './navigation';

// Alpine.js + Plugins (import via Vite to avoid duplicate CDN instances)
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import focus from '@alpinejs/focus';

Alpine.plugin(intersect);
Alpine.plugin(focus);
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('submit', event => {
    if (!(event.target instanceof HTMLFormElement) || !event.target.matches('[data-logout-trigger]')) {
        return;
    }

    if (!window.Alpine || !document.querySelector('[data-logout-modal]')) {
        return;
    }

    event.preventDefault();
    window.dispatchEvent(new CustomEvent('open-logout-modal'));
});

/**
 * Main Application Initialization
 */
document.addEventListener('DOMContentLoaded', () => {
    initApp();
});

function initApp() {
    // removeLoader() disabled — the page loader is now fully
    // controlled by Alpine.js (x-data/x-init) in app.blade.php.
    // Running both at once caused conflicting removal logic and
    // contributed to the loader feeling slower than it should.
    // removeLoader();
    
    // Initialize components
    initBackToTop();
    initSmoothScroll();
    initLazyLoading();
    initParallaxEffects();
    initCounterAnimations();
    initFormValidation();
    
    // Log app info
    logAppInfo();
}

/**
 * Remove page loader
 */
function removeLoader() {
    const loader = document.getElementById('page-loader');
    if (!loader) return;

    const hideLoader = () => {
        // No artificial delay — hide as soon as the page is actually
        // ready. The CSS transition (see head.blade.php / app.css,
        // shortened to ~250ms) provides the only visible animation,
        // so loader duration now tracks real network/load speed.
        loader.classList.add('hidden');
        loader.addEventListener('transitionend', () => loader.remove(), { once: true });
        // Fallback in case transitionend doesn't fire (e.g. display:none elsewhere)
        setTimeout(() => loader.remove(), 300);
    };

    if (document.readyState === 'complete') {
        // Page already finished loading (fast connection / cached
        // assets) by the time this script runs — skip waiting for
        // the 'load' event entirely.
        hideLoader();
    } else {
        window.addEventListener('load', hideLoader, { once: true });
    }
}

/**
 * Back to top button
 */
function initBackToTop() {
    const backToTopBtn = document.getElementById('back-to-top');
    
    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 500) {
                backToTopBtn.classList.add('!opacity-100', '!visible');
            } else {
                backToTopBtn.classList.remove('!opacity-100', '!visible');
            }
        });
        
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

/**
 * Smooth scroll for anchor links
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                
                const headerOffset = 100;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                // Update URL
                history.pushState(null, null, href);
            }
        });
    });
}

/**
 * Lazy loading images
 */
function initLazyLoading() {
    if ('loading' in HTMLImageElement.prototype) {
        // Browser supports native lazy loading
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');
        lazyImages.forEach(img => {
            if (img.dataset.src) {
                img.src = img.dataset.src;
            }
        });
    } else {
        // Fallback for browsers without native lazy loading
        const lazyImages = document.querySelectorAll('img[loading="lazy"], img[data-src]');
        
        if (lazyImages.length === 0) return;
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });
        
        lazyImages.forEach(img => imageObserver.observe(img));
    }
}

/**
 * Parallax effects
 */
function initParallaxEffects() {
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    
    if (parallaxElements.length === 0) return;
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        
        parallaxElements.forEach(element => {
            const speed = element.dataset.parallax || 0.5;
            const yPos = -(scrolled * speed);
            element.style.transform = `translate3d(0, ${yPos}px, 0)`;
        });
    });
}

/**
 * Counter animations
 */
function initCounterAnimations() {
    const counterElements = document.querySelectorAll('[data-counter]');
    
    if (counterElements.length === 0) return;
    
    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.dataset.counter);
                const duration = parseInt(counter.dataset.duration) || 2000;
                const prefix = counter.dataset.prefix || '';
                const suffix = counter.dataset.suffix || '';
                
                animateCounter(counter, target, duration, prefix, suffix);
                counterObserver.unobserve(counter);
            }
        });
    }, {
        threshold: 0.5
    });
    
    counterElements.forEach(counter => counterObserver.observe(counter));
}

function animateCounter(element, target, duration, prefix, suffix) {
    const startTime = performance.now();
    const startValue = 0;
    
    function update(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        // Ease out cubic
        const easeProgress = 1 - Math.pow(1 - progress, 3);
        
        const currentValue = Math.floor(startValue + (target - startValue) * easeProgress);
        
        element.textContent = `${prefix}${currentValue}${suffix}`;
        
        if (progress < 1) {
            requestAnimationFrame(update);
        } else {
            element.textContent = `${prefix}${target}${suffix}`;
        }
    }
    
    requestAnimationFrame(update);
}

/**
 * Form validation
 */
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Real-time validation on blur
            input.addEventListener('blur', () => {
                validateField(input);
            });
            
            // Clear validation on input
            input.addEventListener('input', () => {
                if (input.classList.contains('error')) {
                    input.classList.remove('error');
                    const errorMsg = input.parentElement.querySelector('.form-error-message');
                    if (errorMsg) errorMsg.remove();
                }
            });
        });
        
        // Form submission
        form.addEventListener('submit', (e) => {
            let isValid = true;
            
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    // Remove existing error messages
    const existingError = field.parentElement.querySelector('.form-error-message');
    if (existingError) existingError.remove();
    
    field.classList.remove('error', 'success');
    
    // Required validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'This field is required';
    }
    
    // Email validation
    if (field.type === 'email' && value && !isValidEmail(value)) {
        isValid = false;
        errorMessage = 'Please enter a valid email address';
    }
    
    // Min length validation
    const minLength = field.dataset.minLength;
    if (minLength && value.length < parseInt(minLength)) {
        isValid = false;
        errorMessage = `Minimum ${minLength} characters required`;
    }
    
    // Max length validation
    const maxLength = field.dataset.maxLength;
    if (maxLength && value.length > parseInt(maxLength)) {
        isValid = false;
        errorMessage = `Maximum ${maxLength} characters allowed`;
    }
    
    // Pattern validation
    const pattern = field.dataset.pattern;
    if (pattern && value && !new RegExp(pattern).test(value)) {
        isValid = false;
        errorMessage = field.dataset.patternError || 'Invalid format';
    }
    
    // Show validation state
    if (!isValid) {
        field.classList.add('error');
        
        const errorElement = document.createElement('span');
        errorElement.className = 'form-error-message';
        errorElement.textContent = errorMessage;
        field.parentElement.appendChild(errorElement);
    } else if (value) {
        field.classList.add('success');
    }
    
    return isValid;
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Log app information
 */
function logAppInfo() {
    const style = 'font-size: 14px; padding: 8px 12px; border-radius: 4px;';
    
    console.log(
        `%c🚀 Portfolio App %c v1.0.0`,
        `${style} background: #000; color: #fff; font-weight: bold;`,
        `${style} background: #333; color: #fff;`
    );
    
    console.log(
        '%cBuilt with Laravel + Tailwind CSS v4',
        'font-size: 12px; color: #888;'
    );
}

/**
 * Debounce utility
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Throttle utility
 */
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Export utilities for use in other modules
export { debounce, throttle, isValidEmail, validateField };