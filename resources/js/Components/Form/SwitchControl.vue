<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <SwitchGroup as="div" class="flex items-center justify-between">
    <span class="flex-grow flex flex-col">
      <SwitchLabel as="span" class="text-sm font-medium text-gray-900" passive v-text="label"></SwitchLabel>
      <SwitchDescription as="span" class="text-sm text-gray-500" v-if="sublabel" v-text="sublabel"></SwitchDescription>
    </span>
        <Switch
            v-model="enabled"
            :class="[enabled ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']">            <span :class="[enabled ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200']">
              <span :class="[enabled ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200', 'absolute inset-0 h-full w-full flex items-center justify-center transition-opacity']" aria-hidden="true">
                  <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                    <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
              </span>
              <span :class="[enabled ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100', 'absolute inset-0 h-full w-full flex items-center justify-center transition-opacity']" aria-hidden="true">
                  <svg class="h-3 w-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                      <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"/>
                  </svg>
              </span>
            </span>
        </Switch>
    </SwitchGroup>
</template>

<script>
import {Switch, SwitchDescription, SwitchGroup, SwitchLabel} from '@headlessui/vue'
import {defineComponent} from "vue";

export default defineComponent({
    props: ['label', 'modelValue', 'sublabel', 'value'],
    emits: ['update:modelValue'],

    components: {
        Switch,
        SwitchDescription,
        SwitchGroup,
        SwitchLabel,
    },
    computed: {
        inputClass() {
            return {
                'block w-full pr-10 sm:text-sm rounded-md shadow-sm': true,
                'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500': this.error != null,
                'focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 ': !this.error,
            }
        }
    },
    watch: {
        enabled() {
            if (this.value) {
                this.$emit('update:modelValue', this.enabled ? this.value : undefined)
            } else {
                this.$emit('update:modelValue', this.enabled)

            }
        }
    },
    data() {
        return {
            enabled: this.modelValue,
        }
    }
});
</script>
