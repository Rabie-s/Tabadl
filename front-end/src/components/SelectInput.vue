<template>
    <label class="m-1 text-sm">{{ label }}</label>
    <select :value="props.modelValue" @input="emit('update:modelValue', $event.target.value)"
        class="w-full bg-white text-sm h-[27px] outline-none rounded-lg px-1">
        <option v-for="option in options" :value="option.value">{{ option.name }}</option>
    </select>
</template>

<script setup>
const props = defineProps({
    label: {
        type: String
    },
    options: {
        type: Object
    },
    modelValue: {
        type: String
    }
})

const emit = defineEmits(['update:modelValue'])


/* 
EXAMPLE
const options1 = [
    { name: "Ahmad", value: 1 },
    { name: "Mohammad", value: 2 }
] */

</script>