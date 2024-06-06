<template>

    <div class="container mx-auto">
        <div class="bg-gray-200 p-5 m-14 rounded-lg">
            <h1 class="text-2xl text-center font-bold">تسجيل الدخول</h1>

            <form method="post" @submit.prevent="handelLogin">

                <div class="bg-red-500 text-white rounded-lg px-2">
                    <ul v-if="user.errors">
                        <li v-for="error in user.errorMessages">{{ error }}</li>
                    </ul>
                </div>

                <div class="bg-green-500 text-white rounded-lg px-2">
                    <ul v-if="!user.errors">
                        <li>{{ user.successMessage }}</li>
                    </ul>
                </div>

                <div class="flex flex-col">
                    <label class="m-1 text-sm">الايميل</label>
                    <input type="email" v-model="formData.email"
                        class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
                    <span class="text-red-500" v-for="error in v$.email.$errors">{{ error.$message }}</span>
                </div>

                <div class="flex flex-col">
                    <label class="m-1 text-sm">كلمة المرور</label>
                    <input type="password" v-model="formData.password"
                        class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
                    <span class="text-red-500" v-for="error in v$.password.$errors">{{ error.$message }}</span>
                </div>

                <div class="mt-5 flex flex-col items-center gap-y-2">
                    <Button type="submit" color="blue">تسجيل الدخول</Button>
                    <RouterLink :to="{ name: 'Register' }" class="text-blue-600 hover:text-blue-500 text-sm">انشاء حساب
                        جديد
                    </RouterLink>
                </div>
            </form>
        </div>
    </div>


</template>

<script setup>
import Button from '@/components/Button.vue';
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { useUserStore } from '@/stores/user.js'
import { ref } from 'vue';
const user = useUserStore();


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
    if (result) {
        await user.loginResult(formData.value)
    }

}

</script>