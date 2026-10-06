{{-- resources/views/layouts/partials/scripts.blade.php --}}

{{-- ============================================ --}}
{{-- CORE JAVASCRIPT FILES --}}
{{-- ============================================ --}}
@vite([
    'resources/js/app.js',
    'resources/js/animations.js',
    'resources/js/cursor-effects.js',
    'resources/js/navigation.js'
])

{{-- ============================================ --}}
{{-- PAGE-SPECIFIC SCRIPTS --}}
{{-- ============================================ --}}

{{-- Home Page Scripts --}}
@if(request()->routeIs('home'))
    @vite([
        'resources/js/components/parallax.js',
        'resources/js/components/counter.js'
    ])
@endif

{{-- Contact Page Scripts --}}
@if(request()->routeIs('contact.*'))
    @vite([
        'resources/js/components/form-validation.js'
    ])
@endif

{{-- Projects Page Scripts --}}
@if(request()->routeIs('projects.*'))
    {{-- Additional project page scripts can be added here --}}
@endif

{{-- ============================================ --}}
{{-- THIRD-PARTY LIBRARIES (CDN) --}}
{{-- ============================================ --}}

{{-- Alpine is loaded via Vite bundle (imported in resources/js/app.js) to ensure
    plugins are registered consistently and avoid duplicate instances from CDN. --}}

{{-- AOS (Animate on Scroll) --}}
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50,
            disable: 'mobile'
        });
    });
</script>

{{-- Particles.js (Hanya untuk halaman home jika diaktifkan) --}}
@if(request()->routeIs('home') && isset($heroData['particles']) && $heroData['particles'])
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
@endif

{{-- ============================================ --}}
{{-- STRUCTURED DATA (SCHEMA.ORG) --}}
{{-- ============================================ --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Person",
    "name": "{{ config('portfolio.author', 'Your Name') }}",
    "url": "{{ url('/') }}",
    "image": "{{ asset('images/about/profile.webp') }}",
    "jobTitle": "Full-Stack Developer",
    "description": "{{ config('portfolio.seo.default_description', 'Full-Stack Developer Portfolio') }}",
    "sameAs": [
        "https://github.com/yourusername",
        "https://linkedin.com/in/yourusername",
        "https://twitter.com/yourusername"
    ],
    "knowsAbout": [
        "Web Development",
        "Laravel",
        "Vue.js",
        "React",
        "Node.js",
        "UI/UX Design"
    ]
}
</script>

{{-- ============================================ --}}
{{-- GOOGLE ANALYTICS --}}
{{-- ============================================ --}}
@php
    $googleAnalyticsId = config('services.google.analytics_id');
    $isValidAnalyticsId = $googleAnalyticsId
        && $googleAnalyticsId !== 'UA-XXXXXXXXX-X'
        && Str::startsWith($googleAnalyticsId, ['UA-', 'G-']);
@endphp

@if($isValidAnalyticsId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', '{{ $googleAnalyticsId }}', {
            'anonymize_ip': true,
            'cookie_flags': 'SameSite=None;Secure'
        });
    </script>
@endif

{{-- Google Tag Manager (Optional) --}}
@php
    $gtmId = config('services.google.tag_manager_id');
@endphp
@if($gtmId && $gtmId !== 'GTM-XXXXXXX')
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '{{ $gtmId }}');
    </script>
@endif

