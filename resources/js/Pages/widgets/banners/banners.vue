<script setup lang="ts">
import { ref } from 'vue';
/*Call Components*/
import Banner1 from '@/Components/widgets/banners/Banner1.vue';
import Banner2 from "@/Components/widgets/banners/Banner2.vue";
import Banner3 from "@/Components/widgets/banners/Banner3.vue";
import Banner4 from "@/Components/widgets/banners/Banner4.vue";
import Banner5 from "@/Components/widgets/banners/Banner5.vue";
import Banner6 from "@/Components/widgets/banners/Banner6.vue";
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Banner' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Banner',
        disabled: true,
        href: '#'
    }
]);

</script>
<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>
        <v-row>
            <v-col cols="12" lg="8">
                <!--Banner 1-->
                <Banner1/>
                <!--Banner 2-->
                <Banner2/>
                <v-row>
                    <!--Banner 3-->
                    <v-col cols="12" sm="6">
                        <Banner3/>
                    </v-col>
                    <!--Banner 4-->
                    <v-col cols="12" sm="6">
                        <Banner4/>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" lg="4">
                <!--Banner 5-->
                <Banner5/>
                <!--Banner 6-->
                <Banner6/>
            </v-col>
        </v-row>
    </FullLayout>
</template>
