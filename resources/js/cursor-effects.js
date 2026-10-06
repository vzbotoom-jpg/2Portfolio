// resources/js/cursor-effects.js
//
// DISABLED: the cursor glow effect was visually interfering
// with text (overlapping headings/body copy and reducing
// readability). The class is kept here in case it's needed
// again later, but it is no longer auto-initialized.

class CursorEffects {
    constructor() {
        this.mouseX = -1000;
        this.mouseY = -1000;
        this.prevMouseX = 0;
        this.prevMouseY = 0;
        this.speedX = 0;
        this.speedY = 0;
        this.isVisible = false;
        this.isHovering = false;
        this.lastUpdate = 0;
        this.throttleMs = 16;
        this.glowElements = {};
        this.init();
    }

    init() {
        // Only initialize on non-touch devices
        if ('ontouchstart' in window && window.innerWidth < 1024) {
            return;
        }
        
        this.cacheElements();
        this.trackMouse();
        this.detectHover();
        this.handleVisibility();
        this.animateGlow();
        this.updateCSSProperties();
        
        if ('ontouchstart' in window) {
            this.handleTouch();
        }
    }
    
    cacheElements() {
        this.glowElements = {
            primary: document.getElementById('cursor-glow-primary'),
            secondary: document.getElementById('cursor-glow-secondary'),
            tertiary: document.getElementById('cursor-glow-tertiary'),
            interactive: document.getElementById('cursor-glow-interactive')
        };
    }

    trackMouse() {
        document.addEventListener('mousemove', (e) => {
            const now = Date.now();
            if (now - this.lastUpdate >= this.throttleMs) {
                this.prevMouseX = this.mouseX;
                this.prevMouseY = this.mouseY;
                this.mouseX = e.clientX;
                this.mouseY = e.clientY;
                this.speedX = this.mouseX - this.prevMouseX;
                this.speedY = this.mouseY - this.prevMouseY;
                this.isVisible = true;
                this.lastUpdate = now;
            }
        });
    }

    detectHover() {
        const hoverableElements = document.querySelectorAll(
            'a, button, [role="button"], input, textarea, select, .hoverable, [data-hoverable]'
        );

        hoverableElements.forEach(el => {
            el.addEventListener('mouseenter', () => {
                this.isHovering = true;
                document.body.style.cursor = 'pointer';
            });

            el.addEventListener('mouseleave', () => {
                this.isHovering = false;
                document.body.style.cursor = 'default';
            });
        });
    }

    handleVisibility() {
        document.addEventListener('mouseenter', () => {
            this.isVisible = true;
        });

        document.addEventListener('mouseleave', () => {
            this.isVisible = false;
        });

        // Hide after inactivity
        let inactivityTimer;
        document.addEventListener('mousemove', () => {
            clearTimeout(inactivityTimer);
            this.isVisible = true;
            
            inactivityTimer = setTimeout(() => {
                this.isVisible = false;
            }, 3000);
        });
    }

    handleTouch() {
        document.addEventListener('touchstart', (e) => {
            if (e.touches.length > 0) {
                this.mouseX = e.touches[0].clientX;
                this.mouseY = e.touches[0].clientY;
                this.isVisible = true;
            }
        }, { passive: true });

        document.addEventListener('touchmove', (e) => {
            if (e.touches.length > 0) {
                this.mouseX = e.touches[0].clientX;
                this.mouseY = e.touches[0].clientY;
            }
        }, { passive: true });

        document.addEventListener('touchend', () => {
            setTimeout(() => {
                this.isVisible = false;
            }, 1000);
        });
    }

    animateGlow() {
        const updateGlow = () => {
            const { primary, secondary, tertiary, interactive } = this.glowElements;

            if (this.isVisible) {
                // Primary glow - direct follow
                if (primary) {
                    primary.style.opacity = '1';
                    primary.style.left = this.mouseX + 'px';
                    primary.style.top = this.mouseY + 'px';
                    primary.style.transform = `translate(-50%, -50%) scale(${this.isHovering ? 1.2 : 1})`;
                }

                // Secondary glow - delayed follow
                if (secondary) {
                    const lagX = this.mouseX - this.speedX * 3;
                    const lagY = this.mouseY - this.speedY * 3;
                    secondary.style.opacity = '1';
                    secondary.style.left = lagX + 'px';
                    secondary.style.top = lagY + 'px';
                }

                // Tertiary glow - even more delayed
                if (tertiary) {
                    const lagX2 = this.mouseX - this.speedX * 6;
                    const lagY2 = this.mouseY - this.speedY * 6;
                    tertiary.style.opacity = '1';
                    tertiary.style.left = lagX2 + 'px';
                    tertiary.style.top = lagY2 + 'px';
                }

                // Interactive glow
                if (interactive) {
                    interactive.style.left = this.mouseX + 'px';
                    interactive.style.top = this.mouseY + 'px';
                    interactive.style.opacity = this.isHovering ? '1' : '0';
                    interactive.style.transform = `translate(-50%, -50%) scale(${this.isHovering ? 1.2 : 0.8})`;
                }
            } else {
                // Fade out all glows
                Object.values(this.glowElements).forEach(glow => {
                    if (glow) glow.style.opacity = '0';
                });
            }

            requestAnimationFrame(updateGlow);
        };

        requestAnimationFrame(updateGlow);
    }
    
    updateCSSProperties() {
        const update = () => {
            document.documentElement.style.setProperty('--cursor-x', this.mouseX + 'px');
            document.documentElement.style.setProperty('--cursor-y', this.mouseY + 'px');
            document.documentElement.style.setProperty('--cursor-hovering', this.isHovering ? '1' : '0');
            requestAnimationFrame(update);
        };
        
        requestAnimationFrame(update);
    }

    getPosition() {
        return {
            x: this.mouseX,
            y: this.mouseY,
            isHovering: this.isHovering,
            isVisible: this.isVisible
        };
    }
}

// DISABLED: auto-initialization removed so the glow no longer
// renders or tracks the mouse. The class above is still exported
// in case it needs to be re-enabled manually in the future.
//
// document.addEventListener('DOMContentLoaded', () => {
//     if (!('ontouchstart' in window) || window.innerWidth > 1024) {
//         window.cursorEffects = new CursorEffects();
//     }
// });

export default CursorEffects;