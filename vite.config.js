import { svelte, vitePreprocess } from "@sveltejs/vite-plugin-svelte";
import { defineConfig } from "vite";

export default defineConfig({
  plugins: [
    svelte({
      preprocess: vitePreprocess(),
    }),
  ],
  resolve: {
    alias: {
      $lib: "/resources/js/lib",
      '$islands': '/frontend/src/lib/components/islands', // Nový alias
    },
  },
  publicDir: false,
  build: {
    manifest: true,
    outDir: "public/build",
    assetsDir: "assets",
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: "resources/js/boot.ts",
        islands: "frontend/src/lib/boot/islands.ts", // Nový vstup
      },
    },
  },
  server: {
    host: "localhost",
    port: 5173,
    strictPort: true,
    cors: true,
    origin: "http://localhost:5173",
    headers: {
      "Access-Control-Allow-Origin": "*",
    },
  },
});