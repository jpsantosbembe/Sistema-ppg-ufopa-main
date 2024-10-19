<script setup lang="ts">
import { ref } from 'vue';
import AttendenceSheet from '@/Components/school-pages/attendence/AttendenceSheet.vue';
// common components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Attendence Sheet' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Attendence Sheet',
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
                <AttendenceSheet />
            </v-card-text>
        </v-card>
    </FullLayout>
</template>
