<template>
    <a :disabled="disabled" :href="href" v-if="href && type === 'a'" :class="classObject">
        <slot></slot>
    </a>
    <Link :disabled="disabled" :href="href" v-else-if="href" :class="classObject">
        <slot></slot>
    </Link>
    <button :disabled="disabled" :type="type" v-else @click="$emit('onClick')" :class="classObject">
        <span v-if="$slots.icon" class="mr-1">
            <slot name="icon"></slot>
        </span>
        <slot></slot>
    </button>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';

import {defineComponent} from "vue";

export default defineComponent({
    components: {Link},
    props: {
        variant: {
            type: String,
            default: 'primary',
        },
        size: {
            type: String,
            default: 'regular',
        },
        href: {
            type: String,
            default: null,
        },
        type: {
            type: String,
            default: 'button',
        },
        disabled: {
            type: Boolean,
            default: false,
        }
    },
    computed: {
        classObject() {
            return {
                'inline-flex items-center border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500': this.variant === 'primary',
                'inline-flex items-center border border-gray-300 rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500': this.variant === 'secondary',
                'inline-flex items-center border border-indigo-600 rounded-md shadow-sm text-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500': this.variant === 'outline',
                'inline-flex items-center border border-red-500 rounded-md shadow-sm text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500': this.variant === 'outline-danger',
                'inline-flex items-center border border-transparent rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500': this.variant === 'danger',


                'inline-flex text-indigo-600 font-semibold hover:underline': this.variant === 'link',

                'text-xs rounded': this.size === 'sm',
                'text-sm rounded-md leading-4': this.size === 'regular',
                'text-sm font-medium': this.size === 'lg',

                'px-2.5 py-1.5': this.size === 'sm' && this.variant !== 'link',
                'px-3 py-2': this.size === 'regular' && this.variant !== 'link',
                'px-4 py-2': this.size === 'lg' && this.variant !== 'link',
            }
        }
    }
});
</script>
