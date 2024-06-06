<template>
    <div class="bg-gray-200 p-2 m-2 rounded-lg">

        <div class="flex items-center gap-x-3">
            <img class="w-[132px] h-[109px] rounded-lg" :src="imgSrc" alt="">
            
            <div class="w-full flex flex-col gap-y-2">
                <h2 class="text-lg">{{ title }}</h2>
                <Button class="w-full" color="blue">عرض</Button>
            </div>
                  
        </div>
        
    </div>
</template>
<script setup>
import Button from './Button.vue';

const props = defineProps({
    imgSrc:{
        type: String
    },
    title:{
        type:String
    }
})

</script>