<script setup >
import {onMounted, ref, shallowRef} from 'vue';
import { useCustomizerStore } from '@/Stores/customizer';
import sidebarItems from './sidebarItem';
import NavGroup from './NavGroup/index.vue';
import NavItem from './NavItem/index.vue';
import NavCollapse from './NavCollapse/NavCollapse.vue';
import ExtraBox from './extrabox/ExtraBox.vue';
import Logo from '../logo/Logo.vue';
import {usePage} from "@inertiajs/vue3";

const customizer = useCustomizerStore();
const user = usePage().props.auth
const sidebarMenu = shallowRef(sidebarItems.filter(it=>{
    if(user.roles.includes("Gestor")){
        return (it.title !== 'Usuários' && it.title !== 'Uploads')
    }
    return  true
}));

function updateScrollState(e) {
    customizer.SET_SCROLL_SIDEBAR(e.srcElement.scrollTop)
}

onMounted(()=>{
    document.getElementById('scrollElement').scrollTop = customizer.sidebarScroll
})

</script>

<template>
        <v-navigation-drawer  left v-model="customizer.Sidebar_drawer" rail-width="70" mobile-breakpoint="960" app
            class="leftSidebar ml-sm-5 mt-sm-5 bg-containerBg" elevation="10" :rail="customizer.mini_sidebar"
            expand-on-hover width="270">
            <div class="pa-5 pl-4 ">
                <Logo />
            </div>
            <!-- ---------------------------------------------- -->
            <!---Navigation -->
            <!-- ---------------------------------------------- -->
            <perfect-scrollbar id="scrollElement"  @scroll="updateScrollState" class="scrollnavbar bg-containerBg overflow-y-hidden">
                <v-list  :opened="[route().current().split('.')[0]]" class="py-4 px-4 bg-containerBg">
                    <!---Menu Loop -->
                    <template v-for="(item, i) in sidebarMenu">
                        <!---Item Sub Header -->
                        <NavGroup :item="item" v-if="item.header" :key="item.title" />
                        <!---If Has Child -->
                        <NavCollapse class="leftPadding" :item="item" :level="0" v-else-if="item.children" />
                        <!---Single Item-->
                        <NavItem :item="item" v-else class="leftPadding" />
                    </template>
                    <!-- <Moreoption/> -->
                </v-list>
                <div class="pa-6 px-4 userbottom bg-containerBg mt-10">
                    <ExtraBox />
                </div>
            </perfect-scrollbar>
        </v-navigation-drawer>
</template>
