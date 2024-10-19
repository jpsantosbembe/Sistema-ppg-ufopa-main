<script setup lang="ts">
import { ref } from 'vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
import SizeRatting from "@/Components/ui-components/ratting/SizeRatting.vue";
import UiChildCard from "@/Components/shared/UiChildCard.vue";
import IconsRatting from "@/Components/ui-components/ratting/IconsRatting.vue";
import LabelRatting from "@/Components/ui-components/ratting/LabelRatting.vue";
import LengthRatting from "@/Components/ui-components/ratting/LengthRatting.vue";
import HalfRatting from "@/Components/ui-components/ratting/HalfRatting.vue";
import HoverRatting from "@/Components/ui-components/ratting/HoverRatting.vue";
import ClearableRatting from "@/Components/ui-components/ratting/ClearableRatting.vue";
import ReadOnlyRatting from "@/Components/ui-components/ratting/ReadOnlyRatting.vue";
import BasicRatting from "@/Components/ui-components/ratting/BasicRatting.vue";
import UiParentCard from "@/Components/shared/UiParentCard.vue";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
// common components

// theme breadcrumb
const page = ref({ title: 'Ratting' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Ratting',
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
                <UiParentCard title="Rating">
                    <v-row>
                        <!-- Basic -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Basic">
                                <BasicRatting/>
                            </UiChildCard>
                        </v-col>
                        <!-- Read Only -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Read Only">
                                <ReadOnlyRatting/>
                            </UiChildCard>
                        </v-col>
                        <!-- Clearable -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Clearable">
                                <ClearableRatting/>
                            </UiChildCard>
                        </v-col>
                        <!-- Hover -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Hover">
                                <HoverRatting/>
                            </UiChildCard>
                        </v-col>
                        <!-- Half Ratting -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Half Ratting">
                                <HalfRatting/>
                            </UiChildCard>
                        </v-col>
                        <!-- Length Ratting -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Length">
                                <LengthRatting/>
                            </UiChildCard>
                        </v-col>



                        <!-- Label -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Label">
                                <LabelRatting/>
                            </UiChildCard>
                        </v-col>
                        <!-- Icons -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Icons">
                                <IconsRatting/>
                            </UiChildCard>
                        </v-col>
                        <!-- Size -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Size">
                                <SizeRatting/>
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
