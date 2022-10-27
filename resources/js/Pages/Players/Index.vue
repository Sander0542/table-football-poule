<script setup>
import {Link} from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import TableHeader from '@/Components/TableHeader.vue';

defineProps({
    players: Object,
});

const tableLayout = {
    view: 'players.show',
    itemKey: 'id',
    columns: [
        {
            key: 'name',
            title: 'pages.players.label.name',
        },
        {
            key: 'wins',
            title: 'pages.players.label.wins',
        },
    ]
}
</script>

<template>
    <AppLayout :title="$t('pages.players.index.title')">
        <template #header>
            <TableHeader :title="$t('pages.players.index.title')"/>
        </template>

        <Table
            :data="{data:players}"
            :pagincation="true"
            :layout="tableLayout"
            :empty-message="$t('pages.players.label.no-players')">
        </Table>

    </AppLayout>
</template>
