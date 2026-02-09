import { defineConfig } from 'vite'
import { resolve } from 'path'

export default defineConfig({
  root: './src',
  base: '/assets/', // Upravené z '/build/assets/'

  build: {
    outDir: resolve(__dirname, '../resp-back/public/assets'), // Upravená cesta
    emptyOutDir: true,
    copyPublicDir: true, // Pridané pre kopírovanie statických súborov

    rollupOptions: {
      input: {
        app: resolve(__dirname, 'src/app.ts'),
        mark: resolve(__dirname, 'src/mark.ts'), // Pridaný mark entry point
        'mark-components': resolve(__dirname, 'src/mark/components/index.ts'), // Mark components bundle
      },
      output: {
        entryFileNames: (chunkInfo) => {
          if (chunkInfo.name === 'mark') {
            return 'mark/[name].js'
          }
          if (chunkInfo.name === 'mark-components') {
            return 'mark/components/[name].js'
          }
          return '[name].js'
        },
        chunkFileNames: 'chunks/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name?.endsWith('.css')) {
            // Separácia CSS pre mark
            if (assetInfo.name?.includes('mark')) {
              return 'mark/[name][extname]'
            }
            return '[name][extname]'
          }
          return 'assets/[name]-[hash][extname]'
        },
        manualChunks(id) {
          // Mark specific chunks
          if (id.includes('/mark/components/')) {
            return 'mark-vendor'
          }
          if (id.includes('/mark/')) {
            return 'mark-core'
          }

          // Main app chunks
          if (id.includes('node_modules')) {
            if (id.includes('lit')) {
              return 'vendor-lit'
            }
            if (id.includes('@shoelace')) {
              return 'vendor-shoelace'
            }
            return 'vendor'
          }
          if (id.includes('/components/sections/')) {
            return 'sections'
          }
          if (id.includes('/components/ui/')) {
            return 'ui-kit'
          }
        },
      },
    },

    minify: 'esbuild',
    sourcemap: false,
  },

  resolve: {
    alias: {
      '@': resolve(__dirname, 'src'),
      '@mark': resolve(__dirname, 'src/mark'),
      '@components': resolve(__dirname, 'src/components'),
      '@styles': resolve(__dirname, 'src/styles'),
    },
  },

  // Dev server configuration
  server: {
    port: 3000,
    open: true,
    proxy: {
      '/api': {
        target: 'http://localhost:8000',
        changeOrigin: true,
      },
      '/mark': {
        target: 'http://localhost:8000',
        changeOrigin: true,
      },
    },
  },

  // Optimize dependencies
  optimizeDeps: {
    // Přidejte HTMX pro optimalizaci
    include: ['lit', '@shoelace-style/shoelace', 'htmx.org'],
    exclude: ['@types/node'],
  },
})
