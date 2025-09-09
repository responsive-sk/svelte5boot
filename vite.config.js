import { svelte, vitePreprocess } from "@sveltejs/vite-plugin-svelte";
import { defineConfig } from "vite";
import { resolve } from "path";


export default defineConfig({

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
      $lib: resolve("./resources/js/lib"),
      $islands: resolve("./frontend/src/lib/components/islands"),
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
        main: resolve("./resources/js/boot.ts"),
        // islands: "frontend/src/lib/boot/islands.ts",
      },
      output: {
        chunkFileNames: 'assets/[name]-[hash].js',
        assetFileNames: 'assets/[name]-[hash][extname]',
        // Oprav banner/footer syntax
        banner: () => "/*! Project: responsive.sk svelte5boot */",
        footer: () => "// END",
      }
    },
    sourcemap: process.env.NODE_ENV !== 'production'
  },

  optimizeDeps: {
    exclude: ['svelte']
  },

  // server: {
  //   host: "localhost",
  //   port: 5173,
  //   strictPort: true,
  //   cors: true,
  //   origin: "http://localhost:5173"
  // }
});