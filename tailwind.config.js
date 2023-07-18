/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["public/**/*.{html,js}", "views/pages/index.ejs"],
  theme: {
      extend: {
          fontFamily: {
              rubik: ['Rubik', 'sans-serif'],
              grenzeGotisch: ['GrenzeGotisch', 'serif'],
              fingerpaint: ['FingerPaint', 'sans-serif'],
              narrow: ['PTSansNarrow', 'sans-serif'],
          },
          animation: {
              type: 'type 1.8s ease-out .8s 1 normal both',
          },
      },
  },
  variants: {
      extend: {
          width: ["responsive", "hover", "focus"],
      },
  },
  plugins: [
      require('@tailwindcss/forms'),
      require("daisyui"),
  ],
  darkMode: 'class'

}

