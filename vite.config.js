import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import vuetify from "vite-plugin-vuetify";

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true
        }
    },
    plugins: [

        laravel({
            input: ['resources/scss/style.scss','resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        vuetify({
            autoImport: true,
            styles: { configFile: 'resources/scss/variables.scss'},
        })
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            '#': '/resources/_mockApis',
            '$': '/public',
        },
    },
    css: {
        preprocessorOptions: {
            scss: {}
        }
    },
});
