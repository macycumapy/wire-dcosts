const defaultTheme = require('tailwindcss/defaultTheme');
let colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    presets: [
        require('./vendor/wireui/wireui/tailwind.config.js')
    ],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/wireui/wireui/resources/**/*.blade.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/View/**/*.php',
        './app/WireUI/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: colors.emerald,
                secondary: colors.gray,
                positive: colors.emerald,
                negative: colors.red,
                warning: colors.amber,
                info: colors.blue
            },
        },
        screens: {
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1280px',
            '2xl': '1536px',
            'fhd': '1920px',
            '2k': '2560px',
        }
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require('@tailwindcss/aspect-ratio'), require('tailwind-scrollbar')({ nocompatible: true })],
    variants: {
        scrollbar: ['rounded', 'size']
    }
};
