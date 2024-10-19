<script setup lang="ts">
import { ref } from 'vue';
import ClassesData from '@/Components/school-pages/classes/ClassesData.vue';
// common components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Classes' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Classes',
        disabled: true,
        href: '#'
    }
]);
</script>
<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>
        <v-card elevation="10">
            <v-card-text>
                <ClassesData />
            </v-card-text>
        </v-card>
    </FullLayout>
</template>
