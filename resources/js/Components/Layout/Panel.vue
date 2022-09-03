<template>
    <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
        <div class="px-4 py-5 sm:px-6">
            <slot name="header"/>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <slot/>
        </div>
        <div v-if="$slots.footer" class="bg-gray-50 px-4 py-4 sm:px-6">
            <div class="flex justify-end">
                <slot name="footer"/>
            </div>
        </div>
    </div>
</template>
