<script setup lang="ts">
import { ref } from 'vue';
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import {BasicDatatables} from '#/components/datatable/dataTable';
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Grouping Data Table' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Grouping data table',
        disabled: true,
        href: '#'
    }
]);
/*Header Data*/
const sortBy = ref([
    { key: 'name', order: 'asc' }
])
const groupBy = ref([
    { key: 'status', order: 'asc' }
])
const headers = ref([
    { title: 'Name', align: 'start', key: 'name', groupable: false, },
    { title: 'Project Name', align: 'start', key: 'project' },
    { title: 'Post', align: 'start', key: 'post' },
    { title: 'Status', align: 'start', key: 'status' },
    { title: 'Budget', align: 'end', key: 'budget' },
])
</script>
<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>

        <v-row>
            <v-col cols="12">
                <UiParentCard title="Grouping">
                    <v-data-table items-per-page="5" :headers="headers" :items="BasicDatatables" item-value="name"
                                  :group-by="groupBy" :sort-by="sortBy"
                                  class="border rounded-md">
                    </v-data-table>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>

