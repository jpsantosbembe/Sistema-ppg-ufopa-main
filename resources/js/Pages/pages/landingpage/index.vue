<script setup >
import { ref, onMounted } from 'vue';
import Header from '@/Components/landingpage/layout/Header.vue';
import Revolution from '@/Components/landingpage/section/Revolution.vue';
import OurProducts from '@/Components/landingpage/section/ourProducts.vue';
import Features from '@/Components/landingpage/section/otherFeatures.vue';
import UserReview from '@/Components/landingpage/section/userReview.vue';
import Purchase from '@/Components/landingpage/section/Purchase.vue';
import Footer from '@/Components/landingpage/layout/Footer.vue';

import 'aos/dist/aos.css';
import AOS from 'aos';

onMounted(() => {
    AOS.init();
});

</script>

<template>
    <div class="lp-wraper">
        <!--Header-->
        <Header />
        <!----------->
        <!--Content-->
        <Revolution/>
        <OurProducts/>
        <Features/>
        <UserReview />
        <Purchase/>
        <!----------->
        <!--Footer-->
        <Footer />
        <!----------->
    </div>
</template>
