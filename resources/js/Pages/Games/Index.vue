<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    games: Object,
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Matches
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">
                                <span class="text-sm font-semibold text-gray-800">Date</span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="text-sm font-semibold text-gray-800">
                                    Score
                                    <small class="text-xs font-normal text-gray-600">
                                        (blue - red)
                                    </small>
                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="text-sm font-semibold text-gray-800">
                                    Players
                                </span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="game in games">
                            <td class="border px-4 py-2">
                                <span class="text-sm font-semibold text-gray-800">
                                    {{ $d(game.played_at, 'long') }}
                                </span>
                            </td>
                            <td class="border px-4 py-2">
                                <span class="text-sm font-semibold text-gray-800">
                                    {{ game.score_blue }} - {{ game.score_red }}
                                </span>
                            </td>
                            <td class="border px-4 py-2">
                                <div class="text-sm font-semibold text-gray-800">
                                    <p v-for="player in game.users">
                                        <span :class="{'text-red-500': !player.pivot.winner, 'text-green-500': player.pivot.winner}">{{ player.name }}</span>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </AppLayout>
</template>
