<script setup lang="ts">
import { ref } from 'vue';
// common components
import BlogPosts from '@/Components/apps/blog/blogPosts.vue';
import FullLayout from "@/Layouts/full/FullLayout.vue";

// theme breadcrumb
const page = ref({ title: 'Blog app' });
const breadcrumbs = ref([
    {
        text: 'Get the latest news',
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
       <v-row>
           <v-col cols="12">
               <BlogPosts/>
           </v-col>
       </v-row>
   </FullLayout>
</template>
