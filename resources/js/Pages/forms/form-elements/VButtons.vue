<script setup lang="ts">
import { ref } from 'vue';
/*import tabler icons*/
import { TrashIcon, SendIcon, BellIcon } from 'vue-tabler-icons';


// icons
import { AccessPointIcon } from 'vue-tabler-icons';

// common components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";
import UiParentCard from "@/Components/shared/UiParentCard.vue";
import UiChildCard from "@/Components/shared/UiChildCard.vue";
import BaseButtons from "@/Components/forms/form-elements/button/BaseButtons.vue";
import ColorsButtons from "@/Components/forms/form-elements/button/ColorsButtons.vue";
import SizeButtons from "@/Components/forms/form-elements/button/SizeButtons.vue";
import OutlinedButtons from "@/Components/forms/form-elements/button/OutlinedButtons.vue";
import IconsButtons from "@/Components/forms/form-elements/button/IconsButtons.vue";
import OutlineSizes from "@/Components/forms/form-elements/button/OutlineSizes.vue";
import TextButtons from "@/Components/forms/form-elements/button/TextButtons.vue";
import IconColor from "@/Components/forms/form-elements/button/IconColor.vue";
import OutlineIconColor from "@/Components/forms/form-elements/button/OutlineIconColor.vue";
import IconColorSizes from "@/Components/forms/form-elements/button/IconColorSizes.vue";
import OutlinedIconSize from "@/Components/forms/form-elements/button/OutlinedIconSize.vue";
import Text from "@/Components/forms/form-elements/button/buttonGroup/Text.vue";
import Plain from "@/Components/forms/form-elements/button/buttonGroup/Plain.vue";
import Outlined from "@/Components/ui-components/alert/Outlined.vue";
// theme breadcrumb
const page = ref({ title: 'Buttons' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Buttons',
        disabled: true,
        href: '#'
    }
]);

// buttons color data
const btnsColor = ref(['primary', 'secondary', 'success', 'error', 'warning']);

</script>

<template>
    <FullLayout>
        <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>
        <v-row>
            <v-col cols="12">
                <UiParentCard title="Buttons">
                    <v-row>
                        <!-- Base Buttons -->
                        <v-col cols="12" sm="12">
                            <UiChildCard title="Base">
                                <BaseButtons />
                            </UiChildCard>
                        </v-col>
                        <!-- Color Buttons -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Colors">
                                <ColorsButtons />
                            </UiChildCard>
                        </v-col>
                        <!-- Sizes -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Size">
                                <SizeButtons />
                            </UiChildCard>
                        </v-col>
                        <!-- Outlined Buttons -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Outlined">
                                <OutlinedButtons />
                            </UiChildCard>
                        </v-col>
                        <!-- With Icons -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Outlined Icon">
                                <IconsButtons />
                            </UiChildCard>
                        </v-col>

                        <!-- OutlineSizes -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Outline Size">
                                <OutlineSizes />
                            </UiChildCard>
                        </v-col>
                        <!-- Text Buttons -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Text Color">
                                <TextButtons />
                            </UiChildCard>
                        </v-col>
                        <!-- Icon Color -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Icon Color">
                                <IconColor />
                            </UiChildCard>
                        </v-col>
                        <!-- Outllined Icon Button -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Outlined Icon Color">
                                <OutlineIconColor />
                            </UiChildCard>
                        </v-col>
                        <!-- Icon Color Sizes -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Icon Size">
                                <IconColorSizes />
                            </UiChildCard>
                        </v-col>
                        <!-- Outllined Icon Button -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Outlined Icon Size">
                                <OutlinedIconSize />
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>

            <v-col cols="12">
                <UiParentCard title="Button Group">
                    <v-row>
                        <!-- Default -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Default">
                                <Default />
                            </UiChildCard>
                        </v-col>
                        <!-- Text -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Text">
                                <Text />
                            </UiChildCard>
                        </v-col>
                        <!-- Plain -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Plain">
                                <Plain />
                            </UiChildCard>
                        </v-col>
                        <!-- Outlined -->
                        <v-col cols="12" lg="6">
                            <UiChildCard title="Outlined">
                                <Outlined />
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
