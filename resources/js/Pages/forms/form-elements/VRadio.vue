<script setup lang="ts">
import { ref } from 'vue';
// common Components
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import UiChildCard from '@/Components/shared/UiChildCard.vue';

// icons
import { AccessPointIcon } from 'vue-tabler-icons';
import Default from '@/Components/forms/form-elements/radio/Default.vue';
import Label from '@/Components/forms/form-elements/radio/Label.vue';
import DefaultDirection from '@/Components/forms/form-elements/radio/DefaultDirection.vue';
import InlineDirection from '@/Components/forms/form-elements/radio/InlineDirection.vue';
import Color from '@/Components/forms/form-elements/radio/Color.vue';
import ColorwithLabel from '@/Components/forms/form-elements/radio/LabelwithColor.vue';
// common Components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Radio' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Radio',
        disabled: true,
        href: '#'
    }
]);

</script>

// ===============================|| Ui Radio ||=============================== //
<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>
        <v-row>
            <v-col cols="12">
                <UiParentCard title="Radio">
                    <v-row>
                        <!-- Default Radio -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Default">
                                <Default/>
                            </UiChildCard>
                        </v-col>
                        <!-- Radio with Label -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Label">
                                <Label/>
                            </UiChildCard>
                        </v-col>
                        <!-- With Colors -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Colors">
                                <Color/>
                            </UiChildCard>
                        </v-col>
                        <!-- With Colors -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Colors with Label">
                                <ColorwithLabel/>
                            </UiChildCard>
                        </v-col>
                        <!-- Default Direction -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Default Direction">
                                <DefaultDirection/>
                            </UiChildCard>
                        </v-col>
                        <!-- Inline Direction -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Inline Direction">
                                <InlineDirection/>
                            </UiChildCard>
                        </v-col>

                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
