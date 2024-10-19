<script setup lang="ts">
import { ref } from 'vue';
import ProductDetail from '@/Components/apps/ecommerce/detail/ProductDetail.vue';
import RelatedProducts from '@/Components/apps/ecommerce/detail/RelatedProducts.vue';
import ProductTab from '@/Components/apps/ecommerce/detail/ProductTab.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";

const page = ref({ title: 'Products' });
const breadcrumbs = ref([
    {
        text: 'Ecommerce',
        disabled: false,
        href: '#'
    },
    {
        text: 'product Page',
        disabled: true,
        href: '#'
    }
]);
</script>

<template>
    <!-- <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb> -->
    <FullLayout>
        <v-row>
            <v-col cols="12">
                <v-card elevation="10">
                    <v-card-text>
                        <ProductDetail />
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12">
                <ProductTab />
            </v-col>
            <v-col cols="12">
                <RelatedProducts />
            </v-col>
        </v-row>
    </FullLayout>
</template>
