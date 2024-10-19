<script setup lang="ts">
import BlogGrid from './blogCardGrid.vue';
import FeatuteBlogCard from './featureBlogCard.vue';
import { computed } from 'vue';
import {BlogPost, BlogComment} from "#/apps/blog";


const getPosts = computed(() => {
    return BlogPost
});

const filterFeaturedpost = computed(() => {
    return getPosts.value.filter((post) => {
        return post.featured;
    });
});
</script>
<template>
    <v-row>
        <template v-for="(post, i) in filterFeaturedpost" :key="post.id">
            <FeatuteBlogCard :post="post" :index="i" />
        </template>
        <template v-for="(post, i) in getPosts" :key="post.id">
            <BlogGrid :post="post" />
        </template>
    </v-row>
</template>
