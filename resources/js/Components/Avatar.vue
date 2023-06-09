<script setup>
import { computed, ref, watchEffect } from "vue";
import { cva } from "class-variance-authority";

const props = defineProps({
    name: String,
    src: String,
    initials: String,
    size: {
        type: String,
        validator:(value) => ["sm", "base", "lg"].includes(value),
        default: "base"
    },
    shape: {
        type: String,
        validator:(value) => ["circle", "square"].includes(value),
        default: "circle"
    }
})

const verifiedSrc = ref(null)
watchEffect(() => {
    const img = new Image()
    img.src = props.src
    img
        .decode()
        .then( () => verifiedSrc.value = props.src)
        .catch(e => {
            verifiedSrc.value = null
            throw e
        })
})

const fallback = computed(() => {
    return props.initials || props.name?.charAt(0) || "?"
})

const containerClass = computed(() => {
    return cva("inline-flex items-center justify-center font-bold text-slate-700 select-none shrink-0 bg-slate-200 overflow-hidden", {
        variants: {
            size: {
                sm: "text-xs h-8 w-8",
                base: "text-xl h-12 w-12",
                lg: "text-5xl h-28 w-28",

            },
            shape: {
                circle: "rounded-full",
                square: "rounded",
            },
        },
    })({size: props.size, shape: props.shape})
})

const innerBorderClass = computed(() => {
    return cva("absolute border border-black/5", {
        variants: {
            shape: {
                circle: "rounded-full",
                square: "rounded",
            },
        },
    })({shape: props.shape})
})
</script>

<template>
    <span :class="containerClass" :title="props.name">
        <img
            class="h-full w-full object-fill bg-blue-900 bg-opacity-50 backdrop-filter backdrop-blur-lg"
            v-if="props.src"
            :src="verifiedSrc"
            :alt="props.name"
        >
        <template v-else>{{ fallback }}</template>

        <span :class="innerBorderClass"></span>
    </span>
</template>
