<script setup lang="ts">
import { ref } from 'vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import UiParentCard from "@/Components/shared/UiParentCard.vue";
import UiChildCard from "@/Components/shared/UiChildCard.vue";
import InputError from "@/Components/forms/form-elements/custominput/InputError.vue";
import InputMultipleError from "@/Components/forms/form-elements/custominput/InputMultipleError.vue";
import InputLoading from "@/Components/forms/form-elements/custominput/InputLoading.vue";
import InputHideDetails from "@/Components/forms/form-elements/custominput/InputHideDetails.vue";
import InputPrepandAppend from '@/Components/forms/form-elements/custominput/InputAppendPrepend.vue';
import InputRules from "@/Components/forms/form-elements/custominput/InputRules.vue";
// common components

// theme breadcrumb
const page = ref({ title: 'Custom Inputs' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Custom inputs',
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
                <UiParentCard title="Custom Inputs">
                    <v-row>
                        <!-- Input error-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Error">
                                <InputError />
                            </UiChildCard>
                        </v-col>
                        <!-- Multiple Input error-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Multiple Error">
                                <InputMultipleError />
                            </UiChildCard>
                        </v-col>
                        <!-- Input loading-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Loading">
                                <InputLoading />
                            </UiChildCard>
                        </v-col>
                        <!-- Input Append and prepend-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Append and Prepend">
                                <InputPrepandAppend />
                            </UiChildCard>
                        </v-col>
                        <!-- Input Hide Details-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Hide Details">
                                <InputHideDetails />
                            </UiChildCard>
                        </v-col>
                        <!-- Input Rules-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Rules">
                                <InputRules />
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>

