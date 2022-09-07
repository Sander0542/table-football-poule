<script setup>
import FormControl from "@/Components/Form/FormControl.vue";
import Label from "@/Components/Jetstream/Label.vue";
import Button from '@/Components/Button.vue'
import {computed, ref} from "vue";

const emit = defineEmits(['changed']);

let props = defineProps({
    start: Date,
    end: Date,
});

const periodStart = ref(props.start);
const periodEnd = ref(props.end);

const startDate = computed({
    get: () => {
        return periodStart.value.toDateTimeLocalString();
    },
    set: (value) => {
        periodStart.value = new Date(value);
    }
});

const endDate = computed({
    get: () => {
        return periodEnd.value.toDateTimeLocalString();
    },
    set: (value) => {
        periodEnd.value = new Date(value);
    }
});

const setPeriod = (start, end) => {
    periodStart.value = start;
    periodEnd.value = end;
    emit('changed', start, end);
}

const setToday = () => {
    const now = new Date(Date.now());
    const start = new Date(now.setHours(0, 0, 0, 0));
    const end = new Date(start.getTime() + 86400000);
    setPeriod(start, end);
};

const setWeek = () => {
    const now = new Date(Date.now());
    const start = getMonday(now.setHours(0, 0, 0, 0));
    const end = new Date(start.getTime() + 86400000 * 7);
    setPeriod(start, end);
};

const setMonth = () => {
    const now = new Date(Date.now());
    const start = new Date(now.getFullYear(), now.getMonth(), 1, 0, 0, 0, 0);
    const end = new Date(start.getFullYear(), start.getMonth() + 1, 1, 0, 0, 0, 0);
    setPeriod(start, end);
};

const setYear = () => {
    const now = new Date(Date.now());
    const start = new Date(now.getFullYear(), 0, 1, 0, 0, 0, 0);
    const end = new Date(start.getFullYear() + 1, 0, 1, 0, 0, 0, 0);
    setPeriod(start, end);
};

const setAllTime = () => {
    periodStart.value = new Date(2000, 0, 1, 0, 0, 0, 0);
    periodEnd.value = new Date(2100, 0, 1, 0, 0, 0, 0);
    emit('changed', null, null);
};

const fromForm = () => {
    emit('changed', periodStart.value, periodEnd.value);
};

const getMonday = (d) => {
    d = new Date(d);
    const day = d.getDay(),
        diff = d.getDate() - day + (day === 0 ? -6 : 1);
    return new Date(d.setDate(diff));
};
</script>

<template>
    <form @submit.prevent="fromForm">
        <Label v-text="$t('pages.dashboard.label.period')"/>
        <div class="flex justify-between">
            <div class="flex">
                <FormControl v-model="startDate" name="start" type="datetime-local"/>
                <FormControl class="ml-2" v-model="endDate" name="end" type="datetime-local"/>
                <Button class="ml-2 mt-1" type="submit" variant="primary" v-text="$t('common.action.apply')"/>
            </div>

            <div class="flex justify-end mt-1">
                <Button class="ml-2" @click="setToday" variant="primary" v-text="$t('pages.dashboard.action.today')"/>
                <Button class="ml-2" @click="setWeek" variant="primary" v-text="$t('pages.dashboard.action.week')"/>
                <Button class="ml-2" @click="setMonth" variant="primary" v-text="$t('pages.dashboard.action.month')"/>
                <Button class="ml-2" @click="setYear" variant="primary" v-text="$t('pages.dashboard.action.year')"/>
                <Button class="ml-2" @click="setAllTime" variant="primary"
                        v-text="$t('pages.dashboard.action.all-time')"/>
            </div>
        </div>
    </form>
</template>
