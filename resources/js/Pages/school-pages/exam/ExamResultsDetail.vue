<script setup lang="ts">
import { ref } from "vue";
import StudentProfile from "@/Components/school-pages/exam/StudentProfile.vue";
import ProgressReport from "@/Components/school-pages/exam/ProgressReport.vue";
// common components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Exam Results Details' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Exam Results Details',
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
              <ProgressReport/>
          </v-col>
      </v-row>
  </FullLayout>
</template>
