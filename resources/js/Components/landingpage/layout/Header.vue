<script setup >
import { ref, watch } from 'vue';
import { useCustomizerStore } from '@/Stores/customizer';
import Logo from '@/Layouts/full/logo/Logo.vue';
// import RtlLogo from '@/layouts/full/logo/RtlLogo.vue';
import Navigations from '@/Components/landingpage/layout/Navigation.vue';
/*Mobile Sidebar*/
import MobileSidebar from '@/Components/landingpage/layout/MobileSidebar.vue';
/*import tabler icons*/
import { Menu2Icon } from 'vue-tabler-icons';
const appsdrawer = ref(false);
const customizer = useCustomizerStore();
</script>
<template>
    <div>
    <div>
        <!-- -----------------------------------------------
                            Start Header
                            ----------------------------------------------- -->
        <v-layout>
            <v-app-bar height="80" class="lp-header" flat>
                <v-container class="maxWidth py-sm-4 py-0">
                    <v-toolbar class="d-flex align-center bg-surface">
                        <div>
                            <Logo />
                        </div>
                        <!-- Desktop view Navigation -->
                        <div class="navigation d-lg-flex d-none">
                            <Navigations />
                        </div>
                        <!-- Login  -->
                        <v-btn class="custom-hover-primary bg-primary d-lg-flex d-none rounded-pill px-8 align-center login-shadow"
                               :href="route('login')" ><span class="text-white">Login</span></v-btn>
                        <!-- Mobile Toggle Button -->
                        <v-btn variant="text" class="hidden-lg-and-up " icon @click.stop="appsdrawer = !appsdrawer">
                            <Menu2Icon size="22" stroke-width="1.5" />
                        </v-btn>
                    </v-toolbar>
                </v-container>
            </v-app-bar>
        </v-layout>

            <!-- -----------------------------------------------
                            End Header
                            ----------------------------------------------- -->
        </div>

        <!----sidebar menu drawer start----->
        <v-layout>
            <v-navigation-drawer class="lp-drawer" v-model="appsdrawer" location="left" temporary>
                <MobileSidebar />
            </v-navigation-drawer>
        </v-layout>

    </div>
</template>
