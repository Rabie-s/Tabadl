<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 p-16 mt-9">

        <div class="text-center bg-emerald-600 text-white shadow-2xl p-7 rounded-lg">
            <span class="block text-4xl">{{ totalUsers.data }}</span>
            <span class="block text-2xl">Users</span>
        </div>

        <div class="text-center bg-sky-600 text-white shadow-2xl p-7 rounded-lg">
            <span class="block text-4xl">{{ totalBooks.data }}</span>
            <span class="block text-2xl">Books</span>
        </div>

    </div>
</template>
<script setup>

import { computed, onMounted, ref } from 'vue';
import { getTotalBooks } from '@/services/statisticService'
import axios from 'axios';

const totalBooks = ref(0)
const totalUsers = ref(0)


onMounted(async () => {
    totalBooks.value = await axios.get(`v1/admin/statistics/totalBooks`)
    totalUsers.value = await axios.get(`v1/admin/statistics/totalUsers`)
})


</script>