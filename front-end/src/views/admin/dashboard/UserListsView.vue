<template>

    <div class="my-10 p-5 rounded-lg bg-slate-100 drop-shadow-2xl">
        <h1 class="text-center font-bold text-3xl uppercase">User lists</h1>
    </div>

    <div class="bg-white rounded-lg">

        <div class="overflow-auto rounded-lg shadow">
            <table class="text-black w-full">
                <thead class="border-b-2 bg-gray-200">
                    <tr>
                        <th class="text-left text-lg p-2">#</th>
                        <th class="text-left text-lg p-2">Name</th>
                        <th class="text-left text-lg p-2">Email</th>
                        <th class="text-left text-lg p-2">Phone number</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(user, index) in usersData.data" class="odd:bg-gray-100">
                        <td class="text-base p-2 mb-5 whitespace-nowrap">{{ index + 1 }}</td>
                        <td class="text-base p-2 mb-5 whitespace-nowrap">{{ user.name }}</td>
                        <td class="text-base p-2 mb-5 whitespace-nowrap">{{ user.email }}</td>
                        <td class="text-base p-2 mb-5 whitespace-nowrap">{{ user.phone_number }}</td>
                    </tr>
                </tbody>

            </table>

            <!-- Pagination -->
            <div class="text-center my-3">
                <TailwindPagination :data="usersData" @pagination-change-page="getAllUsers" />
            </div>

        </div>

    </div>

</template>

<script setup>
import { onMounted, ref } from 'vue';
import { deleteBook } from '@/services/bookService';
import { fetchUsers } from '@/services/adminService';
import TailwindPagination from '@/components/TailwindPagination/TailwindPagination.vue'
import { toast } from 'vue3-toastify';

const usersData = ref({});

// Function to fetch all books
async function getAllUsers(page = 1) {

    const usersResult = await fetchUsers(page)
    if (usersResult.status === 200) {
        usersData.value = usersResult.data
    } else {
        toast.error('An unknown error occurred.', { "theme": "colored" });
    }

}

onMounted(() => {
    getAllUsers()

})


</script>