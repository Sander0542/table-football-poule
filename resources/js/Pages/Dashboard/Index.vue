<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PeriodSelection from '@/Pages/Dashboard/Partials/PeriodSelection.vue';
import TableHeader from '@/Components/TableHeader.vue';
import Panel from '@/Components/Layout/Panel.vue';
import PanelHeader from '@/Components/Layout/PanelHeader.vue';
import {Inertia} from "@inertiajs/inertia";

defineProps({
    stats: Object,
});

const now = new Date(Date.now());

const period = {
    start: new Date(now.setHours(0, 0, 0, 0)),
    end: new Date(now.setHours(23, 59, 59, 999)),
}

const loadStats = () => {
    Inertia.reload({
        only: ['stats'],
        preserveScroll: true,
        data: {
            start: period.start.toLaravelString(),
            end: period.end.toLaravelString(),
        }
    });
}
</script>

<template>
    <AppLayout :title="$t('pages.dashboard.index.title')">
        <template #header>
            <TableHeader :title="$t('pages.dashboard.index.title')"/>
        </template>

        <PeriodSelection :changed="loadStats" :start="period.start" :end="period.end"/>

        <div class="lg:grid grid-cols-3 gap-4 mt-4">
            <Panel>
                <template #header>
                    <PanelHeader>
                        {{ $t('pages.dashboard.label.stat.players') }}
                    </PanelHeader>
                </template>

                <dl class="lg:grid grid-cols-1 gap-x-4 gap-y-6">
                    <div v-for="player in stats.players">
                        <dt class="text-sm font-medium text-gray-500">{{ player.name }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ player.wins }}</dd>
                    </div>
                </dl>
            </Panel>
            <Panel>
                <template #header>
                    <PanelHeader>
                        {{ $t('pages.dashboard.label.stat.teams') }}
                    </PanelHeader>
                </template>

                <dl class="lg:grid grid-cols-1 gap-x-4 gap-y-6">
                    <div v-for="team in stats.teams">
                        <dt class="text-sm font-medium" :class="`text-${team.name}-600`">{{ $t(`common.color.${team.name}`) }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ team.score }}</dd>
                    </div>
                </dl>
            </Panel>
        </div>
    </AppLayout>
</template>
