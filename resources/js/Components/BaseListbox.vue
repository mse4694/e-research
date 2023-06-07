<script setup>
import {computed, provide, ref} from "vue";
import {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'
import BaseLabel from '../Components/BaseLabel.vue'
import ErrorMessage from '../Components/ErrorMessage.vue'
import HelperMessage from '../Components/HelperMessage.vue'
import {v4 as uuid} from 'uuid'

import { CheckIcon, ChevronUpDownIcon } from "@heroicons/vue/20/solid";

const props = defineProps({
    options: Array,
    modelValue: [String, Number, Array],
    id: {
      type: String,
      default: () => `field-${uuid()}`,
    },
    label: String,
    placeholder: {
        type: String,
        default: 'Select option'
    },
    multiple: Boolean,
    error: String,
    help: String,

})

const emit = defineEmits(['update:modelValue'])

const label = computed(() => {
    return props.options.filter(option => {
        if(Array.isArray(props.modelValue)) {
            return props.modelValue.includes(option.value)
        }

        return props.modelValue === option.value
    }).map(option => option.label).join(', ')
})

const checkOptionValue = computed(() => {
    if(Array.isArray(props.modelValue)) {
        return props.modelValue.length
    }

    return props.modelValue
})

const ariaDescribedBy = computed( () => {
  return !!props.help ? `help-${uuid()}` : null
})

provide('field', computed(() => {
  return {
    ...props,
    invalid: !!props.error,
    ariaDescribedBy: ariaDescribedBy.value,
  }
}))

</script>

<template>
    <Listbox
        :multiple="props.multiple"
        @update:modelValue="value => emit('update:modelValue', value)"
        :model-value="props.modelValue">
        <div class="relative mt-1">
            <BaseLabel
              v-if="props.label"
              :for="props.id"
            >
              {{ props.label }}
            </BaseLabel>
            <ListboxButton
              :id="props.id"
              class="relative w-full cursor-default rounded-lg bg-gray-50 border border-gray-300 py-2 pl-3 pr-10 text-left shadow-md focus:outline-none focus-visible:border-indigo-500 focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-orange-300 sm:text-sm"
            >
            <span class="block truncate" v-if="label">{{ label }}</span>
            <span v-else class="text-gray-500">{{ props.placeholder }}</span>
            <span
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
            >
                <ChevronUpDownIcon
                    class="h-5 w-5 text-gray-400"
                    aria-hidden="true"
                />
            </span>
            </ListboxButton>

            <transition
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <ListboxOptions
                    class=" z-10 overflow-auto absolute mt-1 max-h-60 w-full rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                >
                    <ListboxOption
                        v-slot="{ active, selected }"
                        v-for="option in props.options"
                        :key="option.label"
                        :value="option.value"
                        :disabled="option.unavailable"
                        as="template"
                    >
                    <li
                        :class="[
                        active ? 'bg-amber-100 text-amber-900' : 'text-gray-900',
                        'relative cursor-default select-none py-2 pl-10 pr-4',
                        ]"
                    >
                        <span
                            :class="[
                                selected ? 'font-medium' : 'font-normal',
                                'block truncate',
                                option.unavailable ? 'opacity-75' : ''
                            ]"
                        >{{ option.label }}</span
                        >
                        <span
                            v-if="selected"
                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600"
                        >
                        <CheckIcon class="h-5 w-5" aria-hidden="true" />
                        </span>
                    </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
            <ErrorMessage v-if="!!props.error && !checkOptionValue">{{ props.error }}</ErrorMessage>
            <HelperMessage v-if="props.help" :id="ariaDescribedBy">{{ props.help }}</HelperMessage>
<!--            <div class="text-xs text-red-400 mt-1" v-if="props.error && !checkOptionValue">{{ props.error }}</div>-->
        </div>
    </Listbox>
</template>
