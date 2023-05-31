<script setup>
import { computed, provide } from "vue";
import BaseLabel from '../Components/BaseLabel.vue'
import ErrorMessage from '../Components/ErrorMessage.vue'
import HelperMessage from '../Components/HelperMessage.vue'
import {v4 as uuid} from 'uuid'

const props = defineProps({
    id: {
        type: String,
        default: () => `field-${uuid()}`,
    },
    label: String,
    required: Boolean,
    error: String,
    help: String,
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
    <div>
        <BaseLabel
            v-if="props.label"
            :for="props.id"
            :required="props.required"
        >
            {{ props.label }}
        </BaseLabel>
        <slot v-bind="props"/>

        <ErrorMessage v-if="!!props.error">{{ props.error }}</ErrorMessage>
        <HelperMessage v-if="props.help" :id="ariaDescribedBy">{{ props.help }}</HelperMessage>
    </div>
</template>
