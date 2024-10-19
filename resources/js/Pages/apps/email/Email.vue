<script setup lang="ts">
import { ref } from 'vue';
import BaseBreadcrumb from "../../../Components/shared/BaseBreadcrumb.vue";
import AppBaseCard from "../../../Components/shared/AppBaseCard.vue";
// common components


// theme breadcrumb
const page = ref({ title: 'Email app' });

const breadcrumbs = ref([
    {
        text: 'Look at Inbox',
        disabled: true,
        href: '#'
    }
]);
</script>

<template>
    <!-- ---------------------------------------------------- -->
    <!-- Table Basic -->
    <!-- ---------------------------------------------------- -->
    <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>

    <v-card elevation="10" class="inside-left-sidebar">
        <AppBaseCard>
            <template v-slot:leftpart>
                test
            </template>
            <template v-slot:rightpart>
                test
            </template>

            <template v-slot:mobileLeftContent>
               test
            </template>
        </AppBaseCard>
    </v-card>
</template>

<style scoped lang="scss">
@media (max-width: 1279px) {
    .v-card {
        position: unset;
    }
}
</style>
