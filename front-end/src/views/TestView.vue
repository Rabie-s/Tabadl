<template>

</template>

<script setup>
import {fetchUserBooks} from '@/services/user/bookService.js'
import { onMounted } from 'vue';

async function handel(){
    return await fetchUserBooks();
}

onMounted(()=>{
    console.log(handel());
    
})

</script>
