import { defineConfig, loadEnv } from 'vite';
import path from 'path';

export default ({ mode }) => {
  const env = loadEnv(mode, process.cwd(), 'VITE_');
  return defineConfig({
    root: './src',

    server: { port: 5173 },
    publicDir: path.resolve(__dirname, 'public'),
    build: {
      outDir: path.resolve(__dirname, 'public/build'),
      emptyOutDir: true,
      rollupOptions: {
        input: path.resolve(__dirname, 'src/app.js'),
        output: { entryFileNames:'[name].js', chunkFileNames:'[name].js', assetFileNames:'[name].[ext]' }
      }
    },
    resolve: {
      alias: {
        '@': path.resolve(__dirname, 'src'),
      },
    },
    define: {
      __API_URL__: JSON.stringify(env.VITE_API_URL),
      __APP_ENV__: JSON.stringify(env.VITE_APP_ENV),
      __DB_PATH__: JSON.stringify(env.DB_PATH),
    }
  });
};
