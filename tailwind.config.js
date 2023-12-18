/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./src/**/*.{html,js}",
        "./node_modules/tw-elements/dist/js/**/*.js",
        "./node_modules/flowbite/**/*.js",
        "./pages/**/*.{html,js}",
        "./components/**/*.{html,js}",
        "./*/*.html",
        "./public/tw-elements/dist/js/**/*.js",
        "./public/flowbite/**/*.js",
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require("tw-elements/dist/plugin"),
        require("flowbite/plugin"),
        require("@tailwindcss/forms"),
    ],
};
