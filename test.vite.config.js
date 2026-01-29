import { defineConfig, loadEnv } from 'vite';
import path from 'path';

export default ({ mode }) => {
  const env = loadEnv(mode, process.cwd(), 'VITE_');
  return defineConfig({
    // Remove root: './src' - it breaks module resolution
    // Vite expects root to be project root by default
    
    server: { 
      port: 5173,
      open: '/index.html' // Auto-open correct HTML file
    },
    
    publicDir: 'public',
    
    build: {
      outDir: 'public/build',
      emptyOutDir: true,
      rollupOptions: {
        input: path.resolve(__dirname, 'src/app.js'),
        output: { 
          entryFileNames: '[name].js', 
          chunkFileNames: '[name].js', 
          assetFileNames: '[name].[ext]' 
        }
      }
    },
    
    resolve: {
      alias: {
        '@': path.resolve(__dirname, 'src'),
      },
    },
    
    define: {
      __API_URL__: JSON.stringify(env.VITE_API_URL || 'http://localhost:8000/api'),
      __APP_ENV__: JSON.stringify(env.VITE_APP_ENV || 'development'),
      __DB_PATH__: JSON.stringify(env.DB_PATH || ''),
    }
  });
};