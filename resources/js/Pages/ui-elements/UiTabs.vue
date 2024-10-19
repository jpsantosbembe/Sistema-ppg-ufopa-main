
<script setup lang="ts">
import { ref } from 'vue';
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import UiParentCard from "@/Components/shared/UiParentCard.vue";
import UiChildCard from "@/Components/shared/UiChildCard.vue";
import BasicTabs from "@/Components/ui-components/tabs/BasicTabs.vue";
import IconsWithLabelTabs from "@/Components/ui-components/tabs/IconsWithLabelTabs.vue";
import CenterTabs from "@/Components/ui-components/tabs/CenterTabs.vue";
import CustomIcons from "@/Components/ui-components/tabs/CustomIcons.vue";
import AlignCenterTabs from "@/Components/ui-components/tabs/AlignCenterTabs.vue";
import AlignEndTabs from "@/Components/ui-components/tabs/AlignEndTabs.vue";
import IconTabs from "@/Components/ui-components/tabs/IconTabs.vue";
import DisableTabs from "@/Components/ui-components/tabs/DisableTabs.vue";
import ColorTabs from "@/Components/ui-components/tabs/ColorTabs.vue";
import FullLayout from "@/Layouts/full/FullLayout.vue";
// common components

// theme breadcrumb
const page = ref({ title: 'Tabs' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Tabs',
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
                <UiParentCard title="Tabs">
                    <v-row>
                        <!-- Basic -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Basic">
                                <BasicTabs/>
                            </UiChildCard>
                        </v-col>
                        <!-- With Icons -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Stacked">
                                <IconsWithLabelTabs/>
                            </UiChildCard>
                        </v-col>
                        <!-- Center -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Center Active">
                                <CenterTabs/>
                            </UiChildCard>
                        </v-col>
                        <!-- Custom Icons -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Custom Icons">
                                <CustomIcons/>
                            </UiChildCard>
                        </v-col>
                        <!-- Align Center -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Align Center">
                                <AlignCenterTabs/>
                            </UiChildCard>
                        </v-col>
                        <!-- Align End -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Align End">
                                <AlignEndTabs/>
                            </UiChildCard>
                        </v-col>
                        <!-- Icons -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Icon">
                                <IconTabs/>
                            </UiChildCard>
                        </v-col>
                        <!-- Disabled -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Disabled">
                                <DisableTabs/>
                            </UiChildCard>
                        </v-col>
                        <!-- Colors -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Colors">
                                <ColorTabs/>
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
