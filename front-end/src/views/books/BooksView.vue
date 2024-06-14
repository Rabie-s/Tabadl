<template>
    <div class="container mx-auto">
        <!-- Filter section -->
        <div class="bg-gray-200 p-1 rounded-lg m-3">
            <div>
                <label class="m-1 text-sm">طلب ولا عرض؟</label>
                <select @change="getAllBooks" v-model="filters.status"
                    class="bg-white text-sm h-[27px] outline-none rounded-lg px-1">
                    <option value="">الكل</option>
                    <option value="1">معروض</option>
                    <option value="2">مطلوب</option>
                </select>
            </div>
        </div>

        <!-- Search section -->
        <div class="bg-gray-200 p-1 rounded-lg m-3 flex gap-x-2">
            <label class="m-1 text-sm">بحث</label>
            <input v-model="filters.search" @keyup="resat" class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
            <Button @click="getAllBooks" class="h-auto" color="blue">بحث</Button>
        </div>

        <!-- Book display section -->
        <div class="flex flex-col">
            <div v-for="(book, index) in booksData.data" :key="book.id" class="bg-gray-200 p-2 m-2 rounded-lg">
                <div class="flex items-center gap-x-3">
                    <img class="w-[132px] h-[109px] rounded-lg" :src="imagePath + book.image_path" />
                    <div class="w-full flex flex-col gap-y-2">
                        <h2 class="text-lg">{{ book.title }}</h2>
                        <router-link :to="{ name: 'Book', params: { id: book.id } }">
                            <Button class="w-full" color="blue">عرض</Button>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="text-center my-3">
            <TailwindPagination :data="booksData" @pagination-change-page="getAllBooks" />
        </div>
    </div>
</template>

<script setup>
import Button from '@/components/Button.vue';
import TailwindPagination from '@/components/TailwindPagination/TailwindPagination.vue'
import { fetchBooks } from '@/services/bookService';

import { onMounted, ref } from 'vue';

const imagePath = import.meta.env.VITE_IMAGE_PATHS

const filters = ref({
    status: '',
    search: ''
})
const booksData = ref({});


// Function to fetch all books
async function getAllBooks(page = 1) {

    const booksResult = await fetchBooks(page, filters.value.status, filters.value.search)
    if (booksResult.status === 200) {
        booksData.value = booksResult.data
    } else {
        toast.error('An unknown error occurred.', { "theme": "colored" });
    }

}

function resat(){
    if(filters.value.search==''){
        getAllBooks()
    }
}

// Fetch all books on component mount
onMounted(() => {
    getAllBooks();
});

</script>