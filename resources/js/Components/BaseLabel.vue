<script setup>
const props = defineProps({
    for: {
        type: String,
        default: ''
    },
    required: Boolean
})
</script>

<template>
    <label
        :for="props.for"
        class="block text-sm font-semibold text-label text-gray-800 truncate"
    >
        <slot />
        <span
            class=" text-red-600"
            v-if="props.required"
        >
            *
        </span>
    </label>
</template>
