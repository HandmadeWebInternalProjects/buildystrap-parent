import { fileURLToPath, URL } from "url"

import { defineConfig } from "vite"

import vue from "@vitejs/plugin-vue"

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      vue: "vue/dist/vue.esm-bundler.js",
      "@": fileURLToPath(new URL("./src", import.meta.url)),
    },
  },
  // server: {
  //   https: true,
  //   hmr: {
  //     port: 443,
  //   },
  // },
  build: {
    outDir: "../../public/builder-gui",
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: "src/main.ts",
    },
  },
})
