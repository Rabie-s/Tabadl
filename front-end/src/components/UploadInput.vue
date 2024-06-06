<template>
    <div class="flex flex-col">
        <label class="m-1 text-sm">{{ label }}</label>
        <input v-bind="$attrs" type="file"
            class="outline outline-none rounded w-full p-1 file:bg-sky-600 hover:file:bg-sky-500 file:p-2 file:rounded-lg file:text-white file:outline-none file:border-0 file:cursor-pointer">
    </div>

</template>

<script setup>
const props = defineProps({
    label: {
        type: String
    }
})

</script>