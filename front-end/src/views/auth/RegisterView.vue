<template>

    <div class="container mx-auto">
        <div class="bg-gray-200 p-5 m-14 rounded-lg">
            <h1 class="text-2xl text-center font-bold">حساب جديد</h1>

            <form method="post" @submit.prevent="handelRegister">

                <div class="bg-red-500 text-white rounded-lg px-2">
                    <ul v-if="user.errors">
                        <li v-for="error in user.errorMessages">{{ error[0] }}</li>
                    </ul>
                </div>

                <div class="bg-green-500 text-white rounded-lg px-2">
                    <ul v-if="!user.errors">
                        <li>{{ user.successMessage }}</li>
                    </ul>
                </div>

                <div class="flex flex-col">
                    <label class="m-1 text-sm">الاسم</label>
                    <input type="name" v-model="formData.name"
                        class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
                    <span class="text-red-500" v-for="error in v$.name.$errors">{{ error.$message }}</span>
                </div>

                <div class="flex flex-col">
                    <label class="m-1 text-sm">الايميل</label>
                    <input type="email" v-model="formData.email"
                        class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
                    <span class="text-red-500" v-for="error in v$.email.$errors">{{ error.$message }}</span>
                </div>

                <div class="flex flex-col">
                    <label class="m-1 text-sm">رقم الهاتف</label>
                    <div class="flex">

                        <select v-model="formData.country_code"
                            class="bg-white text-sm h-[27px] w-20 outline-none rounded-lg px-1">
                            <option v-for="i, n in countryCodeList" :value="i">{{ n }}</option>
                            <option value="">الدولة</option>
                        </select>

                        <input type="text" v-model="formData.phone_number"
                            class="bg-white text-sm w-full h-[27px] outline-none rounded-lg px-1" />

                    </div>
                    <span class="text-red-500" v-for="error in v$.phone_number.$errors">{{ error.$message }}</span>
                </div>

                <div class="flex flex-col">
                    <label class="m-1 text-sm">كلمة المرور</label>
                    <input type="password" v-model="formData.password"
                        class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
                    <span class="text-red-500" v-for="error in v$.password.$errors">{{ error.$message }}</span>
                </div>

                <div class="mt-5 flex flex-col items-center gap-y-2">
                    <Button type="submit" color="blue">انشاء الحساب</Button>
                    <RouterLink :to="{ name: 'Login' }" class="text-blue-600 hover:text-blue-500 text-sm">تسجل الدخول
                    </RouterLink>
                </div>
            </form>

        </div>
    </div>


</template>

<script setup>
import countryCodes from 'country-codes-list'
import Button from '@/components/Button.vue'
import { useVuelidate } from '@vuelidate/core'
import { required, email, minLength, numeric } from '@vuelidate/validators'
import { useUserStore } from '@/stores/user.js'
import { ref } from 'vue';
const user = useUserStore();

const countryCodeList = countryCodes.customList('countryNameEn', '{countryCallingCode}')

const formData = ref({
    name: '',
    email: '',
    country_code:'',
    phone_number: '',
    password: ''
})

//form rules validation
const rules = {
    name: { required },
    email: { required, email },
    country_code: {required,numeric},
    phone_number: { required, numeric },
    password: { required, minLength: minLength(8) }
}

const v$ = useVuelidate(rules, formData)

async function handelRegister() {
    const result = await v$.value.$validate()
    if (result) {
        await user.registerResult(formData.value)
    }
}
</script>