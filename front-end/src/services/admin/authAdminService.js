// Import Axios for making HTTP requests
import adminAxios from '@/services/admin/adminAxios.js';


// Function to fetch CSRF cookie
async function fetchCsrfCookie() {
    try {
        // Fetch CSRF cookie from the provided URL
        await adminAxios.get(import.meta.env.VITE_SANCTUM_CSRF_URL);
    } catch (error) {
        // Log an error if fetching CSRF cookie fails
        console.error('Error fetching CSRF cookie:', error);
    }
}



export async function register(data) {
    //await fetchCsrfCookie();
    try {
        const result = await adminAxios.post('admin/auth/register', {
            name: data.name,
            email: data.email,
            phone_number: data.phone_number,
            password: data.password
        });

        return result

    } catch (error) {
        // Handle registration errors
        console.log('Register error: '+error)
    }
}

export async function login(data) {
    //await fetchCsrfCookie();

    try {
        const result = await adminAxios.post('admin/auth/login', {
            email: data.email,
            password: data.password
        });
        return result
    } catch (error) {
        return error.response.status
    }
}

export async function logout() {
    //await fetchCsrfCookie();

    try {
        const result = await adminAxios.post('admin/auth/logout');
        return result
    } catch (error) {
        console.log('Logout error: ' + error)
    }
}