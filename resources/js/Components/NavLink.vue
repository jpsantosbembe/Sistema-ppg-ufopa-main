<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import {userSystemState} from "@/Stores/index.js";


const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center h-10 w-full  bg-primary  rounded-lg  text-md text-primary font-medium leading-5  focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'inline-flex items-center h-10 w-full   text-md font-medium leading-5 text-gray-500  hover:text-gray-700  hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700  focus:border-gray-300  transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
