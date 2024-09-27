<template>
    <div class="my-4 rounded-lg shadow overflow-hidden">
        <div class="w-full overflow-x-auto">
            <table dir="rtl" class="min-w-full text-black">
                <thead class="bg-gray-200 border-b-2">
                    <tr>
                        <th class="px-4 py-2 text-right text-lg">#</th>
                        <th class="px-4 py-2 text-right text-lg">عنوان الكتاب</th>
                        <th class="px-4 py-2 text-right text-lg">تاريخ النشر</th>
                        <th class="px-4 py-2 text-right text-lg">هل تمت العملية</th>
                        <th class="px-4 py-2 text-right text-lg">حذف الاعلان</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(book, index) in booksData" :key="book.id" class="odd:bg-gray-100">
                        <td class="px-4 py-2 whitespace-nowrap text-base">{{ index + 1 }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-base">{{ book.title }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-base">{{ book.created_at }}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-base">
                            <Button @click="handelCompleteBook(book.id, true)" class="w-12 h-8" color="green">
                                نعم
                            </Button>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-base">
                            <Button @click="handelDeleteBook(book.id)" class="w-12 h-8" color="red">
                                <i class="fa-solid fa-trash-can"></i>
                            </Button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import Button from '@/components/Button.vue'
import axios from 'axios'
import { onMounted, ref } from 'vue';
import { completeBook, deleteBook } from '@/services/bookService';
import { toast } from 'vue3-toastify';


const booksData = ref({});


// Function to fetch all books
async function getAllBooks() {
    try {
        const response = await axios.get('user/userBooks');
        booksData.value = response.data;
    } catch (error) {
        console.error('Error fetching books:', error);
    }
}

// Function to fetch all books
async function handelCompleteBook(bookId, boolean) {
    await completeBook(bookId, boolean)
    await getAllBooks()
}

// Function to delete book
async function handelDeleteBook(bookId) {
    await deleteBook(bookId)
    await getAllBooks()
    toast.success('تم حذف الاعلان بنجاح', { "theme": "colored" })
}

// Function to get full image path for a book
function getImagePath(imagePathFromServer) {
    return `${imagePath}${imagePathFromServer}`;
}



// Fetch all books on component mount
onMounted(() => {
    getAllBooks();
});


</script>