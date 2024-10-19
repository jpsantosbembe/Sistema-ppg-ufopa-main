<script setup lang="ts">
import { ref } from 'vue';
import StudentTable from '@/Components/school-pages/students/StudentTable.vue';
// common components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Students Data' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Students Data',
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
                <StudentTable />
            </v-card-text>
        </v-card>
    </FullLayout>
</template>
