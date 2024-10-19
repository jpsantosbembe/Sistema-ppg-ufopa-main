<script setup lang="ts">
import { ref } from 'vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import UiParentCard from "@/Components/shared/UiParentCard.vue";
import UiChildCard from "@/Components/shared/UiChildCard.vue";
import SimpleList from "@/Components/ui-components/list/SimpleList.vue";
import NestedList from "@/Components/ui-components/list/NestedList.vue";
import FolderList from "@/Components/ui-components/list/FolderList.vue";
import DisabledList from "@/Components/ui-components/list/DisabledList.vue";
import SwitchList from "@/Components/ui-components/list/SwitchList.vue";
import RoundedList from "@/Components/ui-components/list/RoundedList.vue";
import CustomAlignList from "@/Components/ui-components/list/CustomAlignList.vue";
import ScrollableList from "@/Components/ui-components/list/ScrollableList.vue";
// theme breadcrumb
const page = ref({ title: 'List' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'List',
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
                <UiParentCard title="List">
                    <v-row>
                        <!-- Basic -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Simple List">
                                <SimpleList/>
                            </UiChildCard>
                        </v-col>
                        <!-- Nested List -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Nested List">
                                <NestedList/>
                            </UiChildCard>
                        </v-col>
                        <!-- Folder List -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Folder List">
                                <FolderList/>
                            </UiChildCard>
                        </v-col>
                        <!-- DisabledList-->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Disabled List">
                                <DisabledList/>
                            </UiChildCard>
                        </v-col>
                        <!-- Radio Button List -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Switch List">
                                <SwitchList/>
                            </UiChildCard>
                        </v-col>

                        <!-- Rounded List -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Rounded List">
                                <RoundedList/>
                            </UiChildCard>
                        </v-col>
                        <!-- Custom Aligned List -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Custom Aligned List">
                                <CustomAlignList/>
                            </UiChildCard>
                        </v-col>
                        <!-- Scrollable List -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Scrollable List">
                                <ScrollableList/>
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
