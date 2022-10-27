<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Panel from '@/Components/Layout/Panel.vue';
import PanelHeader from '@/Components/Layout/PanelHeader.vue';
import {reactive} from "vue";
// import StatsLineChart from "@/Pages/Players/Partials/StatsLineChart.vue";

const props = defineProps({
    player: Object,
});

const stats = reactive({
    wins: {
        total: props.player.games.filter(game => game.pivot.winner),
        offense: props.player.games.filter(game => game.pivot.winner && game.pivot.position === 'offense'),
        defense: props.player.games.filter(game => game.pivot.winner && game.pivot.position === 'defense'),
        blue: props.player.games.filter(game => game.pivot.winner && game.pivot.team === 'blue'),
        red: props.player.games.filter(game => game.pivot.winner && game.pivot.team === 'red'),
    },
})
</script>

<template>
    <AppLayout :title="player.name">
        <div class="lg:grid grid-cols-3 gap-4">
            <Panel>
                <template #header>
                    <PanelHeader>
                        {{ player.name }}
                    </PanelHeader>
                </template>

                <div class="mt-2">
                    <dt class="text-sm font-medium text-gray-500">{{ $t('pages.players.label.games-played') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ player.games.length }}</dd>
                </div>

                <div class="mt-2">
                    <dt class="text-sm font-medium text-gray-500">{{ $t('pages.players.label.wins') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ stats.wins.total.length }}</dd>
                </div>

                <div class="mt-2">
                    <dt class="text-sm font-medium text-gray-500">{{ $t('pages.players.label.win-rate') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ Math.round(100 / player.games.length * stats.wins.total.length) || 0 }}%</dd>
                </div>
            </Panel>
<!--            <div class="col-span-2 gap-4">-->
<!--                <Panel>-->
<!--                    <StatsLineChart/>-->
<!--                </Panel>-->
<!--            </div>-->
        </div>
    </AppLayout>
</template>
