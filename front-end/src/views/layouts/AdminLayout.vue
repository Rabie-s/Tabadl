<template>

    <div class="flex">
        <div>
            <AdminSideNav />
        </div>

        <div class="container mx-auto">
            <RouterView />
        </div>
    </div>

</template>
<script setup>

import AdminSideNav from '@/components/adminComponents/AdminSideNav.vue'

</script>