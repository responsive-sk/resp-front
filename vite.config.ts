import { defineConfig } from 'vite';
import { resolve } from 'path';
import { visualizer } from 'rollup-plugin-visualizer';

export default defineConfig({
  root: './src',
  base: '/build/assets/',

  build: {
    outDir: resolve(__dirname, '../resp-blog/public/build/assets'),
    emptyOutDir: true,

    rollupOptions: {
      input: {
        app: resolve(__dirname, 'src/app.ts'),
      },
      output: {
        entryFileNames: 'app.js',
        chunkFileNames: 'chunks/[name]-[hash].js',
        assetFileNames: 'app.css',
        manualChunks(id) {
          if (id.includes('node_modules')) {
            if (id.includes('lit')) {
              return 'vendor-lit';
            }
            return 'vendor';
          }
          if (id.includes('/components/sections/')) {
            return 'sections';
          }
          if (id.includes('/components/ui/')) {
            return 'ui-kit';
          }
        }
      }
    },

    minify: 'esbuild',
    sourcemap: false,
    plugins: [
      visualizer({ open: true })
    ],
  },

  // SPRÁVNE MIESTO PRE resolve.alias
  resolve: {
    alias: {
      '@': resolve(__dirname, 'src'),
    }
  },
});
