<script setup >
import { ref, watch, computed,onBeforeMount  } from 'vue';
import { useCustomizerStore } from '@/Stores/customizer';
import { ShoppingCartIcon, AlignLeftIcon, DotsIcon } from 'vue-tabler-icons';
import LanguageDD from './LanguageDD.vue';
import NotificationDD from './NotificationDD.vue';
import ProfileDD from './ProfileDD.vue';
import Searchbar from './Searchbar.vue';
import RightMobileSidebar from './RightMobileSidebar.vue';
import Logo from '../logo/Logo.vue';
import { Icon } from '@iconify/vue';
import {usePage} from "@inertiajs/vue3";


const user = usePage().props.auth.user

const customizer = useCustomizerStore();
const showSearch = ref(false);
const appsdrawer = ref(false);
const priority = ref(customizer.setHorizontalLayout ? 0 : 0);
function searchbox() {
    showSearch.value = !showSearch.value;
}
watch(priority, (newPriority) => {
    priority.value = newPriority;
});

// count items
// const store = useEcomStore();
const getCart = computed(() => {
    return null;
});

//For on Scroll Effect on Header
onBeforeMount(() => {
  window.addEventListener('scroll', handleScroll)
})
const stickyHeader = ref(false)
function handleScroll() {
  if (window.pageYOffset) {
    stickyHeader.value = true
  } else {
    stickyHeader.value = false
  }
}

const isNotCoordinator = computed(()=>{
    return user.roles[0].name !== 'Coordenador'
})


</script>

<template>
    <div class="container">
        <div class="maxWidth">
            <v-app-bar elevation="0" :priority="priority"  height="75"  id="top" :class="stickyHeader ? 'sticky' : ''">
                <v-btn  v-if="isNotCoordinator" class="hidden-md-and-down" icon variant="text" size="small"
                    @click.stop="customizer.SET_MINI_SIDEBAR(!customizer.mini_sidebar)">
                    <Icon icon="solar:list-bold-duotone" height="24" width="24" />
                </v-btn>
                <v-btn v-if="isNotCoordinator" class="hidden-lg-and-up" icon variant="text"
                    @click.stop="customizer.SET_SIDEBAR_DRAWER" size="small">
                    <Icon icon="solar:list-bold-duotone" height="24" width="24" />
                </v-btn>

                <!-- ---------------------------------------------- -->
                <!-- Search part --> <!-- ---------------------------------------------- -->

                <div v-if="!isNotCoordinator" class="hidden-md-and-down">
                    <Logo />
                </div>

                <!---/Search part -->
                <v-spacer class="hidden-sm-and-down" />

                <div class="hidden-md-and-up">
                    <Logo />
                </div>

                <!-- ---------------------------------------------- -->
                <!---right part -->
                <!-- ---------------------------------------------- -->
                <!-- ---------------------------------------------- -->
                <!-- translate -->
                <!-- ---------------------------------------------- -->
<!--                <div class="hidden-sm-and-down mr-sm-6 mr-4">-->
<!--                    <Searchbar />-->
<!--                </div>-->
<!--                <div class="hidden-sm-and-down mr-sm-6 mr-4">-->
<!--                    <LanguageDD />-->
<!--                </div>-->

                <!-- ---------------------------------------------- -->
                <!-- ShoppingCart -->
                <!-- ---------------------------------------------- -->
<!--                <div class="hidden-sm-and-down mr-sm-6 mr-4">-->
<!--                    <v-btn icon variant="text" to="/ecommerce/checkout" size="small">-->
<!--                        <v-badge color="primary" :content="getCart?.length" offset-x="-4" offset-y="-6">-->
<!--                            <Icon icon="solar:cart-3-line-duotone" height="24" width="24" />-->
<!--                        </v-badge>-->
<!--                    </v-btn>-->
<!--                </div>-->
                <!-- ---------------------------------------------- -->
                <!-- Notification -->
                <!-- ---------------------------------------------- -->
                <div class="hidden-sm-and-down mr-sm-6 mr-4">
                    <NotificationDD />
                </div>
                <!-- ---------------------------------------------- -->
                <!-- User Profile -->
                <!-- ---------------------------------------------- -->
                <div class="hidden-sm-and-down">
                    <ProfileDD />
                </div>

                <!-----Mobile header------>
                <v-menu :close-on-content-click="false" class="mobile_popup ">
                    <template v-slot:activator="{ props }">
                        <v-btn icon class="hidden-md-and-up" flat v-bind="props" size="small">
                            <DotsIcon stroke-width="2" size="24" class="text-primary" />
                        </v-btn>
                    </template>
                    <v-sheet rounded="lg" elevation="10" class="mt-5 dropdown-box px-4 py-6">
                        <div class="d-flex justify-space-between align-center">
                            <div class="mr-sm-3 mr-2">
                                <Searchbar />
                            </div>
                            <LanguageDD />
                            <v-btn icon variant="text" class="mr-sm-3 mr-2" to="/ecommerce/checkout"
                                size="small">
                                <v-badge color="primary" :content="getCart?.length" offset-x="-4" offset-y="-6">
                                    <Icon icon="solar:cart-3-line-duotone" height="24" width="24" />
                                </v-badge>
                            </v-btn>
                            <!-- <MessagesDD /> -->
                            <NotificationDD />
                            <ProfileDD />
                        </div>
                    </v-sheet>
                </v-menu>
            </v-app-bar>
        </div>
    </div>
</template>
