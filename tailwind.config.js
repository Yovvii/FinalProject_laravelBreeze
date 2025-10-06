import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import 'tailwindcss';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        'bg-green-600',
        'bg-orange-600',
        'bg-red-800',
        'text-yellow-100',
        'text-yellow-200',
        'text-white',
        'fill-white',
        'fill-blue-600',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                montaga: ['"Montaga"', 'serif'],
                poppins: ['"Poppins"', 'sans-serif'],
                noto_serif: ['"Noto Serif"', 'serif'],
            },
        },
    },

    darkMode: 'false',

    plugins: [forms],
};
