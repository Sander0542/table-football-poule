<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import Panel from '@/Components/Layout/Panel.vue';
import PanelHeader from '@/Components/Layout/PanelHeader.vue';
import ScoreBadge from '@/Components/ScoreBadge.vue';
import Button from '@/Components/Button.vue'

const props = defineProps({
    game: Object,
});

const playersTableLayout = {
    itemKey: 'id',
    columns: [
        {
            key: 'name',
            title: 'pages.games.label.player',
        },
        {
            key: 'team',
            title: 'pages.games.label.team',
        },
        {
            key: 'position',
            title: 'pages.games.label.position',
        },
        {
            key: 'winner',
            title: 'pages.games.label.winner-loser',
        },
    ]
}
</script>

<template>
    <AppLayout :title="$t('pages.games.show.title')">
        <template #header>
            <TableHeader :title="$t('pages.games.show.title')"/>
        </template>

        <div class="lg:grid grid-cols-3 gap-4">
            <Panel>
                <template #header>
                    <PanelHeader>
                        {{ $t('pages.games.show.title') }}
                    </PanelHeader>
                </template>

                <div>
                    <dt class="text-sm font-medium text-gray-500">{{ $t('pages.games.label.played_at') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $d(game.played_at, 'long') }}</dd>
                </div>
                <div class="mt-2">
                    <dt class="text-sm font-medium text-gray-500">{{ $t('pages.games.label.score') }}</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <ScoreBadge :blue="game.score_blue" :red="game.score_red"/>
                    </dd>
                </div>

                <template #footer>
                    <Button variant="secondary" :href="route('games.edit', game)" v-text="$t('common.action.edit')"/>
                </template>
            </Panel>
            <div class="col-span-2 gap-4">
                <Table
                    :data="{data: game.users}"
                    :pagination="false"
                    :layout="playersTableLayout"
                    :empty-message="$t('pages.games.label.no-players')"
                >
                    <template #column-team="{ row: player }">
                        <span :class="`text-${player.pivot.team}-600`">{{ $t(`common.color.${player.pivot.team}`)}}</span>
                    </template>
                    <template #column-position="{ row: player }">
                        <span>{{ $t(`common.label.position.${player.pivot.position}`)}}</span>
                    </template>
                    <template #column-winner="{ row: player }">
                        <span>{{ $t(`common.label.${player.pivot.winner ? 'winner' : 'loser'}`)}}</span>
                    </template>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
