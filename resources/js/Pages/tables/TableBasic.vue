<script setup lang="ts">
import { ref } from 'vue';
// common Components
import UiParentCard from '@/Components/shared/UiParentCard.vue';

//Table
import Table1 from '@/Components/table/Table1.vue';
import Table2 from '@/Components/table/Table2.vue';
import Table3 from '@/Components/table/Table3.vue';
import Table4 from '@/Components/table/Table4.vue';
import Table5 from '@/Components/table/Table5.vue';
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Basic Tables' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Basic tables',
        disabled: true,
        href: '#'
    }
]);
</script>

<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>
        <!-- ---------------------------------------------------- -->
        <!-- Table Basic -->
        <!-- ---------------------------------------------------- -->
        <v-row>
            <v-col cols="12">
                <UiParentCard title="Basic Table">
                    <!--Basic Table 1-->
                    <Table1/>
                    <!--Basic Table 2-->
                    <Table2/>
                    <!--Basic Table 3-->
                    <Table3/>
                    <!--Basic Table 4-->
                    <Table4/>
                    <!--Basic Table 5-->
                    <Table5/>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
