<script setup lang="ts">
import { ref } from 'vue';
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import UiParentCard from "@/Components/shared/UiParentCard.vue";
import UiChildCard from "@/Components/shared/UiChildCard.vue";
import DialogsActivator from "@/Components/ui-components/dialogs/DialogsActivator.vue";
import DialogsModel from "@/Components/ui-components/dialogs/DialogsModel.vue";
import DialogsTransitions from "@/Components/ui-components/dialogs/DialogsTransitions.vue";
import DialogsForm from "@/Components/ui-components/dialogs/DialogsForm.vue";
import DialogsFullscreen from "@/Components/ui-components/dialogs/DialogsFullscreen.vue";
import DialogsPersistent from "@/Components/ui-components/dialogs/DialogsPersistent.vue";
import DialogsScrollable from "@/Components/ui-components/dialogs/DialogsScrollable.vue";
import DialogsNested from "@/Components/ui-components/dialogs/DialogsNested.vue";
import FullLayout from "@/Layouts/full/FullLayout.vue";
// common components

// theme breadcrumb
const page = ref({ title: 'Dialog' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Dialog',
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
                <UiParentCard title="Dialog">
                    <v-row>
                        <v-col cols="12" sm="12" lg="4">
                            <UiChildCard title="Simple">
                                <DialogsActivator />
                            </UiChildCard>
                        </v-col>
                        <v-col cols="12" sm="12" lg="4">
                            <UiChildCard title="V-model">
                                <DialogsModel />
                            </UiChildCard>
                        </v-col>
                        <v-col cols="12" sm="12" lg="4" class="d-flex align-items-stretch">
                            <UiChildCard title="Transition">
                                <DialogsTransitions />
                            </UiChildCard>
                        </v-col>
                        <v-col cols="12" sm="12" lg="4" class="d-flex align-items-stretch">
                            <UiChildCard title="Form">
                                <DialogsForm />
                            </UiChildCard>
                        </v-col>
                        <v-col cols="12" sm="12" lg="4" class="d-flex align-items-stretch">
                            <UiChildCard title="Full screen">
                                <DialogsFullscreen />
                            </UiChildCard>
                        </v-col>

                        <v-col cols="12" sm="12" lg="4" class="d-flex align-items-stretch">
                            <UiChildCard title="Persistent">
                                <DialogsPersistent />
                            </UiChildCard>
                        </v-col>
                        <v-col cols="12" sm="12" lg="4" class="d-flex align-items-stretch">
                            <UiChildCard title="Scrollable">
                                <DialogsScrollable />
                            </UiChildCard>
                        </v-col>

                        <v-col cols="12" sm="12" lg="4" class="d-flex align-items-stretch">
                            <UiChildCard title="Nested Dialog">
                                <DialogsNested />
                            </UiChildCard>
                        </v-col>
                    </v-row>
                </UiParentCard>
            </v-col>
        </v-row>
    </FullLayout>
</template>
