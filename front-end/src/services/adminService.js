// Import Axios for making HTTP requests
import axios from 'axios';


export async function fetchBooksWithUsers(page){
    try {
        const response = await axios.get(`v1/admin/booksWithUsers?page=${page}`);
        return response
    } catch (error) {
        console.error('Error fetching books:', error);
    }
}

export async function fetchUsers(page){
    try {
        const response = await axios.get(`v1/admin/users?page=${page}`);
        return response
    } catch (error) {
        console.error('Error fetching users:', error);
    }
}

export async function deleteBook(id){
    try {
        const response = await axios.get(`v1/admin/deleteBook/${id}`);
        return response
    } catch (error) {
        console.error('Error deleting book:', error);
    }
}