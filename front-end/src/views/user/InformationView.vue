<template>

    <div class="bg-gray-200 p-5 m-14 rounded-lg">
        <h1 class="text-2xl text-center font-bold">معلومات الحساب</h1>

        <div class="flex flex-col">
            <label class="m-1 text-sm">الاسم</label>
            <input disabled v-model="formData.name" type="text"
                class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
        </div>

        <div class="flex flex-col">
            <label class="m-1 text-sm">الايميل</label>
            <input disabled v-model="formData.email" type="email"
                class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
        </div>

        <div class="flex flex-col">
            <label class="m-1 text-sm">رقم الهاتف</label>
            <input disabled v-model="formData.phone_number" type="text"
                class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
        </div>

    </div>

</template>

<script setup>
import { ref } from 'vue';
import { useUserStore } from '@/stores/user.js'
const user = useUserStore();

const formData = ref({
    name: user.userData.name,
    email: user.userData.email,
    phone_number: user.userData.phone_number,
})

</script>