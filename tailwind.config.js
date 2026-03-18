import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./app/Models/**/*.php",
        "./resources/js/**/*.js", 
    ],

     safelist: [ 
        'bg-gray-200',
        'bg-green-200',
        'bg-green-400',
        'bg-green-600',
        'bg-[#B178CC]/80',
        'min-w-[120px]',

    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', 'Figtree', ...defaultTheme.fontFamily.sans],
                mansalva: ['Mansalva', 'cursive'],
            },
        },
    },

    plugins: [forms],
};
