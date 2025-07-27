/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./www/src/Views/**/*.html.twig"],
  theme: {
    fontFamily: {
      'mono': ['Nunito-Medium'],
      'mono-bold': ['Nunito-Bold']
    },
    extend: {
      colors: {
        'dark': '#1c1c1c',
        'mint': '#11eeb3',
        'lila': '#9253ff'
      }
    },
  },
  darkMode: 'class',
  plugins: [],
}
