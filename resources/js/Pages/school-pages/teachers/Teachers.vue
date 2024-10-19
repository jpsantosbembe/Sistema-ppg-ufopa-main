<script setup>
import { ref } from 'vue';
import TeachersTable from '@/Components/school-pages/teachers/TeachersTable.vue';
// common components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Teachers Data' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Teachers Data',
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
                <TeachersTable />
            </v-card-text>
        </v-card>
    </FullLayout>
</template>
