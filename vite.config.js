import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig(({ mode }) => {
        const env = loadEnv(mode, process.cwd(), '');
        return {
            define: {
                'process.env': env
            },
            plugins: [
                laravel({
                    input: ['resources/css/app.css', 'resources/js/app.js'],
                    refresh: true,
                }),
                vue()
            ],
            resolve: {
                extensions: ['.mjs', '.js', '.ts', '.jsx', '.tsx', '.json', '.vue']
            }
        }
    })
    /*
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue()
    ],
    resolve: {
        extensions: ['.mjs', '.js', '.ts', '.jsx', '.tsx', '.json', '.vue']
    }
});*/