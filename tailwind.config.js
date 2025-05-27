import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from 'daisyui';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'Eerie-Black': '#1A1A1A',
                'Seasalt': '#FAFAFA',
                'Satin-Sheen-Yellow': '#B5964D',
                'Dun': '#E6CFAC',
                'Ecru': '#E9BF80',
            },
            fontFamily: {
                'Kuunari': ['Kuunari'],
                'Poppins': ['Poppins'],
            },
        },
    },

    plugins: [forms, daisyui],   
};
