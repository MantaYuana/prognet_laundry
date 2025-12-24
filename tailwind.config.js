import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/vendor/**/*.blade.php", 
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                primary: "var(--color-primary)",
                surface: "var(--color-surface)",
                link: "var(--color-link)",
                destructive: "var(--color-destructive)",
                warning: "var(--color-warning)",
                line: "var(--color-line)",
                "odd-row": "var(--color-odd-row)",
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
