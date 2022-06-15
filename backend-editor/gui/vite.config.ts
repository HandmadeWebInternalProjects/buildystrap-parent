const path = require('path')

import { fileURLToPath, URL } from "url";

import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", import.meta.url)),
    },
  },
  build: {
    outDir: '../../public/builder-gui',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: 'src/main.ts'
      // output: {
      //   entryFileNames: "[name].js",
      // },
    }
  }
});
