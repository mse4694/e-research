<script setup>
import { computed } from "vue";
import { cva } from "class-variance-authority";

const props = defineProps ({
    leftIcon: Function,
    rightIcon: Function,
    loading: Boolean,
    disabled: Boolean,
    as: {
        type: [String, Object],
        default: "button",
    },
    intent: {
        type: String,
        validator: (val) => ["primary", "secondary", "success", "info", "warning", "danger", "text"].includes(val),
        default: "secondary",
    },
    size: {
        type: String,
        validator: (val) => ["mini", "small", "medium", "large", "xlarge"].includes(val),
        default: "small",
    }
});

const buttonClass = computed(() => {
    return cva(
        "inline-flex items-center justify-center rounded min-h-[32px] px-3 py-0.5 font-semibold",
        {
            variants: {
                intent: {
                    primary: "bg-black hover:bg-gray-800 text-white ",
                    secondary: "bg-black/5 hover:bg-black/10 text-gray-700",
                    info: "bg-blue-600 hover:bg-blue-500 text-white",
                    success: "bg-green-800 hover:bg-green-700 text-white",
                    warning: "bg-yellow-600 hover:bg-yellow-500 text-white",
                    danger: "bg-red-600 hover:bg-red-500 text-white",
                    text: "text-gray-700, hover:bg-black/5"
                },
                size: {
                    mini: "text-xs",
                    small: "text-sm",
                    medium: "text-base",
                    large: "text-2xl",
                    xlarge: "text-4xl",
                },
                disabled: {
                    true: "!bg-gray-100 !text-gray-400 cursor-not-allowed"
                }
            }
        }
    )({
        intent: props.intent,
        size: props.size,
        disabled: props.disabled,
    });
})
</script>

<template>
    <component
        :is="props.as"
        :disabled="props.disabled"
        :class="buttonClass"
    >
        <svg
            v-if="props.loading"
                class="animate-spin h-5 w-5 absolute"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
        >
                <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                ></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>

        <component
            :is="props.leftIcon"
            :class="[
                'w-5 h-5 mr-2',
                props.loading && 'invisible'
            ]"
        />

        <span :class="[props.loading && 'invisible']">
            <slot />
        </span>

        <component
            :is="props.rightIcon"
            :class="[
                'w-5 h-5 ml-2',
                props.loading && 'invisible'
            ]"
        />
    </component>
</template>

