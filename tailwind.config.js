import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    // 1. Pastikan darkMode diset ke 'class' agar tombol switch Anda berfungsi
    safelist: [
        {
            // Menangkap bg, text, dan border untuk semua warna yang digunakan
            pattern:
                /(bg|text|border)-(blue|indigo|emerald|amber|cyan|violet|rose|purple)-(50|100|200|300|400|500|600|700|800|900)/,
            variants: ["hover", "dark", "dark:hover", "group-hover"],
        },
    ],
    // 2. Pastikan content mengarah ke semua file blade dan JS Anda
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js", // Tambahkan ini
        "./resources/js/**/*.vue", // Jika pakai Vue
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
