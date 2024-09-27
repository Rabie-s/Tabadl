import axios from 'axios';
import { useAdminStore } from '@/stores/admin.js';
const admin = useAdminStore();



const adminAxios = axios.create({
    baseURL:import.meta.env.VITE_BASE_URL_API,
})

//adminAxios.defaults.baseURL = import.meta.env.VITE_BASE_URL_API;
adminAxios.defaults.withCredentials = true;
adminAxios.defaults.withXSRFToken = false;
adminAxios.defaults.headers.common = { 'Authorization': `Bearer ${admin.adminToken}` };

export default adminAxios;