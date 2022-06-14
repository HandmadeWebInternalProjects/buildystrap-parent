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
    lib: {
      entry: path.resolve(__dirname, 'src/main.ts'),
      name: 'script',
      fileName: (format) => `script.${format}.js`
    },
    // rollupOptions: {
    //   output: {
    //     entryFileNames: "[name].js",
    //   },
    // }
  }
});
