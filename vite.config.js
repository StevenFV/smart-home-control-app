import {defineConfig, loadEnv} from 'vite';
import i18n from 'laravel-vue-i18n/vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig(({mode}) => {
    // Load env file based on `mode` in the current working directory.
    // Set the third parameter to 'VITE_' to load only VITE_ prefixed environment variable.
    const env = loadEnv(mode, process.cwd(), 'VITE_')
    return ({
        plugins: [laravel({
            input: ['resources/js/app.js', 'resources/images/favicon.svg'], ssr: 'resources/js/ssr.js', refresh: true,
        }), vue({
            template: {
                transformAssetUrls: {
                    base: null, includeAbsolute: false,
                },
            },
        }), i18n(),], server: {
            host: '0.0.0.0', hmr: {
                // Hostname for Hot Module Replacement (HMR) must match the domain to avoid Cross-Origin errors.
                host: env.VITE_HMR_HOST,
                // Specifies the port that the browser will use for HMR, ensuring the connection is routed correctly to
                // the designated Docker container.
                clientPort: parseInt(env.VITE_HMR_CLIENT_PORT),
            },
        },
    })
})
