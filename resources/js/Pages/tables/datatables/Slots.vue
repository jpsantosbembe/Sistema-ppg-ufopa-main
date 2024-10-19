<script setup lang="ts">
import { ref } from 'vue';
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import { BasicDatatables } from '#/components/datatable/dataTable';
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Item Slots Data Table' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Item slots data table',
        disabled: true,
        href: '#'
    }
]);
/*Header Data*/
const headers = ref([
    { title: 'Name', align: 'start', key: 'name', sortable: false, },
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
                <UiParentCard title="Item Slot">
                    <v-data-table :headers="headers" :items="BasicDatatables" item-value="name" class="border rounded-md">
                        <template v-slot:item="{ item }">
                            <tr>
                                <td class="text-subtitle-1">{{ item.name }}</td>
                                <td class="text-subtitle-1">{{ item.project }}</td>
                                <td class="text-subtitle-1">{{ item.post }}</td>
                                <td class="text-subtitle-1">{{ item.status }}</td>
                                <td class="d-flex justify-end align-center text-subtitle-1">{{ item.budget }}</td>
                            </tr>
                        </template>
                    </v-data-table>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>

