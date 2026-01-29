import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  root: './src',
  
  build: {
    outDir: resolve(__dirname, '../../../public/build/assets'),
    emptyOutDir: true,
    
    rollupOptions: {
      input: {
        app: resolve(__dirname, 'src/app.js'),
      },
      output: {
        entryFileNames: '[name].js',
        chunkFileNames: 'chunks/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name === 'app.css') {
            return '[name].css';
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
  
  // server: {
  //   port: 5174,
  //   strictPort: true,
  //   cors: true,
  // },
  
  // Resolve aliases
  resolve: {
    alias: {
      '@': resolve(__dirname, 'src'),
    }
  }
});

