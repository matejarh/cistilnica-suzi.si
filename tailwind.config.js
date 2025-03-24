import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Lato", "sans-serif"],
                heading: ["Poppins", "sans-serif"],
            },
            colors: {
                primary: {
                    light: "#7dd3fc", // sky-300
                    DEFAULT: "#0ea5e9", // sky-500
                    dark: "#0369a1", // blue-700
                },
                secondary: {
                    DEFAULT: "#14b8a6", // teal-500
                    light: "#6ee7b7", // emerald-400
                },
                neutral: {
                    light: "#f8fafc", // slate-100
                    DEFAULT: "#e5e7eb", // gray-300
                    dark: "#334155", // slate-700
                },
                accent: {
                    DEFAULT: "#06b6d4", // cyan-400
                    dark: "#0891b2", // cyan-600
                },
            },
        },
    },

    plugins: [forms, typography],
};
