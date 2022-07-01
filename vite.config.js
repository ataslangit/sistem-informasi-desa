import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: 'public/assets',
        assetsDir: '',
    },
    plugins: [
        laravel([
            'src/sass/app.scss',
            'src/js/app.js',
        ]),
    ],
})
