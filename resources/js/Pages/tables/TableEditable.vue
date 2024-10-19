<script setup lang="ts">
import { ref } from 'vue';
import UiParentCard from '@/Components/shared/UiParentCard.vue';

//Table
import EditableTable from '@/Components/table/EditableTable.vue';
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Editable Table' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Editable table',
        disabled: true,
        href: '#'
    }
]);
</script>

<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>

        <!-- ---------------------------------------------------- -->
        <!-- Table Editable -->
        <!-- ---------------------------------------------------- -->
        <v-row>
            <v-col cols="12">
                <UiParentCard title="Editable Table">
                    <EditableTable />
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
