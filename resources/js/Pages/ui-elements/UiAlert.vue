<script setup lang="ts">
import { ref } from 'vue';
// common Components
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import UiChildCard from '@/Components/shared/UiChildCard.vue';


// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
import Basic from "@/Components/ui-components/expansionpanel/Basic.vue";
import Filled from "@/Components/ui-components/alert/Filled.vue";
import Outlined from "@/Components/ui-components/alert/Outlined.vue";
import Description from "@/Components/ui-components/alert/Description.vue";
import Action from "@/Components/ui-components/alert/Action.vue";
import Icons from "@/Components/ui-components/alert/Icons.vue";
import Closable from "@/Components/ui-components/alert/Closable.vue";
// theme breadcrumb
const page = ref({ title: 'Alert' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Alert',
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
                <UiParentCard title="Alert">
                    <v-row>
                        <!-- Basic -->
                        <v-col cols="12">
                            <UiChildCard title="Basic">
                                <Basic/>
                            </UiChildCard>
                        </v-col>
                        <!-- Filled -->
                        <v-col cols="12">
                            <UiChildCard title="Filled">
                                <Filled/>
                            </UiChildCard>
                        </v-col>
                        <!-- Outlined -->
                        <v-col cols="12">
                            <UiChildCard title="Outlined">
                                <Outlined/>
                            </UiChildCard>
                        </v-col>

                        <!-- Description -->
                        <v-col cols="12">
                            <UiChildCard title="Description">
                                <Description/>
                            </UiChildCard>
                        </v-col>
                        <!-- With Action -->
                        <v-col cols="12">
                            <UiChildCard title="Action">
                                <Action/>
                            </UiChildCard>
                        </v-col>
                        <!-- With Icons -->
                        <v-col cols="12">
                            <UiChildCard title="With Icons">
                                <Icons/>
                            </UiChildCard>
                        </v-col>

                        <!-- Closable -->
                        <v-col cols="12">
                            <UiChildCard title="Closable">
                                <Closable/>
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
