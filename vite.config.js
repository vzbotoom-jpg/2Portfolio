// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS Files
                'resources/css/app.css',
                'resources/css/animations.css',
                'resources/css/typography.css',
                'resources/css/components/buttons.css',
                'resources/css/components/cards.css',
                'resources/css/components/forms.css',
                
                // JS Files
                'resources/js/app.js',
                'resources/js/animations.js',
                'resources/js/cursor-effects.js',
                'resources/js/navigation.js',
                'resources/js/components/parallax.js',
                'resources/js/components/counter.js',
                'resources/js/components/form-validation.js',
            ],
            refresh: true,
            fonts: [
                // Inter font - primary font family
                bunny('Inter', {
                    weights: [
                        100, // Thin
                        200, // Extra Light
                        300, // Light
                        400, // Regular
                        500, // Medium
                        600, // Semi Bold
                        700, // Bold
                        800, // Extra Bold
                        900, // Black
                    ],
                    styles: ['normal', 'italic'],
                }),
                
                // JetBrains Mono - for code blocks
                bunny('JetBrains Mono', {
                    weights: [400, 500, 600, 700],
                    styles: ['normal'],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        // Optional: Configure dev server
        hmr: {
            host: 'localhost',
        },
    },
    // Optional: Build configuration
    build: {
        // Output directory
        outDir: 'public/build',
        
        // Asset manifest
        manifest: true,
        
        // Chunk size warning limit
        chunkSizeWarningLimit: 1000,
        
        // Rollup options
        rollupOptions: {
            output: {
                // Manual chunks for better caching
                manualChunks(id) {
                    if (id.includes('node_modules/alpinejs')) {
                        return 'vendor';
                    }
                },
            },
        },
    },
    // Resolve aliases (optional)
    resolve: {
        alias: {
            '@': '/resources',
            '@css': '/resources/css',
            '@js': '/resources/js',
            '@images': '/public/images',
            '@fonts': '/public/fonts',
        },
    },
    // CSS configuration
    css: {
        // PostCSS plugins (if needed)
        postcss: {
            plugins: [
                // Add any PostCSS plugins here
            ],
        },
        // CSS modules configuration
        modules: {
            localsConvention: 'camelCaseOnly',
        },
        // Dev sourcemap
        devSourcemap: true,
    },
});