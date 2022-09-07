<template>
    <div class="col-span-6 sm:col-span-4">
        <jet-label :for="name" :value="label" v-if="label"/>

        <div class="mt-1 relative rounded-md shadow-sm">
            <input :type="type"
                   :name="name"
                   :id="name"
                   :class="inputClass"
                   :placeholder="placeholder"
                   :value="modelValue"
                   :disabled="disabled"
                   :aria-invalid="error != null"
                   :aria-describedby="`${name}-error`"
                   @input="$emit('update:modelValue', $event.target.value)"
            />
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" v-if="error">
                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true"/>
            </div>
        </div>
        <jet-input-error v-if="error" :message="error"/>
    </div>
</template>
<script>
import {defineComponent} from "vue";
import {ExclamationCircleIcon} from '@heroicons/vue/solid'
import JetLabel from '@/Components/Jetstream/Label.vue'
import JetInputError from '@/Components/Jetstream/InputError.vue'

export default defineComponent({
    props: ['error', 'name', 'label', 'modelValue', 'placeholder', 'type', 'disabled'],
    emits: ['update:modelValue'],

    components: {
        ExclamationCircleIcon,
        JetLabel,
        JetInputError
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
