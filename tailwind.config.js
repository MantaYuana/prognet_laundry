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

    plugins: [require("daisyui"), forms],

    daisyui: {
        themes: [
            {
                myTheme: {
                    /* ==== BRAND COLORS (from your :root) ==== */
          "primary": "#14b8a6",           // --color-primary
          "secondary": "#5b58ff",         // --color-link
          "accent": "#ff9900",            // --color-warning
          "neutral": "#333333",           // neutral dark gray text/bg

          /* ==== SURFACE COLORS ==== */
          "base-100": "#fbfbfa",          // --color-surface
          "base-200": "#f0f0f0",          // --color-odd-row
          "base-300": "#d7d7d7",          // --color-line
          "base-content": "#1a1a1a",      // default text color

          /* ==== STATE COLORS ==== */
          "info": "#5b58ff",              // same as link
          "success": "#14b8a6",           // same as primary
          "warning": "#ff9900",
          "error": "#fc4f4f",             // --color-destructive
                },
            },
        ],
    },
};
