/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{html,js,php}"],
  theme: {
      extend: {
          fontFamily: {
              rubik: ['Rubik', 'sans-serif'],
              grenzeGotisch: ['GrenzeGotisch', 'serif'],
              fingerpaint: ['FingerPaint', 'sans-serif'],
              narrow: ['PTSansNarrow', 'sans-serif'],
          },
      },
  },
  variants: {
      extend: {
          width: ["responsive", "hover", "focus"],
      },
  },
  plugins: [],
}
