<template>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900" v-text="title"></h1>
            <p class="mt-2 text-sm text-gray-700" v-text="subtitle"></p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ['title', 'subtitle']
}
</script>
