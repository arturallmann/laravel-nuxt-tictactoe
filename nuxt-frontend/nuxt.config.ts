// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  runtimeConfig: {
    public: {
      apiBase: process.env.API_BASE || 'http://localhost:8000/api',
    },
  },
  devtools: { enabled: true },
  css: ['~/assets/css/global.css'],
});
