// Import Axios for making HTTP requests
import adminAxios from '@/services/admin/adminAxios.js';



export async function fetchBooksWithUsers(page){
    try {
        const response = await adminAxios.get(`admin/fetchBooksWithUsers?page=${page}`);
        console.log(response)
        return response
    } catch (error) {
        console.error('Error fetching books:', error);
    }
}

export async function fetchUsers(page){
    try {
        const response = await adminAxios.get(`admin/fetchUsers?page=${page}`);
        return response
    } catch (error) {
        console.error('Error fetching users:', error);
    }
}

export async function deleteBook(id){
    try {
        const response = await adminAxios.get(`admin/deleteBook/${id}`);
        return response
    } catch (error) {
        console.error('Error deleting book:', error);
    }
}

export async function fetchAdmins(page){
    try {
        const response = await adminAxios.get(`admin/fetchAdmins?page=${page}`);
        return response
    } catch (error) {
        console.error('Error fetching admins:', error);
    }
}


export async function deleteAdmin(adminId) {
    // Call the function to fetch CSRF cookie before deleting a book
   // await fetchCsrfCookie();

    try {
        // Make a POST request to delete a book
        const result = await adminAxios.delete(`admin/deleteAdmin/${adminId}`)

        // Return the status of the request
        return result.status;

    } catch (error) {
        // Log any errors that occur during the request
        console.log(error);
    }
}