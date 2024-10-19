<script setup>
import CongratsCard from "@/Components/dashboards/dashboard1/CongratulationsCard.vue";
import Payments from "@/Components/dashboards/dashboard1/Payments.vue";
import Products from "@/Components/dashboards/dashboard1/ProductsChart.vue";
import LatestDeal from "@/Components/dashboards/dashboard1/LatestDeals.vue";
import Customers from "@/Components/dashboards/dashboard1/Customers.vue";
import ProductsTable from "@/Components/dashboards/dashboard1/ProductsTable.vue";
import VisitFromUsa from "@/Components/dashboards/dashboard1/VisitFromUsa.vue";
import LatestReviews1 from "@/Components/dashboards/dashboard1/LatestReviews.vue";
import FullLayout from "@/Layouts/full/FullLayout.vue";

const props = defineProps({
    data: Array,
});

</script>

<template>
    <FullLayout>
        <v-row>
            <!-- Congratulation Card -->
            <v-col cols="12" sm="12" lg="6">
                <CongratsCard />
            </v-col>
            <v-col cols="12" sm="12" md="12" lg="6">
                <v-row>
                    <!-- Payment Card  -->
                    <v-col cols="12" sm="6">
                        <Payments :data="data" />
                    </v-col>
                    <!-- Product Card -->
                    <v-col cols="12" sm="6" class="d-flex">
                        <Products />
                    </v-col>
                    <!-- LatestDeal Card -->
                    <v-col cols="12" sm="6">
                        <LatestDeal />
                    </v-col>
                    <!-- Customer Card -->
                    <v-col cols="12" sm="6" class="d-flex">
                        <Customers />
                    </v-col>
                </v-row>
            </v-col>
            <!-- Products Table  -->
            <v-col cols="12" sm="12" lg="8">
                <ProductsTable />
            </v-col>
            <!-- Visit From USA  -->
            <v-col cols="12" sm="12" lg="4">
                <!-- <VisitFromUsa :data="data" /> -->
            </v-col>
            <!-- Latest reviews -->
            <v-col cols="12" sm="12" lg="12">
                <LatestReviews1 />
            </v-col>
        </v-row>
    </FullLayout>
</template>
