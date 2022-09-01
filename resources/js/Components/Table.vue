<template>

    <div class="-mx-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
            <tr>
                <th v-for="(row, index) in layout.columns" scope="col" :class="[
                    index === 0 ? 'sm:pl-6' : index === layout.columns.length -1 && !layout.edit && !layout.view ? 'relative sm:pr-6' : '',
                    row.breakpoint ? `hidden ${row.breakpoint}:table-cell` : '',
                    'py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900'
                    ]"
                    v-text="$t(row.title)"></th>
                <th v-if="hasActions" scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            <tr v-if="data.data && data.data.length > 0" v-for="row in data.data" :key="row[layout.itemKey]">
                <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                    {{ getDescendantProp(row, layout.columns[0].key) }}
                    <dl class="font-normal lg:hidden">
                        <template v-for="column in layout.columns">
                            <dt class="sr-only" v-text="column.title"></dt>
                            <dd :class="['mt-1 truncate text-gray-700', column.breakpoint ? `${column.breakpoint}:hidden` : 'hidden',]">{{ getDescendantProp(row, column.key) }}</dd>
                        </template>
                    </dl>
                </td>
                <td v-for="column in layout.columns.slice(1, layout.columns.length)" :class="[
                    column.breakpoint ? `hidden ${column.breakpoint}:table-cell` : '',
                    'px-3 py-4 text-sm text-gray-500'
                    ]">
                    <slot v-if="this.$slots[`column-${column.key}`]" :name="`column-${column.key}`" :row="row"></slot>
                    <span v-else-if="column.renderFn">{{ column.renderFn(getDescendantProp(row, column.key), row) }}</span>
                    <span v-else>{{ getDescendantProp(row, column.key) }}</span>
                </td>

                <td v-if="hasActions" class="py-4 pl-3 pr-4 flex flex-row items-center justify-end gap-x-2 text-sm font-medium sm:pr-6 h-full">
                    <Link v-if="layout.view" :href="route(layout.view, getRouteParameters(row))" class="text-indigo-600 hover:text-indigo-900">
                        <EyeIcon class="w-5 h-5"/>
                        <span class="sr-only">{{ $t('common.action.view') }}</span>
                    </Link>
                    <div v-if="layout.view && layout.edit" class="border border-gray-300 rounded-full"></div>
                    <Link v-if="layout.edit" :href="route(layout.edit, getRouteParameters(row))" class="text-indigo-600 hover:text-indigo-900">
                        <PencilIcon class="w-5 h-5"/>
                        <span class="sr-only">{{ $t('common.action.edit') }}</span>
                    </Link>
                    <slot name="actions" :row="row"></slot>
                </td>
            </tr>
            <tr v-else-if="emptyMessage">
                <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6 text-center" colspan="100%">
                    {{ emptyMessage }}
                </td>
            </tr>
            </tbody>
        </table>
        <div class="bg-white" v-if="pagination">
            <pagination :pagination="data"/>
        </div>
    </div>
</template>

<script>
import {EyeIcon, PencilIcon} from "@heroicons/vue/outline"
import Pagination from "@/Components/Pagination.vue";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {
        EyeIcon,
        PencilIcon,
        Pagination,
        Link,
    },
    props: {
        layout: Object,
        data: Object,
        pagination: {
            type: Boolean,
            default: true,
        },
        parent: {
            type: Object,
            required: false,
        },
        emptyMessage: String
    },

    methods: {
        getRouteParameters(row) {
            if (!this.parent) {
                return row;
            }
            return [
                this.parent,
                row
            ]
        },
        getDescendantProp(obj, desc) {
            const arr = desc.split(".");
            while (arr.length && (obj = obj[arr.shift()])) ;
            return obj;
        }
    },
    computed: {
        hasActions() {
            return this.layout.view || this.layout.edit || this.$slots['actions'];
        }
    }
}
</script>
