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

                // 3. Asset Halaman Dashboard Utama (Home)
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
                'resources/css/pages/chat-list.css',
                'resources/js/chat/chat-list.js',

                // 10. Asset Halaman Checkout & Link Pembelian
                'resources/css/pages/checkout.css',
                'resources/js/checkout/checkout.js',
                'resources/css/pages/purchase-link.css',
                'resources/js/checkout/purchase-link.js',

                // 11. Asset Halaman Riwayat (History)
                'resources/css/components/history.css',
                'resources/css/pages/purchase-history.css',
                'resources/js/history/purchase-history.js',
                'resources/css/pages/sales-history.css',
                'resources/js/history/sales-history.js',

                // 12. Halaman Pendukung (Notification, Wishlist, Profile)
                'resources/css/pages/notification.css',
                'resources/js/notification/notification.js',
                'resources/css/pages/wishlist.css',
                'resources/js/wishlist/wishlist.js',
                'resources/css/pages/profile-seller.css',
                'resources/js/profile/profile-seller.js',
                'resources/css/pages/profile-user.css',
                'resources/js/profile/profile-user.js',

                // 13. Asset Halaman Admin
                'resources/css/pages/dashboard-admin.css',
                'resources/js/admin/dashboard-admin.js',
                'resources/css/pages/products.css',
                'resources/js/admin/products.js',
                'resources/css/pages/reports.css',
                'resources/js/admin/reports.js',
                'resources/css/pages/transactions.css',
                'resources/js/admin/transactions.js',
                'resources/css/pages/users.css',
                'resources/js/admin/users.js',
                'resources/css/pages/verification.css',
                'resources/js/admin/verification.js',
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