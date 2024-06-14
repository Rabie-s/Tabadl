<template>
    <nav class="z-30">

        <div v-show="props.toggleSideNav" class="w-[288px] h-screen bg-sky-600">
            
            <!-- logo -->
            <div class="p-4">
                <h1 class="text-3xl text-white uppercase font-bold">حسابي</h1>
            </div>
            <!-- end-logo -->

            <!-- menu -->
            <div class="mt-2 p-1">
                <RouterLink :to="{ name: 'Info' }">
                    <div
                        class="flex text-white items-center text-xl gap-x-2 p-2 rounded-lg cursor-pointer hover:bg-sky-500">
                        <i class="fa-solid fa-house"></i>
                        <h4>معلوماتي الشخصية</h4>
                    </div>
                </RouterLink>
            </div>
            <!-- end-menu -->

            <!-- menu -->
            <div class="mt-2 p-1">
                <RouterLink :to="{ name: 'UserBooks' }">
                    <div
                        class="flex text-white items-center text-xl gap-x-2 p-2 rounded-lg cursor-pointer hover:bg-sky-500">
                        <i class="fa-solid fa-house"></i>
                        <h4>اعلاناتي</h4>
                    </div>
                </RouterLink>
            </div>
            <!-- end-menu -->

        </div>
    </nav>


</template>

<script setup>
const props = defineProps({
    toggleSideNav: {
        type: Boolean,
    }

})

</script>