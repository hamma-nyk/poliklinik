import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css", // File CSS utama
                "resources/js/app.js", // File JS utama
            ],
            refresh: true,
        }),
    ],
    // server: {
    //     host: true, // Ini otomatis set ke 0.0.0.0
    //     port: 5173, // Port default vite (opsional)
    // },
    server: {
        host: "0.0.0.0", // Izinkan akses dari semua IP
        hmr: {
            host: "192.168.10.25", // GANTI DENGAN IP KOMPUTER ANDA!
        },
    },
});
