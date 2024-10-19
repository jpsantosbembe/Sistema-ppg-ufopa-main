<script setup lang="ts">
import { ref } from 'vue';
// common Components
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import UiChildCard from '@/Components/shared/UiChildCard.vue';
import Default from '@/Components/forms/form-elements/switch/Default.vue';
import Label from '@/Components/forms/form-elements/switch/Label.vue';
import Inset from '@/Components/forms/form-elements/switch/Inset.vue';
import InsetColors from '@/Components/forms/form-elements/switch/InsetColors.vue';
import Colors from '@/Components/forms/form-elements/switch/Colors.vue';
import States from '@/Components/forms/form-elements/switch/States.vue';
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Switch' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Switch',
        disabled: true,
        href: '#'
    }
]);
</script>

// ===============================|| Ui Switch ||=============================== //
<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>
        <v-row>
            <v-col cols="12">
                <UiParentCard title="Switch">
                    <v-row>
                        <!-- Default Switch -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Default">
                                <Default/>
                            </UiChildCard>
                        </v-col>
                        <!-- Inset -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Inset">
                                <Inset/>
                            </UiChildCard>
                        </v-col>
                        <!-- With Label -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="With Label">
                                <Label/>
                            </UiChildCard>
                        </v-col>
                        <!-- States -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="States">
                                <States/>
                            </UiChildCard>
                        </v-col>
                        <!-- Colors -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Colors">
                                <Colors/>
                            </UiChildCard>
                        </v-col>
                        <!-- Inset Colors -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Inset Colors">
                                <InsetColors/>
                            </UiChildCard>
                        </v-col>

                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
