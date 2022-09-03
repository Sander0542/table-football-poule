<script setup>
import {Link} from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PlayersColumn from '@/Pages/Games/Partials/PlayersColumn.vue';
import Table from '@/Components/Table.vue';
import TableHeader from '@/Components/TableHeader.vue';

defineProps({
    games: Object,
});

const tableLayout = {
    view: 'games.show',
    edit: 'games.edit',
    itemKey: 'id',
    columns: [
        {
            key: 'played_at',
            title: 'pages.games.label.played_at',
        },
        {
            key: 'score',
            title: 'pages.games.label.score',
            renderFn: (_, game) => `${game.score_blue} - ${game.score_red}`
        },
        {
            key: 'users',
            title: 'pages.games.label.players',
        },
    ]
}
</script>

<template>
    <AppLayout :title="$t('pages.games.index.title')">
        <template #header>
            <TableHeader :title="$t('pages.games.index.title')">
                <Link :href="route('games.create')" type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto" v-text="$t('pages.games.action.create')"></Link>
            </TableHeader>
        </template>

        <Table
            :data="games"
            :pagincation="true"
            :layout="tableLayout"
            :empty-message="$t('pages.games.label.table-empty')"
        >
            <template #column-played_at="{ row: game }">
                <i18n-d tag="span" :value="game.played_at" format="long"></i18n-d>
            </template>
            <template #column-score="{ row: game }">
                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-blue-600 rounded-full">{{ game.score_blue }}</span>
                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ game.score_red }}</span>
            </template>
            <template #column-users="{ row: game }">
                <PlayersColumn :players="game.users"/>
            </template>
        </Table>

    </AppLayout>
</template>
