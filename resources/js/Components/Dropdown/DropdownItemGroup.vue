<script setup>
import { MenuItem } from '@headlessui/vue'

const props = defineProps({
    label: String
})
</script>

<template>
    <div :class="['px-1', props.label ? 'pt-5 pb-1' : 'py-1']">
        <div
            v-if="props.label" 
            class="mb-1.5 px-2 text-[11px] font-bold uppercase tracking-tight"
        >
            {{ props.label }}
        </div>
        <slot></slot>
    </div>

</template>