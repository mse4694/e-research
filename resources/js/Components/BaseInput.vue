<script setup>
import { computed, inject, onMounted } from "vue";
import { cva } from "class-variance-authority";

// onMounted(() => {
//   console.log(`the component is now mounted. ${field.invalid}`)
// })

const props = defineProps({
    id: String,
    modelValue: {
        type: [String, Number],
        default: ''
    },
    intent: {
        type: String,
        validator: (val) => ["success", "info", "warning", "error"].includes(val),
        default: "info",
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    invalid: {
        type: Boolean,
        default: false,
    },
    ariaDescribedBy: String,
    required: Boolean
})

const emit = defineEmits(['update:modelValue'])

const updateInput = ($event) => {
    emit('update:modelValue', $event.target.value)
}

const field = inject('field', props)

const inputClass = computed(() => {
    return cva(
        "block w-full p-2.5 bg-gray-50 border text-gray-900 text-sm rounded-lg",
        {
            variants: {
                intent: {
                    info: "border-gray-300 focus:ring-blue-500 focus:border-blue-500",
                    success: "border-green-600 focus:ring-green-500 focus:border-green-500",
                    warning: "border-yellow-400 focus:ring-yellow-500 focus:border-yellow-500",
                    error: "border-red-600 focus:ring-red-500 focus:border-red-500",
                },
                disabled: {
                    true: "!bg-gray-100 !text-gray-400 cursor-not-allowed"
                },
            }
        }
    )({
        intent: props.intent,
        disabled: props.disabled,
    });
})

</script>

<template>
    <input
        v-bind="$attrs"
        :id="field.id"
        :value="props.modelValue"
        @input="updateInput"
        :class="[inputClass, field.invalid ? 'border-red-600 focus:ring-red-500 focus:border-red-500' : '']"
        :required="field.required"
        :disabled="props.disabled"
    >
</template>
