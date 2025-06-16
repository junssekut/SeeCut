import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from 'daisyui';
import textstroke from '@designbycode/tailwindcss-text-stroke';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            backgroundImage: {
                'landing': "url('/public/assets/images/home/landing.png')",
                's-logo': "url('/public/assets/images/home/s-logo.png')",
            },
            colors: {
                'Eerie-Black': '#1A1A1A',
                'Seasalt': '#FAFAFA',
                'Satin-Sheen-Yellow': '#B5964D',
                'Dun': '#E6CFAC',
                'Ecru': '#E9BF80',
                'Charcoal': '#151515',
                'Dark-Charcoal': '#2A2A2A',
                'Dark-Charcoal-2': '#39332A',
            },
            fontFamily: {
                'Kuunari': ['Kuunari'],
                'Poppins': ['Poppins'],
            },
        },
    },

    plugins: [forms, daisyui, textstroke],   
};
