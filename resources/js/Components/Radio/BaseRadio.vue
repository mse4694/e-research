<script setup>

import {computed} from "vue";
import {cva} from "class-variance-authority";

const props = defineProps({
    label: {
        type: [String, Boolean],
        default: ''
    },
    modelValue: {
        type: [String, Number],
        default: ''
    },
    value: {
        type: [String, Number],
        required: true,
    },
    radioBoxClass: String,
    radioType: String,
})

const emit = defineEmits(['update:modelValue'])

const updateInput = ($event) => {
    emit('update:modelValue', $event.target.value)
}

const isChecked = computed( () => {
    return props.modelValue == props.value
})


</script>

<template>
    <input
        v-bind="$attrs"
        :checked="isChecked"
        @change="updateInput"
        :value="value"
        type="radio"
        :class="radioBoxClass"
    />
    <label
        :for="$attrs.id"
        class="w-full ml-2 text-sm font-medium text-gray-900"
        :class="{ 'py-3' : props.radioType === 'horizontal'}"
    >
            {{ label }}
    </label>

</template>


