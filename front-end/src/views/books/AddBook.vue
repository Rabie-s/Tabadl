<template>
    <div class="container mx-auto">
        <div class="bg-gray-200 p-5 m-14 rounded-lg">
            <h1 class="text-2xl text-center font-bold">طلب او عرض كتاب لا تحتاجة</h1>

            <form @submit.prevent="submit" method="post">
                <!-- Image Input -->
                <div class="flex flex-col">
                    <label class="m-1 text-sm">صورة الغلاف</label>
                    <input ref="inputImage" accept=".png, .jpg, .jpeg" @change="onFileChange" type="file"
                        class="outline outline-none rounded w-full p-1 file:bg-sky-600 hover:file:bg-sky-500 file:p-2 file:rounded-lg file:text-white file:outline-none file:border-0 file:cursor-pointer" />
                    <span class="text-red-500" v-for="error in v$.image.$errors">{{ error.$message }}</span>
                </div>

                <!-- Title Input -->
                <div class="flex flex-col">
                    <label class="m-1 text-sm">اسم الكتاب</label>
                    <input v-model="formData.title" class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
                    <span class="text-red-500" v-for="error in v$.title.$errors">{{ error.$message }}</span>
                </div>

                <!-- Description Input -->
                <div class="flex flex-col">
                    <label class="m-1 text-sm">وصف قصير</label>
                    <input v-model="formData.description"
                        class="bg-white text-sm h-[27px] outline-none rounded-lg px-1" />
                    <span class="text-red-500" v-for="error in v$.description.$errors">{{ error.$message }}</span>
                </div>

                <!-- Book type Select -->
                <div class="flex flex-col">
                    <label class="m-1 text-sm">نوع الكتاب</label>
                    <select v-model="formData.bookLevel"
                        class="w-full bg-white text-sm h-[27px] outline-none rounded-lg px-1">
                        <option value="1">دبلوم</option>
                        <option value="2">بكالوريوس</option>
                    </select>
                    <span class="text-red-500" v-for="error in v$.status.$errors">{{ error.$message }}</span>
                </div>

                <!-- Status Select -->
                <div class="flex flex-col">
                    <label class="m-1 text-sm">طلب ولا عرض؟</label>
                    <select v-model="formData.status"
                        class="w-full bg-white text-sm h-[27px] outline-none rounded-lg px-1">
                        <option value="1">معروض</option>
                        <option value="2">مطلوب</option>
                    </select>
                    <span class="text-red-500" v-for="error in v$.status.$errors">{{ error.$message }}</span>
                </div>

                <!-- Submit Button -->
                <div class="mt-5 flex flex-col items-center gap-y-2">
                    <Button type="submit" color="blue">نشر</Button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import Button from '@/components/Button.vue'
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import { ref } from 'vue'

import { toast } from 'vue3-toastify';
import { useUserStore } from '@/stores/user.js'
import ImageCompressor from 'js-image-compressor'
import { addBook } from '@/services/bookService';

const user = useUserStore();
const inputImage = ref(null)
const formData = ref({
    image: '',
    imageExtension: '',
    title: '',
    bookLevel: '',
    status: '',
    description: '',
})

// Catch a file inside file input
async function onFileChange(e) {
    const file = await e.target.files[0]
    const fileExtension = file.name.split(".").pop()
    formData.value.imageExtension = fileExtension

    var options = {
        file: file,
        quality: 0.6,
        maxWidth: 2000,
        maxHeight: 2000,
        minWidth: 500,
        minHeight: 500,
        convertSize: Infinity,
        loose: true,
        redressOrientation: true,

        // Compression success callback
        success: function (result) {
            formData.value.image = result
        },

        // An error occurred
        error: function (msg) {
            console.error(msg);
        }
    };

    new ImageCompressor(options);
}

// Form rules validation
const rules = {
    image: { required },
    title: { required },
    bookLevel: { required },
    status: { required },
    description: {  }
}

const v$ = useVuelidate(rules, formData)

async function submit() {

    const result = await v$.value.$validate()

    if (result) {
        const addBookResult = await addBook(formData, user.userData.id)
        if (addBookResult === 200) {
            toast.success('تم نشر الاعلان بنجاح', { "theme": "colored" })
            clear()
        } else {
            toast.error('An unknown error occurred.', { "theme": "colored" });
        }
    }


}

function clear() {
    formData.value.image = ''
    formData.value.title = ''
    formData.value.bookLevel = ''
    formData.value.status = ''
    formData.value.description = ''
    inputImage.value.value = null
    v$.value.$reset()
}
</script>