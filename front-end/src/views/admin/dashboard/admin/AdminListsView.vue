<template>

    <div class="my-10 p-5 rounded-lg bg-slate-100 drop-shadow-2xl">
        <h1 class="text-center font-bold text-3xl uppercase">Admin lists</h1>
    </div>

    <div class="bg-white rounded-lg">

        <div class="overflow-auto rounded-lg shadow">
            <table class="text-black w-full">
                <thead class="border-b-2 bg-gray-200">
                    <tr>
                        <th class="text-left text-lg p-2">#</th>
                        <th class="text-left text-lg p-2">Name</th>
                        <th class="text-left text-lg p-2">Email</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(admin, index) in adminsData.data" class="odd:bg-gray-100">
                        <td class="text-base p-2 mb-5 whitespace-nowrap">{{ index + 1 }}</td>
                        <td class="text-base p-2 mb-5 whitespace-nowrap">{{ admin.name }}</td>
                        <td class="text-base p-2 mb-5 whitespace-nowrap">{{ admin.email }}</td>
                        <td class="space-x-3 whitespace-nowrap">
                            <a @click="handelDeleteAdmin(admin.id)"
                                class="text-red-600 cursor-pointer">Delete</a>
                        </td>
                    </tr>
                </tbody>

            </table>

            <!-- Pagination -->
            <div class="text-center my-3">
                <TailwindPagination :data="adminsData" @pagination-change-page="getAllAdmins" />
            </div>


        </div>

    </div>

</template>

<script setup>
import { onMounted, ref } from 'vue';
import { fetchAdmins,deleteAdmin } from '@/services/admin/adminService';
import TailwindPagination from '@/components/TailwindPagination/TailwindPagination.vue'
import { toast } from 'vue3-toastify';

const adminsData = ref({});

// Function to fetch all books
async function getAllAdmins(page = 1) {

    const adminsResult = await fetchAdmins(page)
    if (adminsResult.status === 200) {
        adminsData.value = adminsResult.data
    } else {
        toast.error('An unknown error occurred.', { "theme": "colored" });
    }

}

// Function to delete book
async function handelDeleteAdmin(adminId) {
    await deleteAdmin(adminId)
    await getAllAdmins()
    toast.success('تم حذف الاعلان بنجاح', { "theme": "colored" })
}


onMounted(() => {
    getAllAdmins()

})


</script>