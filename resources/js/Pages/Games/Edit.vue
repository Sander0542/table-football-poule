<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import TableHeader from '@/Components/TableHeader.vue';
import GameForm from '@/Pages/Games/Partials/GameForm.vue';

const props = defineProps({
    users: Array,
    game: Object,
    players: Array,
});

const form = useForm({
    played_at: new Date(props.game.played_at).toDateTimeLocalString(),
    score_blue: props.game.score_blue,
    score_red: props.game.score_red,
    players: props.players
});

const storeGame = () => {
    form.transform((data) => {
        console.log(data.played_at);
        console.log(new Date(data.played_at).toLaravelString());
        return ({
            ...data,
            played_at: new Date(data.played_at).toLaravelString(),
        });
    }).put(route('games.update', {game: props.game.id}));
};
</script>

<template>
    <AppLayout :title="$t('pages.games.edit.title')">
        <template #header>
            <TableHeader :title="$t('pages.games.edit.title')"/>
        </template>

        <GameForm @submitted="storeGame" :users="users" :form="form"/>
    </AppLayout>
</template>
