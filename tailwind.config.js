/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./www/src/Views/**/*.html.twig"],
  theme: {
    fontFamily: {
      'mono': ['VictorMono'],
    },
    extend: {
      animation: {
        'spin-slow': 'spin 6s linear infinite',
      }
    },
  },
  darkMode: 'class',
  plugins: [],
}
