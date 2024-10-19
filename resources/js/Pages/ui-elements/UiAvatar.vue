<script setup lang="ts">
import { ref } from 'vue';
// common components
import UiParentCard from '@/Components/shared/UiParentCard.vue';
import UiChildCard from '@/Components/shared/UiChildCard.vue';
// common components
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import ImageAvatar from "@/Components/ui-components/avatar/ImageAvatar.vue";
import LetterAvatar from "@/Components/ui-components/avatar/LetterAvatar.vue";
import IconAvatar from "@/Components/ui-components/avatar/IconAvatar.vue";
import VariantAvatar from "@/Components/ui-components/avatar/VariantAvatar.vue";
import SizeAvatar from "@/Components/ui-components/avatar/SizeAvatar.vue";
import FullLayout from "@/Layouts/full/FullLayout.vue";
// theme breadcrumb
const page = ref({ title: 'Avatar' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Avatar',
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
                <UiParentCard title="Avatar">
                    <v-row>
                        <!-- Basic Avatar -->
                        <!-- <v-col cols="12" lg="4">
                            <UiChildCard title="Basic Avatar">
                               <BasicAvatar/>
                            </UiChildCard>
                        </v-col> -->
                        <!-- Image Avatar -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Image Avatars">
                                <ImageAvatar/>
                            </UiChildCard>
                        </v-col>
                        <!-- Letter Avatar -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Letter Avatars">
                                <LetterAvatar/>
                            </UiChildCard>
                        </v-col>
                        <!-- Icon Avatar -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Icon Avatars">
                                <IconAvatar/>
                            </UiChildCard>
                        </v-col>
                        <!-- Variant Avatar -->
                        <v-col cols="12" lg="4">
                            <UiChildCard title="Variant" class="pb-10">
                                <VariantAvatar/>
                            </UiChildCard>
                        </v-col>
                        <!-- Size Avatar -->
                        <v-col cols="12" lg="8">
                            <UiChildCard title="Sizes">
                                <SizeAvatar/>
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
