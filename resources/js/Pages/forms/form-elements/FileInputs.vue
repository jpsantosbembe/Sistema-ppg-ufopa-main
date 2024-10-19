<script setup lang="ts">
import { ref } from 'vue';

import FullLayout from "@/Layouts/full/FullLayout.vue";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import UiParentCard from "@/Components/shared/UiParentCard.vue";
import UiChildCard from "@/Components/shared/UiChildCard.vue";
import FileAccept from '@/Components/forms/form-elements/fileinput/FileInputAccept.vue';
import FileChips from '@/Components/forms/form-elements/fileinput/FileInputChips.vue';
import FileCounter from '@/Components/forms/form-elements/fileinput/FileInputCounter.vue';
import FileDensity from '@/Components/forms/form-elements/fileinput/FileInputDensity.vue';
import FileMultiple from '@/Components/forms/form-elements/fileinput/FileInputMultiple.vue';
import FilePrepand from '@/Components/forms/form-elements/fileinput/FileInputPrepand.vue';
import FileValidation from '@/Components/forms/form-elements/fileinput/FileInputValidation.vue';
import FileSelection from '@/Components/forms/form-elements/fileinput/FileInputSelection.vue';


// theme breadcrumb
const page = ref({ title: 'File Inputs' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'File inputs',
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
                <UiParentCard title="File Inputs">
                    <v-row>
                        <!-- File accept-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Accept">
                                <FileAccept />
                            </UiChildCard>
                        </v-col>
                        <!-- File chips-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Chips">
                                <FileChips />
                            </UiChildCard>
                        </v-col>
                        <!-- File counter-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Counter">
                                <FileCounter />
                            </UiChildCard>
                        </v-col>
                        <!-- File density-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Density">
                                <FileDensity />
                            </UiChildCard>
                        </v-col>
                        <!-- File multiple-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Multiple">
                                <FileMultiple />
                            </UiChildCard>
                        </v-col>
                        <!-- File prepend icon-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Prepend Icon">
                                <FilePrepand/>
                            </UiChildCard>
                        </v-col>
                        <!-- File validation-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Validation">
                                <FileValidation/>
                            </UiChildCard>
                        </v-col>
                        <!-- File selection slots-->
                        <v-col cols="12" sm="6">
                            <UiChildCard title="Complex selection slots">
                                <FileSelection/>
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>

