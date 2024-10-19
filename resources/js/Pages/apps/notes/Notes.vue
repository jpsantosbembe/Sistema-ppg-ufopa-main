<script setup lang="ts">
import { ref } from 'vue';

// component

import AppBaseCard from "../../../Components/shared/AppBaseCard.vue";
import FullLayout from "../../../Layouts/full/FullLayout.vue";
import NotesListing from "../../../Components/apps/notes/NotesListing.vue";
import NotesContent from "../../../Components/apps/notes/NotesContent.vue";

</script>

<template>
    <!-- ---------------------------------------------------- -->
    <!-- Table Basic -->
    <!-- ---------------------------------------------------- -->
    <FullLayout>
        <v-card elevation="10">
            <AppBaseCard>
                <template v-slot:leftpart> <NotesListing /></template>
                <template v-slot:rightpart><NotesContent /> </template>

                <template v-slot:mobileLeftContent><NotesListing /> </template>
            </AppBaseCard>
        </v-card>
    </FullLayout>
</template>

<style scoped lang="scss">
@media (max-width: 1279px) {
    .v-card {
        position: unset;
    }
}
</style>
