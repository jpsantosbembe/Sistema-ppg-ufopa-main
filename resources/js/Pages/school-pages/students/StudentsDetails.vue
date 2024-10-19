<script setup>
import { ref } from "vue";

import StudentReport from "@/Components/school-pages/students/StudentReport.vue";
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
import StudentProfile from "@/Components/school-pages/students/StudentProfile.vue";

// theme breadcrumb
const page = ref({ title: 'Students Details' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Students Details',
        disabled: true,
        href: '#'
    }
]);
</script>

<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>
        <v-row>
            <v-col cols="12" sm="12" lg="4">
                <StudentProfile/>
            </v-col>
            <v-col cols="12" sm="12" lg="8">
                <StudentReport/>
            </v-col>
        </v-row>
    </FullLayout>
</template>
