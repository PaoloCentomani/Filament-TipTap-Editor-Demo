import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';
import * as path from 'path';

export default defineConfig({
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '@': path.resolve(__dirname, 'resources'),
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/js/app.js',
                'resources/css/filament/admin/theme.css',
            ],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),
    ],
});
