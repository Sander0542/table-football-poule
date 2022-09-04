<script setup>
import FormControl from "@/Components/Form/FormControl.vue";
import Label from "@/Components/Jetstream/Label.vue";
import Button from '@/Components/Button.vue'
import {computed} from "vue";

defineEmits(['changed']);

const props = defineProps({
    start: Date,
    end: Date,
});

const startDate = computed({
    get: () => {
        return props.start.toDateTimeLocalString();
    },
    set: (value) => {
        props.start = new Date(value);
    }
});

const endDate = computed({
    get: () => {
        return props.end.toDateTimeLocalString();
    },
    set: (value) => {
        console.log(value);
        props.end = new Date(value);
        console.log(props.end);
    }
});
</script>

<template>
    <form @submit.prevent="$emit('changed')">
        <Label v-text="$t('pages.dashboard.label.period')"/>
        <div class="flex">
            <FormControl v-model="startDate" name="start" type="datetime-local"/>
            <FormControl class="ml-3" v-model="endDate" name="end" type="datetime-local"/>
            <Button class="ml-3 mt-1" type="submit" variant="primary" v-text="$t('common.action.apply')"/>
        </div>
    </form>
</template>
