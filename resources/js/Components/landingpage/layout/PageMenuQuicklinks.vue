<script setup>
import {quickLink} from '#/headerData';
</script>

<template>
    <!-- ---------------------------------------------- -->
    <!-- language DD -->
    <!-- ---------------------------------------------- -->
    <div v-for="(item, i) in quickLink" :key="i" class="py-2">
        <a :href="item.href" class="text-decoration-none text-hover-primary font-weight-semibold text-subtitle-1">{{ item.title }}</a>
    </div>
</template>
