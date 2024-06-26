<template>

<div class="my-10 p-5 rounded-lg bg-slate-100 drop-shadow-2xl">
        <h1 class="text-center font-bold text-3xl uppercase">Book lists</h1>
    </div>

    <div class="bg-white rounded-lg">

        <div class="overflow-auto rounded-lg shadow">
            <table class="text-black w-full">
                <thead class="border-b-2 bg-gray-200">
                    <tr>
                        <th class="text-left text-lg p-2">#</th>
                        <th class="text-left text-lg p-2">Title</th>
                        <th class="text-left text-lg p-2">User</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(book, index) in booksData.data" class="odd:bg-gray-100">
                        <td class="text-base p-2 mb-5 whitespace-nowrap">{{ index + 1 }}</td>
                        <td class="text-base p-2 mb-5 whitespace-nowrap">{{ book.title }}</td>
                        <td class="text-base p-2 mb-5 whitespace-nowrap">{{ book.user.name }}</td>
                        <td class="space-x-3 whitespace-nowrap">
                            <a @click="handelDeleteBook(book.id)"
                                class="text-red-600 cursor-pointer">Delete</a>
                        </td>
                    </tr>
                </tbody>

            </table>

            <!-- Pagination -->
            <div class="text-center my-3">
                <TailwindPagination :data="booksData" @pagination-change-page="getAllBooks" />
            </div>

        </div>

    </div>

</template>

<script setup>
import { onMounted, ref } from 'vue';
import { deleteBook } from '@/services/bookService';
import { fetchBooksWithUsers } from '@/services/adminService';
import TailwindPagination from '@/components/TailwindPagination/TailwindPagination.vue'
import { toast } from 'vue3-toastify';

const booksData = ref({});

// Function to fetch all books
async function getAllBooks(page = 1) {

    const booksResult = await fetchBooksWithUsers(page)
    if (booksResult.status === 200) {
        booksData.value = booksResult.data
    } else {
        toast.error('An unknown error occurred.', { "theme": "colored" });
    }

}

// Function to delete book
async function handelDeleteBook(bookId) {
    await deleteBook(bookId)
    await getAllBooks()
    toast.success('تم حذف الاعلان بنجاح', { "theme": "colored" })
}

onMounted(() => {
    getAllBooks()

})


</script>