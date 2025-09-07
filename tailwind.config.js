/**** Tailwind CSS configuration for build-only assets (no dev server) ****/
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/js/**/*.{svelte,ts,js}",
    "./templates/**/*.{html,twig,php}",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
