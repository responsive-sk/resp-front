import { defineConfig } from 'vite';
import { resolve } from 'path';
import * as MinifyHtmlPkg from 'rollup-plugin-minify-html-literals';

// Handle weird CommonJS/ESM interop nesting where default export is double wrapped
// @ts-ignore
const minifyHTML = MinifyHtmlPkg.default?.default ?? MinifyHtmlPkg.default ?? MinifyHtmlPkg;

export default defineConfig({
  root: './src',
  base: '/build/assets/',

  build: {
    outDir: resolve(__dirname, '../blog/public/build/assets'),
    emptyOutDir: true,

    rollupOptions: {
      input: {
        app: resolve(__dirname, 'src/app.ts'),
        mark: resolve(__dirname, 'src/mark.ts'),
      },
      output: {
        entryFileNames: '[name].js',
        chunkFileNames: 'chunks/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name && assetInfo.name.endsWith('.css')) {
            return 'app.css';
          }
          return 'assets/[name]-[hash].[ext]';
        }
      }
    },

    // Minify for production (using esbuild which is faster and built-in)
    minify: 'esbuild',

    // Generate sourcemaps for debugging
    sourcemap: false,
  },

  // Resolve aliases
  resolve: {
    alias: {
      '@': resolve(__dirname, 'src'),
    }
  },

  plugins: [
    minifyHTML(),
  ],
});

