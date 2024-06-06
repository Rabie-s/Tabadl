<script setup>
import { RouterView } from 'vue-router'
import NavBar from './components/NavBar.vue';
</script>

<template>
  <NavBar/>
  <div class="font-cairo" dir="rtl">
    <RouterView />
  </div>
  
</template>
