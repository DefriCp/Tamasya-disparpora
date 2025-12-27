/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/views/**/*.blade.php", "./resources/js/**/*.js"],
    theme: {
        extend: {
            colors: {
                primary: '#009B4C',
                secondary: '#166FBE',
                accent: '#FFC107',
            },
        },
    },
    plugins: [],
};
