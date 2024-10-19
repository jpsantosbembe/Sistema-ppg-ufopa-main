<script setup lang="ts">
import { ref } from 'vue';
// common components


// common components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
import UiParentCard from "@/Components/shared/UiParentCard.vue";
import UiChildCard from "@/Components/shared/UiChildCard.vue";
import FilledColor from "@/Components/ui-components/chip/FilledColor.vue";
import Outlined from "@/Components/ui-components/alert/Outlined.vue";
import CustomIcon from "@/Components/ui-components/chip/CustomIcon.vue";
import CustomIconOutlined from "@/Components/ui-components/chip/CustomIconOutlined.vue";
import Disabled from "@/Components/ui-components/chip/Disabled.vue";
import Sizes from "@/Components/ui-components/chip/Sizes.vue";
import Closable from "@/Components/ui-components/alert/Closable.vue";
// theme breadcrumb
const page = ref({ title: 'Chip' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Chip',
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
                <UiParentCard title="Chip">
                    <v-row>
                        <!-- Filled Color -->
                        <v-col cols="12" >
                            <UiChildCard title="Filled">
                                <FilledColor/>
                            </UiChildCard>
                        </v-col>
                        <!-- Outlined -->
                        <v-col cols="12" >
                            <UiChildCard title="Outlined">
                                <Outlined/>
                            </UiChildCard>
                        </v-col>
                        <!-- Label with Icon -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Custom Icon">
                                <CustomIcon/>
                            </UiChildCard>
                        </v-col>
                        <!-- Outlined Color -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Custom Outlined Icon">
                                <CustomIconOutlined/>
                            </UiChildCard>
                        </v-col>
                        <!-- Disabled -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Disabled">
                                <Disabled/>
                            </UiChildCard>
                        </v-col>
                        <!-- Sizes -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Sizes">
                                <Sizes/>
                            </UiChildCard>
                        </v-col>
                        <!-- Closable -->
                        <v-col cols="12" >
                            <UiChildCard title="Closable">
                                <Closable/>
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
