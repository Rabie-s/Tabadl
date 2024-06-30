// Import Axios for making HTTP requests
import axios from 'axios';

// Function to fetch CSRF cookie
async function fetchCsrfCookie() {
    try {
        // Fetch CSRF cookie from the provided URL
        await axios.get(import.meta.env.VITE_SANCTUM_CSRF_URL);
    } catch (error) {
        // Log an error if fetching CSRF cookie fails
        console.error('Error fetching CSRF cookie:', error);
    }
}

export async function fetchBooks(page, status = '', search = '') {
    try {
        const response = await axios.get(`v1/books?page=${page}&status=${status}&search=${search}`);
        return response
    } catch (error) {
        console.error('Error fetching books:', error);
    }
}

export async function fetchBook(bookId) {
    try {
        const response = await axios.get(`v1/books/${bookId}`)
        return response
    } catch (error) {
        console.error('Error fetching book:', error)
    }
}

// Function to add a book
export async function addBook(data, userId) {
    // Call the function to fetch CSRF cookie before adding a book
    await fetchCsrfCookie();

    try {
        // Make a POST request to add a book
        const result = await axios.post(
            'v1/books', // Endpoint URL
            {
                // Book data to be sent in the request
                title: data.value.title,
                image_extension: data.value.imageExtension,
                image_path: data.value.image,
                status: data.value.status,
                description: data.value.description,
                user_id: userId
            },
            {
                // Additional configuration including headers
                headers: {
                    'Content-Type': 'multipart/form-data' // Set content type for multipart form data
                }
            }
        );

        // Return the status of the request
        return result.status;

    } catch (error) {
        // Log any errors that occur during the request
        console.log(error);
    }
}

export async function deleteBook(bookId) {
    // Call the function to fetch CSRF cookie before deleting a book
    await fetchCsrfCookie();

    try {
        // Make a POST request to delete a book
        const result = await axios.delete(`v1/books/${bookId}`)

        // Return the status of the request
        return result.status;

    } catch (error) {
        // Log any errors that occur during the request
        console.log(error);
    }
}

export async function completeBook(bookId, done) {
    // Call the function to fetch CSRF cookie before completing a book
    await fetchCsrfCookie();

    try {
        // Make a POST request to complete a book
        const result = await axios.put('v1/completed', {
            id: bookId,
            done: done
        })

        // Return the status of the request
        return result.status;

    } catch (error) {
        // Log any errors that occur during the request
        console.log(error);
    }
}



