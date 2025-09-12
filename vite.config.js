import { svelte, vitePreprocess } from "@sveltejs/vite-plugin-svelte";
import { defineConfig } from "vite";
import { resolve } from "path";

export default defineConfig({
  base: '/build/',
  plugins: [
    svelte({
      preprocess: vitePreprocess(),
      compilerOptions: {
        dev: process.env.NODE_ENV !== 'production'
      }
    }),
  ],
  resolve: {
    alias: {
      '$lib': resolve('./frontend/src/lib'),
      '$components': resolve('./frontend/src/lib/components'),
      '$stores': resolve('./frontend/src/lib/stores'),
      '$utils': resolve('./frontend/src/lib/utils'),
      '$pages': resolve('./frontend/src/pages'),
    },
  },
  publicDir: false,
  build: {
    minify: 'esbuild',
    esbuild: {
      legalComments: 'none',
      minify: true,
      target: 'es2020',
    },
    manifest: true,
    outDir: "public/build",
    assetsDir: "assets",
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: resolve("./frontend/src/app.ts"),
      },
      output: {
        chunkFileNames: 'assets/[name]-[hash].js',
        assetFileNames: 'assets/[name]-[hash][extname]',
      }
    },
    sourcemap: process.env.NODE_ENV !== 'production'
  },
  optimizeDeps: {
    exclude: ['svelte']
  },
  server: {
    host: "localhost",
    port: 5173,
    strictPort: true,
    cors: true,
    origin: "http://localhost:5173"
  }
});
