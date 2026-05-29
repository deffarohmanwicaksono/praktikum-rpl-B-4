import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // 1. Asset Utama
                'resources/css/app.css', 
                'resources/js/app.js',

                // 2. Asset Halaman Login
                'resources/css/pages/login.css',
                'resources/js/auth/login.js',

                // 2. Asset Halaman Dashboard Utama (Home)
                'resources/css/pages/home.css',
                'resources/js/home/home.js',

                // 4. Asset Halaman Pencarian (Search)
                'resources/css/pages/search.css',
                'resources/js/products/search.js',

                // 5. Asset Halaman Detail Barang (Detail Product)
                'resources/css/pages/detail-product.css',
                'resources/js/products/detail-product.js',

                // 6. Asset Halaman Dashboard Seller
                'resources/css/pages/dashboard-seller.css',
                'resources/js/seller/dashboard-seller.js',

                // 7. Asset Halaman Unggah Barang (Upload Product)
                'resources/css/pages/upload-product.css',
                'resources/js/seller/upload-product.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});