import { defineConfig, loadEnv } from "vite";
import { resolve } from 'path'
import { createSvgIconsPlugin } from 'vite-plugin-svg-icons';
import fs from 'fs';

// import basicSsl from '@vitejs/plugin-basic-ssl'

// vite.config.js
export default ({ mode }) => {
  process.env = { ...process.env, ...loadEnv(mode, process.cwd()) };

  return defineConfig({
    build: {
      assetsDir: '',
      // generate manifest.json in outDir
      manifest: true,
      outDir: 'public',
      emptyOutDir: false,
      rollupOptions: {
        // overwrite default .html entry
        input: [
          resolve(__dirname, './resources/js/parent-theme.ts'),
        ],
        output: {
          assetFileNames: (assetInfo) => {
            let extType = assetInfo.name.split('.').at(1);
            if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
              extType = 'img';
            }
            if (/woff|woff2|ttf|eot/i.test(extType)) {
              extType = 'fonts';
            }
            return `${extType}/[name][extname]`;
          },
          entryFileNames: "js/[name].js",
        },
      },
    },
    publicDir: './resources/assets',
    base: './',
    resolve: {
      alias: {
        '@': resolve(__dirname, './resources/assets'),
      },
    },
    plugins: [
      {
        name: 'php',
        handleHotUpdate({ file, server }) {
          if (file.endsWith('.php')) {
            server.ws.send({ type: 'full-reload', path: '*' });
          }
        },
      },
      createSvgIconsPlugin({
        // Specify the icon folder to be cached
        iconDirs: [resolve(__dirname, './images')],
        // Specify symbolId format
        symbolId: 'icon-[dir]-[name]',
      }),
      {
        name: 'scss',
        enforce: 'pre',
        transform: (code, id) => {
          if (/\.scss$/.test(id)) {
            const gridBreakpoints = process.env.VITE_GRIDBREAKPOINTS.replace(/[{}"\s]/g, '');
            const gridBreakpointsWithPx = gridBreakpoints
              .split(',')
              .map((breakpoint) => {
                const [key, value] = breakpoint.split(':');
                return `${key}:${value === '0' ? value : value + 'px'}`;
              })
              .join(',');
            return {
              code: `
                $grid-breakpoints: (${gridBreakpointsWithPx});
                ${code}
              `,
              map: null
            }
          }
        }
      },
    ],
  });
};