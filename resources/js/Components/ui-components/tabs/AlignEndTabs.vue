<script setup >
import { ref } from "vue";

const tab = ref(null);
const tab1 = ref(
  [
    {img:  '/assets/images/blog/blog-img1.jpg'},
    {img:  '/assets/images/blog/blog-img2.jpg'},
    {img:  '/assets/images/blog/blog-img3.jpg'},
    {img:  '/assets/images/blog/blog-img4.jpg'},
    {img:  '/assets/images/blog/blog-img5.jpg'},
    {img:  '/assets/images/blog/blog-img1.jpg'},
  ]
)
const tab2 = ref(
  [
    {img:  '/assets/images/products/s3.jpg'},
    {img:  '/assets/images/products/s4.jpg'},
    {img:  '/assets/images/products/s5.jpg'},
    {img:  '/assets/images/products/s6.jpg'},
    {img:  '/assets/images/products/s7.jpg'},
    {img:  '/assets/images/products/s8.jpg'},
  ]
)
  const tab3 = ref(
  [
    {img:  '/assets/images/products/s9.jpg'},
    {img:  '/assets/images/products/s10.jpg'},
    {img:  '/assets/images/products/s11.jpg'},
    {img:  '/assets/images/products/s7.jpg'},
    {img:  '/assets/images/products/s12.jpg'},
    {img:  '/assets/images/products/s8.jpg'},
  ]
)
</script>
<template>
    <v-card elevation="0">
      <v-tabs
        v-model="tab"
        color="primary"
        align-tabs="end"
      >
        <v-tab value="1">Landscape</v-tab>
        <v-tab value="2">Products</v-tab>
        <v-tab value="3">Abstract</v-tab>
      </v-tabs>

      <v-card-text class="rounded-md pa-0 mt-6">
        <v-window v-model="tab">
            <v-window-item value="1">
                  <v-row>
                    <v-col v-for="item in tab1" :key="item.img"  cols="12" md="4" sm="6">
                        <v-img :src="item.img" alt="tab" cover  class="w-100"  height="250"></v-img>
                    </v-col>
                  </v-row>
            </v-window-item>
            <v-window-item value="2">
                  <v-row>
                    <v-col v-for="item in tab2" :key="item.img"  cols="12" md="4" sm="6">
                      <v-img :src="item.img" alt="tab" cover  class="w-100"  height="250"></v-img>
                    </v-col>
                  </v-row>
            </v-window-item>
            <v-window-item value="3">
                  <v-row>
                    <v-col v-for="item in tab3" :key="item.img"  cols="12" md="4" sm="6">
                      <v-img :src="item.img" alt="tab" cover  class="w-100"  height="250"></v-img>
                    </v-col>
                  </v-row>
            </v-window-item>
        </v-window>
    </v-card-text>
    </v-card>
  </template>
