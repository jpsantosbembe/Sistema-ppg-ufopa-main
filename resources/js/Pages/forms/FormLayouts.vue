<script setup lang="ts">
import { ref } from 'vue';
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import UiChildCard from '@/Components/shared/UiChildCard.vue';
import OrdinaryForm from "@/Components/forms/form-layouts/OrdinaryForm.vue";
import InputVarients from "@/Components/forms/form-layouts/InputVarients.vue";
import DefaultForm from "@/Components/forms/form-layouts/DefaultForm.vue";
import BasicHeaderForm from "@/Components/forms/form-layouts/BasicHeaderForm.vue";
import DisabledForm from "@/Components/forms/form-layouts/DisabledForm.vue";
import FormLeftIcon from "@/Components/forms/form-layouts/FormLeftIcon.vue";
import FormRightIcon from "@/Components/forms/form-layouts/FormRightIcon.vue";

// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Form Layout' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Form layout',
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
                <UiParentCard title="Ordinary Form">
                    <OrdinaryForm/>
                </UiParentCard>
                <UiParentCard title="Input Variants" class="mt-6">
                    <InputVarients/>
                </UiParentCard>
                <UiParentCard title="Default Form" class="mt-6">
                    <DefaultForm/>
                </UiParentCard>
                <UiParentCard title="Basic Header Form" class="mt-6">
                    <BasicHeaderForm/>
                </UiParentCard>
                <UiParentCard title="Disabled Form" class="mt-6">
                    <DisabledForm/>
                </UiParentCard>
            </v-col>
            <!----input with icon----->
            <v-col cols="12" md="6">
                <UiParentCard title="Form with Left Icon" >
                    <FormLeftIcon/>
                </UiParentCard>
            </v-col>
            <v-col cols="12" md="6">
                <UiParentCard title="Form with Right Icon" >
                    <FormRightIcon/>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
