<script setup lang="ts">
import { ref} from 'vue';
// common Components
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import UiParentCardLogo from '@/Components/shared/UiParentCardLogo.vue';
import UiChildCard from '@/Components/shared/UiChildCard.vue';
import VeeValidation from '@/Components/forms/form-validation/VeeValidation.vue'
import MailValidation from '@/Components/forms/form-validation/MailValidation.vue'
import OnType from '@/Components/forms/form-validation/OnType.vue'
import Radio from '@/Components/forms/form-validation/Radio.vue'
import CheckBox from '@/Components/forms/form-validation/CheckBox.vue'
import SelectBox from '@/Components/forms/form-validation/Select.vue'
import { Form } from 'vee-validate';
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Form Validation' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Form validation',
        disabled: true,
        href: '#'
    }
]);

// theme breadcrumb
</script>

<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>
        <v-row>
            <v-col cols="12" lg="6" class="mb-0">
                <UiParentCardLogo>
                    <VeeValidation/>
                </UiParentCardLogo>
            </v-col>
            <v-col cols="12" lg="6" class="mb-0">
                <UiParentCardLogo>
                    <MailValidation/>
                </UiParentCardLogo>
                <UiParentCard title="Select" class="mt-6">
                    <SelectBox/>
                </UiParentCard>
            </v-col>
            <v-col cols="12" lg="6" class="">
                <UiParentCard title="On Leave">
                    <OnType/>
                </UiParentCard>
            </v-col>
            <v-col cols="12" lg="6" class="">
                <UiParentCard title="Checkboxes">
                    <CheckBox/>
                </UiParentCard>
            </v-col>
            <v-col cols="12" lg="6" class="">
                <UiParentCard title="Radio">
                    <Radio/>
                </UiParentCard>
            </v-col>

        </v-row>
    </FullLayout>
</template>
