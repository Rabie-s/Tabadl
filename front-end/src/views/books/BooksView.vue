<template>
    <div class="container mx-auto">
        <!-- Filter section -->
        <div class="flex gap-x-4 bg-gray-200 p-1 rounded-lg m-3">
            <div>
                <label class="m-1 text-sm">طلب ولا عرض؟</label>
                <select @change="getAllBooks" v-model="filters.status"
                    class="bg-white text-sm h-[27px] outline-none rounded-lg px-1">
                    <option value="">الكل</option>
                    <option value="1">معروض</option>
                    <option value="2">مطلوب</option>
                </select>
            </div>

            <div>
                <label class="m-1 text-sm">مرحلة الكتاب</label>
                <select @change="getAllBooks" v-model="filters.bookLevel"
                    class="bg-white text-sm h-[27px] outline-none rounded-lg px-1">
                    <option value="">الكل</option>
                    <option value="1">دبلوم</option>
                    <option value="2">بكالوريوس</option>
                </select>
            </div>
        </div>

        <!-- Search section -->
        <div class="bg-gray-200 p-1 rounded-lg m-3 flex gap-x-2">
            <label class="m-1 text-sm">بحث</label>
            <input v-model="filters.search" @keyup="resetSearch"
                class="bg-white text-sm h-[27px] outline-none rounded-lg px-1 w-full md:w-56" />
            <Button @click="getAllBooks" class="h-auto" color="blue">بحث</Button>
        </div>

        <!-- Book display section -->
        <div class="flex flex-col">
            <div v-for="(book, index) in booksData.data" :key="book.id" class="bg-gray-200 p-2 m-2 rounded-lg">
                <div class="flex items-center gap-x-3">
                    <img class="w-[132px] h-[109px] rounded-lg" :src="getImagePath(book.image_path)" />
                    <div class="w-full flex flex-col gap-y-2">
                        <h2 class="text-lg">{{ book.title }}</h2>
                        <div class="flex gap-x-10">
                            <h4 class="text-sm">المرحلة: {{ bookLevelText(book.book_level) }}</h4>
                            <h4 class="text-sm">الحالة: {{ statusText(book.status) }}</h4>
                        </div>
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
// Import Vue components and libraries
import Button from '@/components/Button.vue';
import TailwindPagination from '@/components/TailwindPagination/TailwindPagination.vue';
import { fetchBooks } from '@/services/bookService';
import { toast } from 'vue3-toastify';
import { onMounted, ref, computed } from 'vue';

// Define constant for image path
const imagePath = import.meta.env.VITE_IMAGE_PATHS;

// Define reactive variables
const filters = ref({
    status: '',
    bookLevel: '',
    search: ''
});

const booksData = ref({});

// Function to fetch all books with error handling
async function getAllBooks(page = 1) {
    try {
        // Call fetchBooks API with current filters and page
        const booksResult = await fetchBooks(page, filters.value.status, filters.value.bookLevel, filters.value.search);

        // Check if API call was successful
        if (booksResult.status === 200) {
            // Update booksData with fetched data
            booksData.value = booksResult.data;
        } else {
            // Display error toast if API call fails
            toast.error('Failed to fetch books. Please try again later.', { theme: 'colored' });
        }
    } catch (error) {
        // Log error to console and display generic error toast
        console.error('Error fetching books:', error);
        toast.error('An unexpected error occurred. Please try again later.', { theme: 'colored' });
    }
}

// Reset search function
function resetSearch() {
    // Check if search input is empty
    if (!filters.value.search) {
        // Call getAllBooks to fetch all books again
        getAllBooks();
    }
}

// Function to get full image path for a book
function getImagePath(imagePathFromServer) {
    return `${imagePath}${imagePathFromServer}`;
}

// Computed properties to translate numeric values to human-readable text
const bookLevelText = (bookLevel) => {
    switch (bookLevel) {
        case 1:
            return 'دبلوم';
        case 2:
            return 'بكالوريوس';
        default:
            return 'غير معروفة';
    }
};

const statusText = (bookStatus) => {
    switch (bookStatus) {
        case 1:
            return 'معروض';
        case 2:
            return 'مطلوب';
        default:
            return 'غير محددة';
    }
};

// Fetch all books when component is mounted
onMounted(() => {
    getAllBooks();
});

</script>