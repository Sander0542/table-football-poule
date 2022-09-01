<script setup>
import {Link} from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PlayersColumn from '@/Pages/Games/Partials/PlayersColumn.vue';
import Table from '@/Components/Table.vue';
import TableHeader from '@/Components/TableHeader.vue';

defineProps({
    games: Array,
});

const tableLayout = {
    view: 'games.show',
    edit: 'games.edit',
    itemKey: 'id',
    columns: [
        {
            key: 'played_at',
            title: 'pages.games.table.played_at',
            renderFn: (value) => this.$d(value, 'long')
        },
        {
            key: 'score_blue',
            title: 'pages.games.table.score',
            renderFn: (_, game) => `${game.score_blue} - ${game.score_red}`
        },
        {
            key: 'users',
            title: 'pages.games.table.players',
        },
    ]
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <TableHeader :title="$t('pages.games.title')">
                <Link :href="route('games.create')" type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto" v-text="$t('pages.games.action.create')"></Link>
            </TableHeader>
        </template>

        <Table
            :data="games"
            :pagincation="true"
            :layout="tableLayout"
            :empty-message="$t('pages.games.table.empty')"
        >
            <template #column-users="{ row }">
                <PlayersColumn :players="row.users"/>
            </template>
        </Table>

    </AppLayout>
</template>
