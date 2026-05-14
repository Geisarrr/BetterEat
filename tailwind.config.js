import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                'olive': {
                    600: '#556B2F', // Sesuaikan kode hex dengan Figma
                    800: '#53643A', // Warna Sidebar
                },
                'sage': {
                    200: '#D1DBC1', // Warna tombol/aksen
                }
            }    
        },
    },

    plugins: [forms],
};
