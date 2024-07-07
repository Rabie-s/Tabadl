<template>
    <nav class="z-30">

        <div v-show="props.toggleSideNav" class="w-[288px] h-screen bg-slate-900">

            <!-- logo -->
            <div class="p-4">
                <h1 class="text-3xl text-white uppercase font-bold">Dashboard</h1>
            </div>
            <!-- end-logo -->

            <!-- menu-with-sub-menu -->
            <div class="group p-2">
                <div class="group flex items-center justify-between cursor-pointer hover:bg-slate-400 rounded-lg p-2">
                    <div class="flex text-white items-center text-xl gap-x-2">
                        <i class="fa-solid fa-user"></i>
                        <h4>Admins</h4>
                    </div>
                    <i class="fa-solid fa-caret-down text-white text-xl group-hover:rotate-180"></i>
                </div>

                <div class="bg-slate-700 text-white rounded-lg hidden group-hover:block">
                    <RouterLink :to="{ name: 'AdminLists' }">
                        <h1 class="text-base mt-1 rounded-lg p-1 cursor-pointer hover:text-black hover:bg-white">
                            Admins
                        </h1>
                    </RouterLink>

                    <RouterLink :to="{ name: 'AddAdmin' }">
                        <h1 class="text-base mt-1 rounded-lg p-1 cursor-pointer hover:text-black hover:bg-white">
                            Create Admin
                        </h1>
                    </RouterLink>
                </div>
            </div>
            <!-- end-menu-with-sub-menu -->

            <!-- menu -->
            <div class="mt-2 p-1">
                <RouterLink :to="{ name: 'AdminHome' }">
                    <div
                        class="flex text-white items-center text-xl gap-x-2 p-2 rounded-lg cursor-pointer hover:bg-slate-400">
                        <i class="fa-solid fa-house"></i>
                        <h4>Home</h4>
                    </div>
                </RouterLink>
            </div>
            <!-- end-menu -->

            <!-- menu -->
            <div class="mt-2 p-1">
                <RouterLink :to="{ name: 'UserLists' }">
                    <div
                        class="flex text-white items-center text-xl gap-x-2 p-2 rounded-lg cursor-pointer hover:bg-slate-400">
                        <i class="fa-solid fa-user"></i>
                        <h4>Users</h4>
                    </div>
                </RouterLink>


            </div>
            <!-- end-menu -->

            <!-- menu -->
            <div class="mt-2 p-1">
                <RouterLink :to="{ name: 'BookLists' }">
                    <div
                        class="flex text-white items-center text-xl gap-x-2 p-2 rounded-lg cursor-pointer hover:bg-slate-400">
                        <i class="fa-solid fa-book"></i>
                        <h4>Books</h4>
                    </div>
                </RouterLink>
            </div>
            <!-- end-menu -->

            <!-- profile-with-logout -->
            <div class="fixed w-72 bottom-0">
                <div class="flex items-center justify-between bg-slate-500 m-2 p-4 rounded-lg">
                    <h3 v-if="admin.isAuth === true" class="text-xl text-white">{{ admin.adminData.name }}</h3>
                    <a class="text-white hover:text-gray-200 cursor-pointer" @click="handelLogout">Log-out</a>
                </div>
            </div>
            <!-- end-profile-with-logout -->

        </div>
    </nav>


</template>

<script setup>
import { useAdminStore } from '@/stores/admin.js'

const admin = useAdminStore()

function handelLogout() {
    admin.logoutResult();
}

const props = defineProps({
    toggleSideNav: {
        type: Boolean,
    }

})

</script>