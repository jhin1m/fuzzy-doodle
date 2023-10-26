const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/**/*.{blade.php,js,vue,ts}",
    "./themes/default/**/*.{blade.php,js,vue,ts}",
    "./plugins/**/*.{blade.php,js,vue,ts}",
  ],
  darkMode: "class",
  theme: {
    extend: {
      fontFamily: {
        sans: ["Nunito", ...defaultTheme.fontFamily.sans],
      },
      transitionProperty: {
        opacity: "opacity",
      },
      screens: {
        xlg: "1200px",
      },
      colors: {
        light: "#ffffff",
        "dark-primary": "#121212",
        "dark-secondary": "#171717",
        input: "#222223",
      },
    },
  },

  variants: {
    extend: {
      opacity: ["disabled"],
    },
  },

  plugins: [require("@tailwindcss/forms")],
};
