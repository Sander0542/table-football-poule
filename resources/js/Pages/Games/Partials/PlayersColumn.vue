<script setup>
defineProps({
    players: Array,
});
</script>

<template>
    <p v-for="player in players">
        <span :class="{'text-red-500': !player.pivot.winner, 'text-green-500': player.pivot.winner}">{{ player.name }}</span>
    </p>
</template>
