<script setup lang="ts">
import { ref } from 'vue';
// common Components
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import UiChildCard from '@/Components/shared/UiChildCard.vue';
import SelectDefualt from '@/Components/forms/form-elements/select/SelectDefault.vue';
import SelectReadonly from '@/Components/forms/form-elements/select/SelectReadOnly.vue';
import SelectMultiple from '@/Components/forms/form-elements/select/SelectMultiple.vue';
import SelectChip from '@/Components/forms/form-elements/select/SelectChip.vue';
import SelectDensity from '@/Components/forms/form-elements/select/SelectDensity.vue';
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Select' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Select',
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
                <UiParentCard title="Select">
                    <v-row>
                        <!--Select Basic-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Basic">
                                <SelectDefualt />
                            </UiChildCard>
                        </v-col>
                        <!--Select Readonly-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Read only">
                                <SelectReadonly/>
                            </UiChildCard>
                        </v-col>
                        <!--Select Multiple-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Multiple">
                                <SelectMultiple/>
                            </UiChildCard>
                        </v-col>
                        <!--Select Chip-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Chips">
                                <SelectChip/>
                            </UiChildCard>
                        </v-col>
                        <!--Select Density-->
                        <v-col cols="12" sm="12">
                            <UiChildCard title="Density">
                                <SelectDensity/>
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>

