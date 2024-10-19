<script setup lang="ts">
import { ref } from 'vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import UiParentCard from "@/Components/shared/UiParentCard.vue";
import UiChildCard from "@/Components/shared/UiChildCard.vue";
import Custom from "@/Components/forms/form-elements/slider/Custom.vue";
import ColorCheckboxes from "@/Components/forms/form-elements/checkbox/ColorCheckboxes.vue";
import LabelCheckboxes from "@/Components/forms/form-elements/checkbox/LabelCheckboxes.vue";
import BasicCheckboxes from "@/Components/forms/form-elements/checkbox/BasicCheckboxes.vue";

// theme breadcrumb
const page = ref({ title: 'Checkbox' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Checkbox',
        disabled: true,
        href: '#'
    }
]);
</script>

// ===============================|| Ui Checkbox ||=============================== //
<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>

        <v-row>
            <v-col cols="12">
                <UiParentCard title="Checkbox">
                    <v-row>
                        <!-- Custom checkboxes -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Custom">
                                <Custom/>
                            </UiChildCard>
                        </v-col>
                        <!-- With Colors -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Colors">
                                <ColorCheckboxes/>
                            </UiChildCard>
                        </v-col>
                        <!-- Basic checkboxes -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Default">
                                <BasicCheckboxes/>
                            </UiChildCard>
                        </v-col>
                        <!-- With label -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="States">
                                <LabelCheckboxes/>
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
