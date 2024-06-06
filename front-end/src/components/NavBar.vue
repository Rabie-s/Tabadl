<template>
    <nav class="flex items-center justify-between flex-wrap bg-sky-600 p-6">
        <div class="flex items-center flex-shrink-0 text-white mr-6">
            <span class="text-2xl tracking-tight uppercase font-bold">Tabadl</span>
        </div>
        <div class="block lg:hidden">
            <button @click="isOpen = !isOpen" class="text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path v-if="!isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16m-7 6h7" />
                    <path v-if="isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div :class="{ 'hidden': !isOpen, 'block': isOpen }"
            class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">

            <div class="text-sm lg:flex-grow">

                <!-- navigation links  -->
                <RouterLink :to="{ name: 'Home' }"
                    class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-gray-300 mr-4 cursor-pointer">الصفحة
                    الرئيسيه</RouterLink>

                <RouterLink :to="{ name: 'Books' }"
                    class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-gray-300 mr-4 cursor-pointer">صفحة
                    الكتب</RouterLink>


                <template v-if="user.isAuth">
                    <RouterLink :to="{ name: 'AddBook' }"
                        class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-gray-300 mr-4 cursor-pointer">
                        اضافة
                        كتاب</RouterLink>
                </template>


            </div>

            <div>
                <template v-if="!user.isAuth">
                    <RouterLink :to="{ name: 'Login' }"
                        class="ml-1 inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-gray-800 hover:bg-white mt-4 lg:mt-0">
                        تسجيل الدخول</RouterLink>
                    <RouterLink :to="{ name: 'Register' }"
                        class="ml-1 inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-gray-800 hover:bg-white mt-4 lg:mt-0">
                        حساب جديد</RouterLink>
                </template>

                <template v-if="user.isAuth">


                    <button @click="handelLogout"
                        class="ml-1 inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-gray-800 hover:bg-white mt-4 lg:mt-0">تسجيل
                        الخروج</button>
                    <RouterLink :to="{ name: 'Info' }"
                        class="ml-1 inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-gray-800 hover:bg-white mt-4 lg:mt-0">
                        {{ user.userData.name }}</RouterLink>

                </template>

            </div>

        </div>
    </nav>
</template>

<script setup>
import { ref } from 'vue';
import { useUserStore } from '@/stores/user.js'

const user = useUserStore()
const isOpen = ref(false)
const subMenue = ref(false)

function handelLogout() {
    user.logoutResult();
}

</script>