<script setup lang="ts">
import { ref } from 'vue';
import FullLayout from "../../../Layouts/full/FullLayout.vue";
import ChatProfile from "../../../Components/apps/chats/ChatProfile.vue";
import AppBaseCard from "../../../Components/shared/AppBaseCard.vue";
import ChatListing from "../../../Components/apps/chats/ChatListing.vue";
import ChatDetail from "../../../Components/apps/chats/ChatDetail.vue";
// common components


// theme breadcrumb
const page = ref({ title: 'Chat app' });

const breadcrumbs = ref([
    {
        text: 'Messenger',
        disabled: true,
        href: '#'
    }
]);
</script>

<template>
    <!-- ---------------------------------------------------- -->
    <!-- Table Basic -->
    <!-- ---------------------------------------------------- -->
    <!-- <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb> -->

    <FullLayout>
        <v-card elevation="10">
            <AppBaseCard>
                <template v-slot:leftpart>
                    <div class="no-scrollbar">
                        <ChatProfile />
                        <ChatListing />
                    </div>
                </template>
                <template v-slot:rightpart>
                    <ChatDetail />
                </template>

                <template v-slot:mobileLeftContent>
                    <ChatProfile />
                    <ChatListing />
                </template>
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
