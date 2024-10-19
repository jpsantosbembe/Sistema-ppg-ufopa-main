<script setup>
import { Link } from '@inertiajs/vue3';

</script>
<template>
    <div class="logo ">
        <Link :href="route('home')">
            <img src="/assets/images/logos/app-logo-dark.svg" alt="home" />
        </Link>
    </div>
</template>

