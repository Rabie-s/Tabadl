<template>
    <div class="h-screen flex justify-center">
        <div class="w-96 md:w-[52rem] lg:w-[72rem]">

            <div class="my-10 p-5 rounded-lg bg-slate-100 drop-shadow-2xl">
                <h1 class="text-center font-bold text-3xl uppercase">Add admin</h1>
            </div>

            <div class="p-4 bg-white rounded-lg drop-shadow-2xl">


                <div class="mb-3">
                    <h1 class="text-center text-black text-4xl uppercase">Create new admin</h1>
                </div>

                <div class="mb-3">
                    <label class="block text-base text-black mb-1">Name</label>
                    <input v-model="formData.name" class="outline outline-1 w-full px-1 rounded text-lg" type="text">
                    <span class="text-red-500" v-for="error in v$.name.$errors">{{ error.$message }}</span>
                </div>

                <div class="mb-3">
                    <label class="block text-base text-black mb-1">Email</label>
                    <input v-model="formData.email" class="outline outline-1 w-full px-1 rounded text-lg" type="email">
                    <span class="text-red-500" v-for="error in v$.email.$errors">{{ error.$message }}</span>
                </div>

                <div class="mb-3">
                    <label class="block text-base text-black mb-1">Password</label>
                    <input v-model="formData.password" class="outline outline-1 w-full px-1 rounded text-lg"
                        type="password">
                    <span class="text-red-500" v-for="error in v$.password.$errors">{{ error.$message }}</span>
                </div>

                <div class="mb-3">
                    <Button class="w-full" color="slate" @click="handelRegister">Add</Button color="slate">
                </div>
            </div>

        </div>

    </div>
</template>

<script setup>
import Button from '@/components/Button.vue';
import { register } from '@/services/admin/authAdminService'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { ref } from 'vue';
import { toast } from 'vue3-toastify';

const formData = ref({
    name: '',
    email: '',
    password: ''
})

//form rules validation
const rules = {
    name: { required },
    email: { required, email },
    password: { required }
}
const v$ = useVuelidate(rules, formData)

async function handelRegister() {
    const result = await v$.value.$validate()
    //if no errors 
    if (result) {
        const registerAdmin = await register(formData.value)
        if (registerAdmin.status === 200) {
            toast.success('Admin added successfully', { "theme": "colored" })
            clear()
        } else {
            toast.error('An unknown error occurred.', { "theme": "colored" });
        }

    }
}

function clear() {
    formData.value.name = ''
    formData.value.email = ''
    formData.value.password = ''
    v$.value.$reset()
}


</script>