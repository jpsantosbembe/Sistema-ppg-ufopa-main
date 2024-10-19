<script setup lang="ts">
import { ref } from 'vue';
// common Components
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import UiChildCard from '@/Components/shared/UiChildCard.vue';

/*Components*/
import DatePicker from '@/Components/forms/form-elements/datetime/DatePicker.vue';
import TimePicker from '@/Components/forms/form-elements/datetime/TimePicker.vue';
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Date Time' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Date time',
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
                <UiParentCard title="Date Time">
                    <v-row>
                        <!-- Date Picker -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Date Picker">
                                <DatePicker/>
                            </UiChildCard>
                        </v-col>
                        <!-- Time Picker -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Time Picker">
                                <TimePicker/>
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
