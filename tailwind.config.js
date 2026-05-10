/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class",   // <-- DARK MODE ENABLED

  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],

  theme: {
    extend: {
      colors: {
        cosmeticBrown: '#654321',
        cosmeticText: '#F5DEB3',
        cosmeticHover: '#401d07',
      },
    },
  },

  plugins: [],
}
