import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    prefix: 'tw-',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            textColor:{
                'default':'#717171',
                'primary-1':'#0085DB',
                'primary-2':'#E5F3FB',
                'secondary-1':'#FB977D',
                'secondary-2':'#5AC8FA',
                'action-1':'#09C97F',
                'action-2':'#F8B15D',
                'action-3':'#F95668',
                'action-4':'#8763DA',
                'black':'#111C2D',
                'back':'#F7F9FB'

            },
            colors:{
                'borde':'#E3E3F4',
                'primary-1':'#0085DB',
                'primary-2':'#E5F3FB',
                'secondary-1':'#FB977D',
                'secondary-2':'#5AC8FA',
                'action-1':'#09C97F',
                'action-2':'#F8B15D',
                'action-3':'#F95668',
                'action-4':'#8763DA',
                'black':'#111C2D',
                'back':'#F7F9FB'
            },

        },
    },

    plugins: [],
};
