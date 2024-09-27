<template>

    <div class="">

        <div class="absolute top-0">
            <SideNav :toggleSideNav="toggleSideNav" />
        </div>

        <div class="m-3">
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