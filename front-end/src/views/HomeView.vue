<template>
    <div class="flex justify-center">
        <img class="w-96 rounded-xl" src="../assets/images/students_09.jpg">
    </div>

    <div class="container mx-auto">

        <p class="text-2xl tracking-wide text-center my-5">
            موقع 'تبادل' للكتب الجامعية يقدم لك فرصة التخلص من الكتب التي لم تعد تحتاجها، مما يُمكّنك من تحرير مساحة في
            مكتبتك والتخلص من الكتب التي لن تستخدمها مرة أخرى. في الوقت ذاته، يوفر لك الموقع الفرصة لاكتشاف والحصول على
            الكتب التي تحتاجها بسهولة، مما يُسهّل عليك العثور على المراجع والمصادر الضرورية لدراستك وأبحاثك الأكاديمية.
            بفضل هذا النهج الشامل، يُمكنك الاستفادة القصوى من مكتبتك الشخصية وتحقيق التوازن بين الحفاظ على الموارد
            والاستفادة منها بشكل فعّال.
        </p>

        <div class="flex justify-center">
            <Button class=" w-40" color="blue">
                <RouterLink :to="{ name: 'Books' }">صفحة
                    الكتب</RouterLink>
            </Button>


        </div>


    </div>

</template>

<script setup>
import Button from '@/components/Button.vue';
</script>
