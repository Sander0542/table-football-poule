<script setup>
import {CheckCircleIcon} from '@heroicons/vue/outline'

const props = defineProps({
    users: Array,
    selected: Array,
});

const togglePlayer = (user) => {
    if (props.selected.includes(user)) {
        props.selected.splice(props.selected.indexOf(user), 1);
    } else {
        props.selected.push(user);
    }
}
</script>

<template>
    <div class="grid gap-y-2">
        <div @click="togglePlayer(user)" v-for="(user, index) in users" :key="user.id"
             class="flex justify-between p-2 bg-gray-50 border text-sm rounded-lg block w-full cursor-pointer"
             :class="{
            'border-blue-500 text-blue-500': selected.includes(user),
            'border-gray-500 text-gray-500': !selected.includes(user),
             }">
            <span>{{ user.name }}</span>
            <CheckCircleIcon class="h-5"/>
        </div>
    </div>
</template>
