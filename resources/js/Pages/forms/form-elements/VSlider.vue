<script setup lang="ts">
import { ref } from 'vue';
// common Components
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import UiChildCard from '@/Components/shared/UiChildCard.vue';

 import Default from '@/Components/forms/form-elements/slider/Default.vue';
 import Disabled from '@/Components/forms/form-elements/slider/Disabled.vue';
 import Volume from '@/Components/forms/form-elements/slider/Volume.vue';
 import TickSize from '@/Components/forms/form-elements/slider/TickSize.vue';
 import Steps from '@/Components/forms/form-elements/slider/Steps.vue';
 import Ticks from '@/Components/forms/form-elements/slider/Ticks.vue';
 import Vertical from '@/Components/forms/form-elements/slider/Vertical.vue';
 import Custom from '@/Components/forms/form-elements/slider/Custom.vue';
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Slider' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Slider',
        disabled: true,
        href: '#'
    }
]);

</script>
<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>

        <v-row>
            <v-col cols="12">
                <UiParentCard title="Slider">
                    <v-row>
                        <!-- Default Slider -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Default">
                                <Default/>
                            </UiChildCard>
                        </v-col>
                        <!-- Volume -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Icon">
                                <Volume/>
                            </UiChildCard>
                        </v-col>
                        <!-- Disabled -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Disabled">
                                <Disabled/>
                            </UiChildCard>
                        </v-col>
                        <!-- Steps -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Steps">
                                <Steps/>
                            </UiChildCard>
                        </v-col>
                        <!-- Ticks -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Ticks">
                                <Ticks/>
                            </UiChildCard>
                        </v-col>
                        <!-- Tick Size-->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Tick Size">
                                <TickSize/>
                            </UiChildCard>
                        </v-col>
                        <!-- Custom-->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Custom">
                                <Custom/>
                            </UiChildCard>
                        </v-col>
                        <!-- Vertical Slider -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Vertical">
                                <Vertical/>
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
