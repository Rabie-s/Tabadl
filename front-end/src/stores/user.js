import { defineStore } from "pinia";
import axios from 'axios';
import { register, login, logout } from "@/services/userService";
import { toast } from 'vue3-toastify';
import router from "@/router";

export const useUserStore = defineStore({
    id: 'user',
    state: () => ({
        userData: null,
        token: null,
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
            if (result.status === 200 && result.data.token) {
                this.errors = false;
                this.isAuth = true;
                this.token = result.data.token;
                this.userData = result.data.user;
                router.push({ name: 'Books' });
            } else {
                // Handle registration errors
                toast.error('An unknown error occurred.', { "theme": "colored" });
            }
        },

        // Action to log in user
        async loginResult(data) {
            const result = await login(data)
            if (result.status === 200 && result.data.token) {
                this.errors = false;
                this.isAuth = true;
                this.token = result.data.token;
                this.userData = result.data.user;
                router.push({ name: 'Books' });
            } else if (result === 401) {
                toast.error('Invalid email or password.', { "theme": "colored" });
            } else {
                toast.error('An unknown error occurred.', { "theme": "colored" });
            }
        },

        // Action to log out user
        async logoutResult() {
            const result = await logout(this.token)
            if (true) {//result.status === 200
                this.userData = null;
                this.token = null;
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
