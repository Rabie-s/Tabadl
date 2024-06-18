<template>

    <div class="container mx-auto">
        <div class="bg-gray-200 p-5 m-14 rounded-lg">
            <h1 class="text-2xl text-center font-bold">Admin login</h1>

            <form method="post" @submit.prevent="handelLogin">

                <div class="flex flex-col">
                    <label class="m-1 text-sm">Email</label>
                    <input type="email" v-model="formData.email"
                        class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
                    <span class="text-red-500" v-for="error in v$.email.$errors">{{ error.$message }}</span>
                </div>

                <div class="flex flex-col">
                    <label class="m-1 text-sm">Password</label>
                    <input type="password" v-model="formData.password"
                        class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
                    <span class="text-red-500" v-for="error in v$.password.$errors">{{ error.$message }}</span>
                </div>

                <div class="mt-5 flex flex-col items-center gap-y-2">
                    <Button type="submit" color="blue">Login</Button>
                </div>
            </form>
        </div>
    </div>


</template>

<script setup>
import Button from '@/components/Button.vue';
import { useAdminStore } from '@/stores/admin.js'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { ref } from 'vue';

const admin = useAdminStore();

const formData = ref({
    email: '',
    password: ''
})
//form rules validation
const rules = {
    email: { required, email },
    password: { required }
}
const v$ = useVuelidate(rules, formData)


async function handelLogin() {
    const result = await v$.value.$validate()
    //if no errors 
    if(result){
        await admin.loginResult(formData.value)
    }
    

}

</script>