/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['resources/views/alahly.blade.php'],
  theme: {
    extend: {
      fontFamily:{
        sf:['SF Arabic','sans-serif'],
        thesans:['TheSans','sans-serif'],
        dejasans:['DejaVu Sans','sans-serif']
      }
    },
  },
  plugins: [],
}

