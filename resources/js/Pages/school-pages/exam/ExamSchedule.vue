<script setup lang="ts">
import { ref } from 'vue';
import ExamTable from '@/Components/school-pages/exam/ScheduleTable.vue';
// common components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Exam Schedule' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Exam Schedule',
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
                <ExamTable />
            </v-card-text>
        </v-card>
    </FullLayout>
</template>
