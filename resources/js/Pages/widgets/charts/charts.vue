<script setup lang="ts">
import { ref } from 'vue';
/*Call Components*/
import ProfitExpanse from "@/Components/dashboards/dashboard2/ProfitExpanse.vue";
import ProductSales from "@/Components/dashboards/dashboard2/ProductSales.vue";
import NetSells from "@/Components/widgets/charts/NetSells.vue";
import Payments from "@/Components/dashboards/dashboard1/Payments.vue";
import Products from "@/Components/dashboards/dashboard1/ProductsChart.vue";
import TraficDistribution from "@/Components/widgets/charts/TraficDistributionChart.vue";
import Customers from "@/Components/dashboards/dashboard1/Customers.vue";
import Payingchart from "@/Components/widgets/charts/PayingChart.vue";
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Chart' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Chart',
        disabled: true,
        href: '#'
    }
]);
</script>
<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>
        <v-row>
            <!---Profit Expanse-->
            <v-col cols="12" sm="12" lg="8">
                <ProfitExpanse />
            </v-col>
            <!---Product Sales-->
            <v-col cols="12" sm="12" md="6" lg="4" class="d-flex">
                <ProductSales />
            </v-col>
            <!---Net Sales-->
            <v-col cols="12" sm="12" md="6" lg="6" class="d-flex">
                <NetSells />
            </v-col>
            <!-- Payment Card  -->
            <v-col cols="12" lg="3" sm="6"  class="d-flex">
                <Payments />
            </v-col>
            <!-- Product Card -->
            <v-col cols="12" lg="3" sm="6"  class="d-flex">
                <Products />
            </v-col>
            <!---Trafic Distribution-->
            <v-col cols="12" sm="12" lg="6" >
                <TraficDistribution />
            </v-col>
            <!-- Payingchart  -->
            <v-col cols="12" lg="3"  sm="6" class="d-flex">
                <Payingchart/>
            </v-col>
            <!-- Payment Card  -->
            <v-col cols="12" lg="3"  sm="6" class="d-flex">
                <Customers />
            </v-col>
        </v-row>
    </FullLayout>
</template>
