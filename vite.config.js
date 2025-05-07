import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
//     server: {
//         host: '0.0.0.0', 
//         port: 5173,        // (default, atau bisa ubah kalau mau bebwas)
//         hmr: {
//             host: '172.20.10.3', // <<< Tambahkan ini juga sesuai sama ip address klen ye
//         },
//     },
});