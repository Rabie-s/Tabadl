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
                            <Button @click="handleCompleteBook(book.id, true)" class="w-12 h-8" color="green">
                                نعم
                            </Button>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-base">
                            <Button @click="handleDeleteBook(book.id)" class="w-12 h-8" color="red">
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
import Button from '@/components/Button.vue';
import { onMounted, ref } from 'vue';
import { completeBook, deleteBook, fetchUserBooks } from '@/services/bookService';
import { toast } from 'vue3-toastify';

const booksData = ref([]); // Initialize with an empty array

// Function to fetch user books
async function handleFetchUserBooks() {
    try {
        const response = await fetchUserBooks();
        booksData.value = response.data || []; // Fallback to an empty array if no data
    } catch (error) {
        console.error('Error fetching user books:', error);
        toast.error('فشل في تحميل الكتب', { "theme": "colored" });
    }
}

// Function to complete a book
async function handleCompleteBook(bookId, boolean) {
    try {
        await completeBook(bookId, boolean);
        await handleFetchUserBooks();
        toast.success('تم تحديث حالة الكتاب بنجاح', { "theme": "colored" });
    } catch (error) {
        console.error('Error completing book:', error);
        toast.error('فشل في تحديث حالة الكتاب', { "theme": "colored" });
    }
}

// Function to delete a book
async function handleDeleteBook(bookId) {
    try {
        await deleteBook(bookId);
        await handleFetchUserBooks();
        toast.success('تم حذف الاعلان بنجاح', { theme: 'colored' });
    } catch (error) {
        console.error('Error deleting book:', error);
        toast.error('فشل في حذف الاعلان', { "theme": "colored" });
    }
}

// Fetch all books on component mount
onMounted(() => {
    handleFetchUserBooks();
});
</script>
