<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Panel from '@/Components/Layout/Panel.vue';
import PanelHeader from '@/Components/Layout/PanelHeader.vue';
import TableHeader from '@/Components/TableHeader.vue';
import Button from '@/Components/Button.vue';
import SelectPlayers from '@/Pages/Games/Partials/SelectPlayers.vue';
import JetInputError from '@/Components/Jetstream/InputError.vue'
import GameForm from '@/Pages/Games/Partials/GameForm.vue';
import {ref} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps({
    users: Array,
});

const selectedPlayers = ref([]);
const match = ref([]);

if (props.users.length === 4) {
    selectedPlayers.value = [...props.users];
}

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

const randomMatch = () => {
    const players = [...selectedPlayers.value.shuffle()];

    form.played_at = new Date().toDateTimeLocalString();
    for (let i = 0; i < players.length; i++) {
        form.players[i].id = players[i].id;
    }
}

const storeGame = () => {
    form.transform((data) => ({
        ...data,
        played_at: new Date(data.played_at).toLaravelString(),
    })).post(route('games.store'));
};
</script>

<template>
    <AppLayout :title="$t('pages.games.random.title')">
        <template #header>
            <TableHeader :title="$t('pages.games.random.title')"/>
        </template>

        <div class="grid lg:grid-cols-3 gap-4">
            <div>
                <Panel>
                    <template #header>
                        <PanelHeader>
                            {{ $t('pages.games.label.players') }}
                        </PanelHeader>
                    </template>

                    <SelectPlayers :users="users" :selected="selectedPlayers"/>

                    <div v-if="selectedPlayers.length !== 0 || selectedPlayers.length !== 4" class="mt-4">
                        <JetInputError v-if="selectedPlayers.length < 4"
                                       :message="$t('pages.games.error.not-enough-players')"/>
                        <JetInputError v-if="selectedPlayers.length > 4"
                                       :message="$t('pages.games.error.too-many-players')"/>
                    </div>

                    <div class="flex justify-end mt-4">
                        <Button :disabled="selectedPlayers.length !== 4" @click="randomMatch">
                            {{ $t('pages.games.action.random') }}
                        </Button>
                    </div>
                </Panel>
            </div>

            <div v-if="form.players[0].id" class="lg:col-span-2">
                <GameForm @submitted="storeGame" :users="users" :form="form" players-disabled/>
            </div>
        </div>
    </AppLayout>
</template>
