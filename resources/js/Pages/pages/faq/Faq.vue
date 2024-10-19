<script setup lang="ts">
import { ref } from 'vue';
//FAQ components
import FaqQuestion from '@/Components/pages/faq/FaqQuestion.vue';
import StillHaveQuestions from '@/Components/pages/faq/StillHaveQuestions.vue';
// common components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'FAQ' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'FAQ',
        disabled: true,
        href: '#'
    }
]);


</script>

<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>
        <v-row class="justify-center">
            <!--Questions-->
            <v-col cols="12" md="8">
                <FaqQuestion/>
            </v-col>
            <!--Stil Have Questions-->
            <v-col cols="12">
                <StillHaveQuestions/>
            </v-col>
        </v-row>
    </FullLayout>
</template>
