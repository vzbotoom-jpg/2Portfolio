// resources/js/navigation.js

/**
 * Navigation Manager
 */
class NavigationManager {
    constructor() {
        this.navbar = document.querySelector('nav');
        this.lastScroll = 0;
        this.scrollThreshold = 50;
        this.init();
    }
    
    init() {
        if (!this.navbar) return;
        
        this.handleScroll = this.handleScroll.bind(this);
        this.handleResize = this.handleResize.bind(this);
        
        window.addEventListener('scroll', this.handleScroll, { passive: true });
        window.addEventListener('resize', this.handleResize);
        
        // Initial check
        this.handleScroll();
    }
    
    handleScroll() {
        const currentScroll = window.pageYOffset;
        
        // Add/remove background on scroll
        if (currentScroll > this.scrollThreshold) {
            this.navbar.classList.add('bg-black/90', 'backdrop-blur-xl');
            this.navbar.classList.remove('bg-transparent');
        } else {
            this.navbar.classList.remove('bg-black/90', 'backdrop-blur-xl');
            this.navbar.classList.add('bg-transparent');
        }
        
        this.lastScroll = currentScroll;
    }
    
    handleResize() {
        // Handle responsive navigation
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu && window.innerWidth >= 1024) {
            mobileMenu.classList.add('hidden');
        }
    }
    
    destroy() {
        window.removeEventListener('scroll', this.handleScroll);
        window.removeEventListener('resize', this.handleResize);
    }
}

/**
 * Mobile Menu Manager
 */
class MobileMenuManager {
    constructor() {
        this.menuButton = document.querySelector('[data-mobile-menu-toggle]');
        this.menu = document.getElementById('mobile-menu');
        this.isOpen = false;
        this.init();
    }
    
    init() {
        if (!this.menuButton || !this.menu) return;
        
        this.menuButton.addEventListener('click', () => this.toggleMenu());
        
        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.closeMenu();
            }
        });
        
        // Close on click outside
        document.addEventListener('click', (e) => {
            if (this.isOpen && !this.menu.contains(e.target) && !this.menuButton.contains(e.target)) {
                this.closeMenu();
            }
        });
        
        // Close on link click
        this.menu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => this.closeMenu());
        });
    }
    
    toggleMenu() {
        if (this.isOpen) {
            this.closeMenu();
        } else {
            this.openMenu();
        }
    }
    
    openMenu() {
        this.isOpen = true;
        this.menu.classList.remove('hidden');
        this.menuButton.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }
    
    closeMenu() {
        this.isOpen = false;
        this.menu.classList.add('hidden');
        this.menuButton.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }
}

/**
 * Active link highlighter
 */
class ActiveLinkHighlighter {
    constructor() {
        this.links = document.querySelectorAll('nav a[href]');
        this.init();
    }
    
    init() {
        if (this.links.length === 0) return;
        
        this.highlightActiveLink();
        
        // Re-check on popstate (browser back/forward)
        window.addEventListener('popstate', () => this.highlightActiveLink());
    }
    
    highlightActiveLink() {
        const currentPath = window.location.pathname;
        
        this.links.forEach(link => {
            const linkPath = new URL(link.href, window.location.origin).pathname;
            
            // Remove active classes
            link.classList.remove('text-white');
            link.classList.add('text-white/70');
            
            // Remove underline
            const underline = link.querySelector('.nav-underline');
            if (underline) {
                underline.classList.add('scale-x-0');
                underline.classList.remove('scale-x-100');
            }
            
            // Check if active
            if (currentPath === linkPath || 
                (linkPath !== '/' && currentPath.startsWith(linkPath))) {
                link.classList.add('text-white');
                link.classList.remove('text-white/70');
                
                if (underline) {
                    underline.classList.remove('scale-x-0');
                    underline.classList.add('scale-x-100');
                }
            }
        });
    }
}

/**
 * Dropdown Manager
 */
class DropdownManager {
    constructor() {
        this.dropdowns = document.querySelectorAll('[data-dropdown]');
        this.init();
    }
    
    init() {
        this.dropdowns.forEach(dropdown => {
            const trigger = dropdown.querySelector('[data-dropdown-trigger]');
            const menu = dropdown.querySelector('[data-dropdown-menu]');
            
            if (!trigger || !menu) return;
            
            let timeout;
            
            trigger.addEventListener('mouseenter', () => {
                clearTimeout(timeout);
                this.openDropdown(menu);
            });
            
            trigger.addEventListener('mouseleave', () => {
                timeout = setTimeout(() => {
                    this.closeDropdown(menu);
                }, 200);
            });
            
            menu.addEventListener('mouseenter', () => {
                clearTimeout(timeout);
            });
            
            menu.addEventListener('mouseleave', () => {
                timeout = setTimeout(() => {
                    this.closeDropdown(menu);
                }, 200);
            });
            
            // Keyboard navigation
            trigger.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.toggleDropdown(menu);
                }
            });
        });
    }
    
    openDropdown(menu) {
        menu.classList.remove('hidden', 'opacity-0', '-translate-y-2');
        menu.classList.add('opacity-100', 'translate-y-0');
        menu.setAttribute('aria-hidden', 'false');
    }
    
    closeDropdown(menu) {
        menu.classList.add('hidden', 'opacity-0', '-translate-y-2');
        menu.classList.remove('opacity-100', 'translate-y-0');
        menu.setAttribute('aria-hidden', 'true');
    }
    
    toggleDropdown(menu) {
        if (menu.classList.contains('hidden')) {
            this.openDropdown(menu);
        } else {
            this.closeDropdown(menu);
        }
    }
}

/**
 * Initialize all navigation components
 */
document.addEventListener('DOMContentLoaded', () => {
    // Initialize navigation manager
    window.navigationManager = new NavigationManager();
    
    // Initialize mobile menu
    window.mobileMenuManager = new MobileMenuManager();
    
    // Initialize active link highlighter
    window.activeLinkHighlighter = new ActiveLinkHighlighter();
    
    // Initialize dropdown manager
    window.dropdownManager = new DropdownManager();
});

export { NavigationManager, MobileMenuManager, ActiveLinkHighlighter, DropdownManager };