<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 p-16 mt-9">

        <div class="text-center bg-emerald-600 text-white shadow-2xl p-7 rounded-lg">
            <span class="block text-4xl">{{ totalUsersCounter }}</span>
            <span class="block text-2xl">Users</span>
        </div>

        <div class="text-center bg-sky-600 text-white shadow-2xl p-7 rounded-lg">
            <span class="block text-4xl">{{ totalBooksCounter }}</span>
            <span class="block text-2xl">Books</span>
        </div>

    </div>
</template>
<script setup>

import { onMounted, ref } from 'vue';
import { countTotalBooks, countTotalUsers } from '@/services/admin/adminService';
const totalBooksCounter = ref(0)
const totalUsersCounter = ref(0)

async function handelStatistic() {
    const totalBooks = await countTotalBooks();
    const totalUsers = await countTotalUsers();
    totalBooksCounter.value = totalBooks.data;
    totalUsersCounter.value = totalUsers.data;
}

onMounted(() => {
    handelStatistic()
})


</script>