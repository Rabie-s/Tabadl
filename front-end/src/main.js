// Import CSS files
import '@/assets/style.css';
import 'vue3-toastify/dist/index.css';

// Import Vue and related libraries
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import axios from 'axios';

// Import components and store
import App from './App.vue';
import router from './router';
import { useUserStore } from '@/stores/user.js';

// Create Vue app instance
const app = createApp(App);

// Pinia setup for state management
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);
app.use(pinia);

// Axios setup for HTTP requests
axios.defaults.baseURL = import.meta.env.VITE_BASE_URL_API;
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = false;

// Create an Axios interceptor to set the authorization header
axios.interceptors.request.use(config => {
  const user = useUserStore();
  const userToken = user.token;

  if (userToken) {
    config.headers['Authorization'] = `Bearer ${userToken}`;
  } else {
    delete config.headers['Authorization'];
  }

  return config;
}, error => {
  return Promise.reject(error);
});

// Use Vue Router
app.use(router);

// Mount the Vue app
app.mount('#app');