{{-- ============================================ --}}
{{-- PERFORMANCE MONITORING --}}
{{-- ============================================ --}}
<script>
    (function () {
        // Track page load performance
        window.addEventListener('load', function () {
            if (window.performance && window.performance.getEntriesByType) {
                var navigationEntries = performance.getEntriesByType('navigation');
                if (navigationEntries.length > 0) {
                    var navigation = navigationEntries[0];
                    var loadTime = navigation.loadEventEnd - navigation.startTime;
                    console.log('%c\u23F1 Page Load Time: ' + loadTime.toFixed(2) + 'ms', 'color: #888;');
                }
            }
        });

        // Track First Contentful Paint
        if (window.PerformanceObserver) {
            try {
                var paintObserver = new PerformanceObserver(function (list) {
                    var entries = list.getEntries();
                    for (var i = 0; i < entries.length; i++) {
                        if (entries[i].name === 'first-contentful-paint') {
                            console.log('%c\u{1F3A8} First Contentful Paint: ' + entries[i].startTime.toFixed(2) + 'ms', 'color: #888;');
                        }
                    }
                });
                paintObserver.observe({ entryTypes: ['paint'] });
            } catch (e) {
                // PerformanceObserver not supported
            }
        }

        // Track Largest Contentful Paint
        if (window.PerformanceObserver) {
            try {
                var lcpObserver = new PerformanceObserver(function (list) {
                    var entries = list.getEntries();
                    var lastEntry = entries[entries.length - 1];
                    if (lastEntry) {
                        console.log('%c\u{1F4CA} Largest Contentful Paint: ' + lastEntry.startTime.toFixed(2) + 'ms', 'color: #888;');
                    }
                });
                lcpObserver.observe({ entryTypes: ['largest-contentful-paint'] });
            } catch (e) {
                // PerformanceObserver not supported
            }
        }
    })();
</script>

{{-- ============================================ --}}
{{-- LAZY LOADING IMAGES --}}
{{-- ============================================ --}}
<script>
    (function () {
        document.addEventListener('DOMContentLoaded', function () {
            var lazyImages = document.querySelectorAll('img[loading="lazy"], img[data-src]');

            if (lazyImages.length === 0) return;

            // Check for native lazy loading support
            if ('loading' in HTMLImageElement.prototype) {
                lazyImages.forEach(function (img) {
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                    }
                });
            } else {
                // Fallback with Intersection Observer
                var lazyImageObserver = new IntersectionObserver(function (entries, observer) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            var img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.removeAttribute('data-src');
                            }
                            img.classList.remove('lazy');
                            lazyImageObserver.unobserve(img);
                        }
                    });
                }, {
                    rootMargin: '50px 0px',
                    threshold: 0.01
                });

                lazyImages.forEach(function (img) {
                    lazyImageObserver.observe(img);
                });
            }
        });
    })();
</script>

{{-- ============================================ --}}
{{-- SMOOTH SCROLL FOR ANCHOR LINKS --}}
{{-- ============================================ --}}
<script>
    (function () {
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
                anchor.addEventListener('click', function (e) {
                    var href = this.getAttribute('href');

                    // Skip if it's just "#" or empty
                    if (href === '#' || href === '#!' || !href) return;

                    var target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();

                        var headerOffset = 100;
                        var elementPosition = target.getBoundingClientRect().top;
                        var offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });

                        // Update URL without page reload
                        if (history.pushState) {
                            history.pushState(null, null, href);
                        }
                    }
                });
            });
        });
    })();
</script>

