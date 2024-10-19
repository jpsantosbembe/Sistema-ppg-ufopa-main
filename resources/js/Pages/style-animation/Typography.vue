<script setup lang="ts">
import { ref } from 'vue';
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import UiParentCard from "@/Components/shared/UiParentCard.vue";
import UiChildCard from "@/Components/shared/UiChildCard.vue";
import Heading from "@/Components/style-components/typography/Heading.vue";
import TextAlignment from "@/Components/style-components/typography/TextAlignment.vue";
import TextDecoration from "@/Components/style-components/typography/TextDecoration.vue";
import Opacity from "@/Components/style-components/typography/Opacity.vue";
import FullLayout from "@/Layouts/full/FullLayout.vue";


// theme breadcrumb
const page = ref({ title: 'Typography' });
const breadcrumbs = ref([
    {
        text: 'Home',
        disabled: false,
        href: '#'
    },
    {
        text: 'Typography',
        disabled: true,
        href: '#'
    }
]);

</script>

<template>
   <FullLayout>
       <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb>

       <v-row>
           <v-col cols="12" md="12">
               <UiParentCard title="Basic Typography">
                   <UiChildCard title="Heading">
                       <Heading/>
                   </UiChildCard>
                   <UiChildCard title="Default Text" class="mt-5">
                       <Default/>
                   </UiChildCard>
                   <UiChildCard title="Text-alignment" class="mt-5">
                       <TextAlignment/>
                   </UiChildCard>
                   <UiChildCard title="Decoration" class="mt-5">
                       <TextDecoration/>
                   </UiChildCard>
                   <UiChildCard title="Opacity" class="mt-5">
                       <Opacity/>
                   </UiChildCard>
               </UiParentCard>
           </v-col>
       </v-row>
   </FullLayout>
</template>
