<script setup lang="ts">
import { ref } from 'vue';
// common components
import BlogDetail from '@/Components/apps/blog/detail/blogDetail.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";

// theme breadcrumb
const page = ref({ title: 'Blog Detail' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        to: '/'
    },
    {
        text: 'Blog',
        disabled: false,
        to: '/apps/blog/posts'
    },
    {
        text: 'Blog post',
        disabled: true,
    }
]);
</script>

<template>
    <!-- ---------------------------------------------------- -->
    <!-- Table Basic -->
    <!-- ---------------------------------------------------- -->
    <!-- <BaseBreadcrumb :title="page.title" class="" :breadcrumbs="breadcrumbs"></BaseBreadcrumb> -->
    <FullLayout>
        <v-row>
            <v-col cols="12">
                <BlogDetail/>
            </v-col>
        </v-row>
    </FullLayout>
</template>
