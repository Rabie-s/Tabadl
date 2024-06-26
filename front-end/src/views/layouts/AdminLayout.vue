<template>

    <div class="flex">

        <div>
            <AdminSideNav :toggleSideNav="toggleSideNav" />
        </div>

        <div class="container mx-auto">
            <RouterView />
        </div>

        <i @click="toggleSideNav = !toggleSideNav" class="fa-solid fa-bars text-2xl h-7 m-5"></i>

    </div>

</template>
<script setup>
import { ref } from 'vue';
import AdminSideNav from '@/components/adminComponents/AdminSideNav.vue'

const toggleSideNav = ref(true)
</script>