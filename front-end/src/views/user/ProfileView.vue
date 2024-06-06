<template>

    <div class="flex">

        <div>
            <SideNav :toggleSideNav="toggleSideNav" />
        </div>

        <div class="text-left m-2">
            <button @click="toggleSideNav = !toggleSideNav" class="text-2xl">
                <i class="fa-solid fa-bars"></i>
            </button>

        </div>

        <div class="container mx-auto">
            <router-view />
        </div>


    </div>

</template>

<script setup>
import SideNav from '@/components/SideNav.vue';
import { ref } from 'vue'

const toggleSideNav = ref(false)
</script>