<template>
    <!--if prop color is yellow-->
    <button v-bind="$attrs" v-if="props.color === 'yellow'"
        class="bg-yellow-600 hover:bg-yellow-500 text-white w-[135px] h-[35px] flex justify-center items-center rounded-lg">
        <slot />
    </button>

    <!--if prop color is red-->
    <button v-bind="$attrs" v-if="props.color === 'red'"
        class="bg-red-600 hover:bg-red-500 text-white w-[135px] h-[35px] flex justify-center items-center rounded-lg">
        <slot />
    </button>

    <!--if prop color is blue-->
    <button v-bind="$attrs" v-if="props.color === 'blue'"
        class="bg-sky-600 hover:bg-sky-500 text-white w-[135px] h-[35px] flex justify-center items-center rounded-lg">
        <slot />
    </button>

    <!--if prop color is green-->
    <button v-bind="$attrs" v-if="props.color === 'green'"
        class="bg-green-600 hover:bg-green-500 text-white w-[135px] h-[35px] flex justify-center items-center rounded-lg">
        <slot />
    </button>

</template>

<script setup>

const props = defineProps({
    color: {
        type: String,
        default: 'blue'
    }

})


</script>