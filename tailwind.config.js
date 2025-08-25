import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.vue",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            // Removed fontFamily override to allow Calibri to work
        },
    },

    plugins: [forms],
};
