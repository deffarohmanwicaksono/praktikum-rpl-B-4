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

                // 8. Asset Halaman Edit Barang (Edit Product)
                'resources/css/pages/edit-product.css',
                'resources/js/seller/edit-product.js',

                // 9. Asset Halaman Sesi Chat (Chat Session)
                'resources/css/pages/chat-session.css',
                'resources/js/chat/chat-session.js',

                // 10. Asset Halaman Checkout
                'resources/css/pages/checkout.css',
                'resources/js/checkout/checkout.js',
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