{{-- ============================================ --}}
{{-- BACK TO TOP BUTTON --}}
{{-- ============================================ --}}
<script>
    (function () {
        document.addEventListener('DOMContentLoaded', function () {
            var backToTopBtn = document.getElementById('back-to-top');

            if (!backToTopBtn) return;

            window.addEventListener('scroll', function () {
                if (window.scrollY > 500) {
                    backToTopBtn.classList.add('!opacity-100', '!visible');
                    backToTopBtn.classList.remove('opacity-0', 'invisible');
                } else {
                    backToTopBtn.classList.remove('!opacity-100', '!visible');
                    backToTopBtn.classList.add('opacity-0', 'invisible');
                }
            });

            backToTopBtn.addEventListener('click', function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    })();
</script>

{{-- ============================================ --}}
{{-- PAGE LOADER --}}
{{-- ============================================ --}}
{{-- DISABLED: the loader is now fully controlled by Alpine.js
     (x-data/x-init) directly in app.blade.php. Running this
     duplicate vanilla-JS version at the same time caused both
     to fight over removing #page-loader, which is part of why
     it felt slower than the actual page-ready time. --}}
{{--
<script>
    (function () {
        var loader = document.getElementById('page-loader');
        if (!loader) return;

        function hideLoader() {
            loader.classList.add('hidden');
            loader.addEventListener('transitionend', function () {
                if (loader.parentNode) {
                    loader.parentNode.removeChild(loader);
                }
            }, { once: true });
            setTimeout(function () {
                if (loader.parentNode) {
                    loader.parentNode.removeChild(loader);
                }
            }, 300);
        }

        if (document.readyState === 'complete') {
            hideLoader();
        } else {
            window.addEventListener('load', hideLoader, { once: true });
        }
    })();
</script>
--}}

{{-- ============================================ --}}
{{-- SERVICE WORKER (PWA) --}}
{{-- ============================================ --}}
@if(config('portfolio.pwa.enabled', false))
    <script>
        (function () {
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function () {
                    navigator.serviceWorker.register('/service-worker.js')
                        .then(function (registration) {
                            console.log('%c\u{1F4E6} ServiceWorker registered: ' + registration.scope, 'color: #888;');
                        })
                        .catch(function (error) {
                            console.log('%c\u{26A0} ServiceWorker registration failed: ' + error, 'color: #888;');
                        });
                });
            }
        })();
    </script>
@endif

{{-- ============================================ --}}
{{-- ERROR TRACKING --}}
{{-- ============================================ --}}
<script>
    (function () {
        // Global error handler
        window.addEventListener('error', function (event) {
            var errorMsg = event.error ? event.error.message : event.message;
            var errorStack = event.error ? event.error.stack : '';
            var errorSource = event.filename || 'unknown';
            var errorLine = event.lineno || 0;

            console.error(
                '%c\u{1F6A8} Error: ' + errorMsg + '\n' +
                '%c   Source: ' + errorSource + ':' + errorLine + '\n' +
                '%c   Stack: ' + errorStack,
                'color: #ff4444; font-weight: bold;',
                'color: #ff8888;',
                'color: #ffaaaa;'
            );

            // Send to error tracking service if available
            // if (window.Sentry) { Sentry.captureException(event.error); }
            // if (window.LogRocket) { LogRocket.captureException(event.error); }
        });

        // Unhandled promise rejection handler
        window.addEventListener('unhandledrejection', function (event) {
            console.error(
                '%c\u{1F6A8} Unhandled Promise Rejection: ' + event.reason,
                'color: #ff4444; font-weight: bold;'
            );

            // if (window.Sentry) { Sentry.captureException(event.reason); }
        });
    })();
</script>

{{-- ============================================ --}}
{{-- CONSOLE WELCOME MESSAGE --}}
{{-- ============================================ --}}
<script>
    (function () {
        var styles = {
            title: 'font-size: 24px; font-weight: bold; color: #fff; text-shadow: 0 0 10px rgba(255,255,255,0.3);',
            subtitle: 'font-size: 14px; color: #888;',
            link: 'font-size: 14px; color: #fff; text-decoration: underline;',
            info: 'font-size: 12px; color: #555;',
            emoji: 'font-size: 30px;'
        };

        console.log(
            '%c\u{1F680} PORTFOLIO %c v1.0.0\n' +
            '%cFull-Stack Developer & Digital Architect\n' +
            '%c\u{1F449} hello@@yourdomain.com\n' +
            '%c\u{1F4CD} City, Country\n' +
            '%c\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501\u2501',
            styles.title,
            '',
            styles.subtitle,
            styles.link,
            styles.info,
            'color: #333;'
        );

        console.log(
            '%c\u{1F4AC} Like what you see? Let\'s work together!',
            styles.subtitle
        );
    })();
</script>

{{-- ============================================ --}}
{{-- KEYBOARD SHORTCUTS --}}
{{-- ============================================ --}}
<script>
    (function () {
        document.addEventListener('keydown', function (e) {
            // Escape: Close any open modals/menus
            if (e.key === 'Escape') {
                // Close Alpine.js modals if any
                document.dispatchEvent(new CustomEvent('close-all-modals'));
            }

            // Ctrl/Cmd + K: Focus search (optional)
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                var searchInput = document.querySelector('input[type="search"], input[name="search"]');
                if (searchInput) {
                    searchInput.focus();
                }
            }

            // H: Go to home
            if ((e.ctrlKey || e.metaKey) && e.key === 'h') {
                e.preventDefault();
                window.location.href = '{{ route('home') }}';
            }
        });
    })();
</script>

{{-- ============================================ --}}
{{-- ADDITIONAL SCRIPTS STACK --}}
{{-- ============================================ --}}
@stack('scripts')