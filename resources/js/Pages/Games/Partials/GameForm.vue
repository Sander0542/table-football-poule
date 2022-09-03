<script setup>
import Panel from '@/Components/Layout/Panel.vue';
import PanelHeader from '@/Components/Layout/PanelHeader.vue';
import FormControl from "@/Components/Form/FormControl.vue";
import SelectControl from "@/Components/Form/SelectControl.vue";
import Button from '@/Components/Button.vue'

defineEmits(['submitted']);

const props = defineProps({
    users: Array,
    form: Object,
});
</script>

<template>
    <form @submit.prevent="$emit('submitted')">
        <Panel>
            <template #header>
                <PanelHeader>
                    {{ $t('pages.games.label.match') }}
                </PanelHeader>
            </template>

            <FormControl v-model="form.played_at" name="played_at" type="datetime-local"
                         :label="$t('pages.games.label.played_at')"
                         :error="form.errors['played_at']"/>

            <FormControl class="mt-4" v-model="form.score_blue" name="score_blue" type="number"
                         :label="$t('pages.games.label.score_blue')"
                         :error="form.errors['score_blue']"/>

            <FormControl class="mt-2" v-model="form.score_red" name="score_red" type="number"
                         :label="$t('pages.games.label.score_red')"
                         :error="form.errors['score_red']"/>

        </Panel>

        <Panel class="mt-4" v-for="(player, index) in form.players">
            <template #header>
                <PanelHeader>
                    {{ $t(`common.color.${player.team}`) }} - {{ $t(`common.label.position.${player.position}`) }}
                </PanelHeader>
            </template>

            <FormControl v-model="player.team" type="hidden"/>
            <FormControl v-model="player.position" type="hidden"/>

            <SelectControl class="mt-2" v-model="player.id" :label="$t('pages.games.label.player')"
                           :placeholder="$t('pages.games.label.choose-player')"
                           :error="form.errors[`users.${index}.id`]">
                <option v-for="user in users" :value="user.id" :key="user.id">
                    {{ user.name }}
                </option>
            </SelectControl>
        </Panel>

        <div class="flex justify-end mt-4">
            <Button variant="secondary" :href="route('games.index')" v-text="$t('common.action.cancel')"/>
            <Button class="ml-3" type="submit" variant="primary" :disabled="form.processing"
                    v-text="$t('common.action.save')"/>
        </div>
    </form>
</template>
