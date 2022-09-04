<script setup>
defineProps({
    blue: Number,
    red: Number,
});
</script>

<template>
    <div>
        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-blue-600 rounded-full">{{ blue }}</span>
        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ red }}</span>
    </div>
</template>
