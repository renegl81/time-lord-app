import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'node:path';
// Importar el nuevo paquete para PostCSS
import tailwindcssPlugin from '@tailwindcss/postcss';
import autoprefixer from 'autoprefixer';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            }
        }),
    ],
    css: {
        postcss: {
            plugins: [
                tailwindcssPlugin,  // Usar el plugin específico de PostCSS
                autoprefixer,
            ],
        },
    },
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'),
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
        },
    },
    server: {
        cors: {
            origin: ['http://localhost:8001', 'http://127.0.0.1:8001'],
            methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            credentials: true,
        },
        headers: {
            'Access-Control-Allow-Origin': '*',
        },
    },
});
