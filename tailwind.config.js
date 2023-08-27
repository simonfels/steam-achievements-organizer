/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./www/src/Views/**/*.html.twig"],
  theme: {
    fontFamily: {
      'mono': ['VictorMono'],
      'mono-bold': ['VictorMono-Bold']
    },
    extend: {
      animation: {
        'spin-slow': 'spin 6s linear infinite',
      },
      colors: {
        'dark': '#1c1c1c',
        'mint': '#11eeb3'
      }
    },
  },
  darkMode: 'class',
  plugins: [],
}
