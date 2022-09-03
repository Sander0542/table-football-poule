<template>
    <div class="col-span-6 sm:col-span-4">
        <label :for="name" class="block text-sm font-medium text-gray-700" v-text="label"></label>
        <div class="mt-1 relative rounded-md shadow-sm">
            <select
                   :name="name"
                   :id="name"
                   :class="inputClass"
                   :value="modelValue"
                   :aria-invalid="error != null"
                   :aria-describedby="`${name}-error`"
                   :disabled="disabled"
                   @input="$emit('update:modelValue', $event.target.value)"
            >
                <option value="" disabled v-if="placeholder" v-text="placeholder"></option>
                <slot></slot>
            </select>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" v-if="error">
                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true"/>
            </div>
        </div>
        <p class="mt-2 text-sm text-red-600" id="email-error" v-if="error" v-text="error"></p>
    </div>
</template>
<script>
import {defineComponent} from "vue";
import {ExclamationCircleIcon} from '@heroicons/vue/solid'

export default defineComponent({
    props: ['error', 'name', 'label', 'modelValue', 'placeholder', 'disabled'],
    emits: ['update:modelValue'],

    components: {
        ExclamationCircleIcon
    },
    computed: {
        inputClass() {
            return {
                'block w-full pr-10 sm:text-sm rounded-md shadow-sm': true,
                'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500': this.error != null,
                'focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 ': !this.error,
            }
        }
    }
});
</script>
