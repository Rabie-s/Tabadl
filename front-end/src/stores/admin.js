import { defineStore } from "pinia";
import axios from 'axios';
import { register, login, logout } from "@/services/adminService";
import { toast } from 'vue3-toastify';
import router from "@/router";

export const useAdminStore = defineStore({
    id: 'admin',
    state: () => ({
        adminData: null,
        adminToken: null,
        isAuth: false,
        errors: false,
        errorMessages: [],
    }),

    actions: {
        // Action to fetch CSRF token
        async csrfCookie() {
            try {
                await axios.get(import.meta.env.VITE_SANCTUM_CSRF_URL);
            } catch (error) {
                console.error('Error fetching CSRF cookie:', error);
            }
        },

        // Action to register user
        async registerResult(data) {
            const result = await register(data)
            if (result.status === 200 && result.data.adminToken) {
                this.errors = false;
                this.isAuth = true;
                this.adminToken = result.data.adminToken;
                this.adminData = result.data.admin;
                router.push({ name: 'AdminHome' });
            } else {
                // Handle registration errors
                toast.error('An unknown error occurred.', { "theme": "colored" });
            }
        },

        // Action to log in user
        async loginResult(data) {
            const result = await login(data)
            if (result.status === 200 && result.data.adminToken) {
                this.errors = false;
                this.isAuth = true;
                this.adminToken = result.data.adminToken;
                this.adminData = result.data.admin;
                router.push({ name: 'AdminHome' });
            } else if (result === 401) {
                toast.error('Invalid email or password.', { "theme": "colored" });
            } else {
                toast.error('An unknown error occurred.', { "theme": "colored" });
            }
        },

        // Action to log out user
        async logoutResult() {
            const result = await logout()
            if (result.status === 200) {
                this.adminData = null;
                this.adminToken = null;
                this.isAuth = false;
                this.errors = false;
                this.errorMessages = [];
                router.push({ name: 'Home' });
            } else {
                // Handle logout errors
                toast.error('An unknown error occurred.', { "theme": "colored" });
            }
        }
    },
    persist: true, // Persist state across page reloads
});
