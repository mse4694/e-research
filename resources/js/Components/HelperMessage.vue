<script setup>
import { QuestionMarkCircleIcon } from "@heroicons/vue/20/solid";
</script>

<template>
    <p>
        <span class="inline-flex mt-1 items-center text-xs font-medium text-label text-gray-600 truncate">
            <QuestionMarkCircleIcon class="w-5 h-5"/>
            <slot></slot>
        </span>
    </p>
</template>
