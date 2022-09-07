<template>
    <nav v-if="pagination.last_page > 1" class="border-t border-gray-200 px-4 flex items-center justify-between sm:px-0 pb-4">
        <div class="-mt-px w-0 flex-1 flex pl-4">
            <Link :href="pagination.prev_page_url" class="border-t-2 border-transparent pt-4 pr-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                <ArrowNarrowLeftIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true"/>
                {{ $t('common.action.previous') }}
            </Link>
        </div>
        <div class="hidden md:-mt-px md:flex">
            <template v-for="(link, k) in pagination.links" :key="k">
                <Link v-if="link.url !== null && (k !== 0 && k !== pagination.links.length - 1)"
                      class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium"
                      :class="{ 'border-indigo-500 text-indigo-600': link.active }" :href="link.url" v-html="link.label"/>
            </template>
        </div>
        <div class="-mt-px w-0 flex-1 flex justify-end pr-4">
            <Link :href="pagination.next_page_url" class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                {{ $t('common.action.next') }}
                <ArrowNarrowRightIcon class="ml-3 h-5 w-5 text-gray-400" aria-hidden="true"/>
            </Link>
        </div>
    </nav>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3'
import {ArrowNarrowLeftIcon, ArrowNarrowRightIcon} from '@heroicons/vue/outline'

export default {
    props: {
        pagination: Object,
    },
    components: {
        Link,
        ArrowNarrowLeftIcon,
        ArrowNarrowRightIcon
    },
}
</script>
