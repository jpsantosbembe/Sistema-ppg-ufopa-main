<script setup lang="ts">
import { ref } from 'vue';


import FullLayout from "@/Layouts/full/FullLayout.vue";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import UiParentCard from "@/Components/shared/UiParentCard.vue";
import UiChildCard from "@/Components/shared/UiChildCard.vue";
import ComboboxDense from "@/Components/forms/form-elements/combobox/ComboboxDense.vue";
import ComboboxMultiple from "@/Components/forms/form-elements/combobox/ComboboxMultiple.vue";
// theme breadcrumb
const page = ref({ title: 'Combobox' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Combobox',
        disabled: true,
        href: '#'
    }
]);


</script>
<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"/>

        <v-row>
            <v-col cols="12">
                <UiParentCard title="Combobox">
                    <v-row>
                        <!-- Density Combobox -->
                        <v-col cols="12" sm="12">
                            <UiChildCard title="Density">
                                <ComboboxDense />
                            </UiChildCard>
                        </v-col>
                        <!-- Multiple Combobox -->
                        <v-col cols="12" sm="12">
                            <UiChildCard title="Multiple">
                                <ComboboxMultiple />
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>

