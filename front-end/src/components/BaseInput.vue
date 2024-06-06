<template>
    <div class="flex flex-col">
        <label class="m-1 text-sm">{{ label }}</label>
        <input v-bind="$attrs" :value="props.modelValue" @input="emit('update:modelValue', $event.target.value)" class="bg-white text-sm h-[27px] outline-none rounded-lg px-1">
    </div>
</template>

<script setup>


const props = defineProps({
    label:{
        type:String
    },
    modelValue:{
        type:String
    }
})

const emit = defineEmits(['update:modelValue'])



</script>