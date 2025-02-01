import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                navyblue: {
                    50: '#D0E3F1',
                    500: '#003366',
                    700: '#002244',
                }
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                sm: ['0.9rem', '1rem'],
                a: '0.938rem',
                base: ['1rem', '1.188rem'],
                lg: ['1.25rem', '1.375rem'],
            },
            padding: {
                '0.75': '0.188rem',
            },
        },
    },
    plugins: [],
};
