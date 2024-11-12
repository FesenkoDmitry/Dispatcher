import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url';

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@c': fileURLToPath(new URL('./src/components', import.meta.url)),
      '@p': fileURLToPath(new URL('./src/pages', import.meta.url)),
      '@a': fileURLToPath(new URL('./src/api', import.meta.url)),
    }
  },
  build: {
    outDir: './production',
  }
})
