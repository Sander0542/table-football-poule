<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import TableHeader from '@/Components/TableHeader.vue';
import GameForm from '@/Pages/Games/Partials/GameForm.vue';

const props = defineProps({
    users: Array,
});

const form = useForm({
    played_at: new Date().toDateTimeLocalString(),
    score_blue: 0,
    score_red: 0,
    players: [
        {id: null, team: 'blue', position: 'offense'},
        {id: null, team: 'blue', position: 'defense'},
        {id: null, team: 'red', position: 'offense'},
        {id: null, team: 'red', position: 'defense'},
    ],
});

const storeGame = () => {
    form.transform((data) => ({
        ...data,
        played_at: new Date(data.played_at).toLaravelString(),
    })).post(route('games.store'));
};
</script>

<template>
    <AppLayout :title="$t('pages.games.create.title')">
        <template #header>
            <TableHeader :title="$t('pages.games.create.title')"/>
        </template>

        <GameForm @submitted="storeGame" :users="users" :form="form"/>
    </AppLayout>
</template>
