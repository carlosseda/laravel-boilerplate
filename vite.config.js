import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
      laravel({
        input: [
          'resources/sass/admin-app.scss',          
          'resources/sass/auth-app.scss',
          'resources/sass/front-app.scss',
          'resources/js/admin-app.js',
          'resources/js/front-app.js',
        ],
        refresh: true,
      }),
    ],
});
