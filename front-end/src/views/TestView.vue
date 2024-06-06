<template>
<button @click="onClick">Add</button>
</template>

<script setup>

import { completeBook } from '@/services/bookService';

function onClick(){
  completeBook(43,true)
}

</script>
