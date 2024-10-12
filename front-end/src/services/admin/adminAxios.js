import axios from 'axios';
import { useAdminStore } from '@/stores/admin.js';




const adminAxios = axios.create({
    baseURL: import.meta.env.VITE_BASE_URL_API,
})

//adminAxios.defaults.baseURL = import.meta.env.VITE_BASE_URL_API;
adminAxios.defaults.withCredentials = true;
adminAxios.defaults.withXSRFToken = false;

// Create an Axios interceptor to set the authorization header
adminAxios.interceptors.request.use(config => {
    const admin = useAdminStore();
    const adminToken = admin.adminToken;

    if (adminToken) {
        config.headers['Authorization'] = `Bearer ${adminToken}`;
    } else {
        delete config.headers['Authorization'];
    }

    return config;
}, error => {
    return Promise.reject(error);
});


export default adminAxios;