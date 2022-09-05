<script setup>
defineProps({
    players: Array,
});
</script>

<template>
    <p v-for="player in players">
        <span :class="`text-${player.pivot.team}-500`">{{ player.name }}</span>
    </p>
</template>
