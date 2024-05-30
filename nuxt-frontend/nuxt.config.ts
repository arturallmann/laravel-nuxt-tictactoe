// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  runtimeConfig: {
    public: {
      apiBase: 'http://localhost:8000',
    },
  },
  devtools: { enabled: true },
  css: ['~/assets/css/global.css'],
});
