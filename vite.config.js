import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 9924,
    },
    resolve: {
        alias: {
            // 'vue': 'vue/dist/vue.esm-bundler.js', // alias 설정 추가
            '@': 'resources/js',
        },
    },
});
