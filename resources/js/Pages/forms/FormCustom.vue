<script setup lang="ts">
import { ref } from 'vue';
// common Components
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import CustomFrom from '@/Components/forms/form-custom/CustomFrom.vue'
// theme breadcrumb
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Custom Form' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Custom form',
        disabled: true,
        href: '#'
    }
]);
</script>

<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>

        <v-row>

            <v-col cols="12" class="mb-12">
                <UiParentCard title="Custom Form">
                    <CustomFrom/>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
