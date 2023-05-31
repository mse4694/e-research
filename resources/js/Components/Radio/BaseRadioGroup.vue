<script setup>
import { computed } from "vue";
import { cva } from "class-variance-authority";
import BaseRadio from '@/Components/Radio/BaseRadio.vue'
import FormError from '../ErrorMessage.vue'

const emit = defineEmits(['update:modelValue'])

const props = defineProps({
    options: {
        type: Array,
        required: true
    },
    name: {
        type: String,
        required: true
    },
    modelValue: {
        type: [String, Number],
        required: true
    },
    radioType: {
        type: String,
        validator:(value) => ["base", "base-with-border", "inline", "horizontal"].includes(value),
        default: 'base'
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    error: {
        type: String,
        default: '',
    },
    errorIcon: {
        type: [String, Boolean],
        default: false,
    },
})

const updateInput = ($event) => {
    emit('update:modelValue', $event)
}

const radioBoxClass = computed(() => {
    return cva(
        "w-4 h-4 text-blue-600 border-gray-400 rounded-full focus:ring-0 cursor-pointer",
        {
            variants: {
                disabled: {
                    true: "!bg-gray-100 !text-gray-400 !border-gray-400 !cursor-not-allowed"
                }
            }
        }
    )({
        disabled: props.disabled,
    });
})

</script>

<template>
    <div v-if="props.radioType === 'inline'" class="flex flex-col sm:flex-row">
        <div
            v-for="(option, index) in options"
            class="flex mr-4 mb-4 w-full"
        >
            <BaseRadio
                :key="index"
                :label="option.label"
                :value="option.value"
                :name="name"
                :id="option.label"
                :model-value="props.modelValue"
                @update:modelValue="updateInput"
                :radioBoxClass="radioBoxClass"
                :disabled="props.disabled"
                :radioType="props.radioType"
            />
        </div>
    </div>

    <div v-if="props.radioType === 'base'"
        v-for="(option, index) in options"
        class="flex items-center mb-2"
    >
        <BaseRadio
            :key="index"
            :label="option.label"
            :value="option.value"
            :name="name"
            :id="option.label"
            :model-value="props.modelValue"
            @update:modelValue="updateInput"
            :radioBoxClass="radioBoxClass"
            :disabled="props.disabled"
            :radioType="props.radioType"
        />
    </div>

    <ul v-if="props.radioType === 'base-with-border'" class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
        <li
            v-for="(option, index) in options"
            class="w-full border-b border-gray-200 pt-2 pb-2">
            <div class="flex items-center pl-3">
                <BaseRadio
                    :key="index"
                    :label="option.label"
                    :value="option.value"
                    :name="name"
                    :id="option.label"
                    :model-value="props.modelValue"
                    @update:modelValue="updateInput"
                    :radioBoxClass="radioBoxClass"
                    :disabled="props.disabled"
                    :radioType="props.radioType"
                />
            </div>
        </li>
    </ul>

    <ul v-if="props.radioType === 'horizontal'" class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex">
        <li
            v-for="(option, index) in options"
            class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
            <div class="flex items-center pl-3">
                <BaseRadio
                    :key="index"
                    :label="option.label"
                    :value="option.value"
                    :name="name"
                    :id="option.label"
                    :model-value="props.modelValue"
                    @update:modelValue="updateInput"
                    :radioBoxClass="radioBoxClass"
                    :disabled="props.disabled"
                    :radioType="props.radioType"
                />
            </div>
        </li>
    </ul>
    <div class="flex flex-col">
        <FormError v-if="props.error" :with-icon="errorIcon">{{ props.error }}</FormError>
    </div>
</template>
