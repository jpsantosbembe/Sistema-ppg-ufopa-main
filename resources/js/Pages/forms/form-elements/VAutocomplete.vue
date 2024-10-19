<script setup lang="ts">
import { ref } from 'vue';

// icons
import { AccessPointIcon, MailIcon } from 'vue-tabler-icons';
import FullLayout from "@/Layouts/full/FullLayout.vue";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import UiParentCard from "@/Components/shared/UiParentCard.vue";
import UiChildCard from "@/Components/shared/UiChildCard.vue";
import ComboBox from "@/Components/forms/form-elements/autocomplete/ComboBox.vue";
import WithCaption from "@/Components/forms/form-elements/autocomplete/WithCaption.vue";
import MultipleOptions from "@/Components/forms/form-elements/autocomplete/MultipleOptions.vue";

// theme breadcrumb
const page = ref({ title: 'AutoComplete' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Autocomplete',
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
                <UiParentCard title="Autocomplete">
                    <v-row>
                        <!-- Combo Box -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Combo Box">
                                <ComboBox />
                            </UiChildCard>
                        </v-col>
                        <!-- With Caption -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="With Caption">
                                <WithCaption />
                            </UiChildCard>
                        </v-col>
                        <!-- Combo with Multiple Options -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Combo with Multiple Options">
                                <MultipleOptions />
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
