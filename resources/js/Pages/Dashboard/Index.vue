<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PeriodSelection from '@/Pages/Dashboard/Partials/PeriodSelection.vue';
import TableHeader from '@/Components/TableHeader.vue';
import Panel from '@/Components/Layout/Panel.vue';
import PanelHeader from '@/Components/Layout/PanelHeader.vue';
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    stats: Object,
});

const params = new Proxy(new URLSearchParams(window.location.search), {
    get: (searchParams, prop) => searchParams.get(prop),
});

console.log(params.start);

const uriToDate = (param) => {
    if (param === null) {
        return null;
    }

    param = param.replace(' ', 'T');
    param += '.000Z';

    return new Date(param);
}

const now = new Date(Date.now());
const period = {
    start: uriToDate(params.start) ?? new Date(2000, 0, 1, 0, 0, 0, 0),
    end: uriToDate(params.end) ?? new Date(2100, 0, 1, 0, 0, 0, 0),
}

const loadStats = (start, end) => {
    Inertia.reload({
        only: ['stats'],
        preserveScroll: true,
        data: {
            start: start?.toLaravelString() ?? null,
            end: end?.toLaravelString() ?? null,
        }
    });
}
</script>

<template>
    <AppLayout :title="$t('pages.dashboard.index.title')">
        <template #header>
            <TableHeader :title="$t('pages.dashboard.index.title')"/>
        </template>

        <PeriodSelection @changed="loadStats" :start="period.start" :end="period.end"/>

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
                        <dt class="text-sm font-medium" :class="`text-${team.name}-600`">
                            {{ $t(`common.color.${team.name}`) }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ team.score }}</dd>
                    </div>
                </dl>
            </Panel>
        </div>
    </AppLayout>
</template>
