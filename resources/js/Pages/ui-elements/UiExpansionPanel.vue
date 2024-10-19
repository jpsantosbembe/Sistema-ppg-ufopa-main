<script setup lang="ts">
import { ref } from 'vue';
// common components
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import UiChildCard from '@/Components/shared/UiChildCard.vue';


// common components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
import Basic from "@/Components/ui-components/expansionpanel/Basic.vue";
import DefaultExpand from "@/Components/ui-components/expansionpanel/DefaultExpand.vue";
import Inset from "@/Components/ui-components/expansionpanel/Inset.vue";
import Popout from "@/Components/ui-components/expansionpanel/Popout.vue";
import Advance from "@/Components/ui-components/expansionpanel/Advance.vue";
import CustomizedIcon from "@/Components/ui-components/expansionpanel/CustomizedIcon.vue";
// theme breadcrumb
const page = ref({ title: 'Accordion' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Accordion',
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
                <UiParentCard title="Accordian">
                    <v-row>
                        <!-- Basic -->
                        <v-col cols="12" >
                            <UiChildCard title="Basic">
                                <Basic/>
                            </UiChildCard>
                        </v-col>
                        <!-- Default Expand -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Default Expand">
                                <DefaultExpand/>
                            </UiChildCard>
                        </v-col>
                        <!-- Inset -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Inset">
                                <Inset/>
                            </UiChildCard>
                        </v-col>
                        <!-- Popout -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Popout">
                                <Popout/>
                            </UiChildCard>
                        </v-col>
                        <!-- Advance -->
                        <v-col cols="12" lg="12">
                            <UiChildCard title="Advance">
                                <Advance/>
                            </UiChildCard>
                        </v-col>

                        <!-- Customized Icon -->
                        <v-col cols="12">
                            <UiChildCard title="Customized Icon">
                                <CustomizedIcon/>
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
