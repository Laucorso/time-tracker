import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [vue()],
    resolve: {
      alias: {
        'vue': 'vue/dist/vue.esm-bundler.js', 
      }
    }
  });
