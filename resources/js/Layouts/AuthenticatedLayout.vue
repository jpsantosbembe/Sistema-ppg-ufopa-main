<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import {userSystemState} from '@/Stores/index.js';
import {
    HomeIcon,
    RectangleStackIcon,
    CloudArrowUpIcon,
    Bars3Icon,
    UserGroupIcon,
} from '@heroicons/vue/24/solid'
import {
    HomeIcon as HomeIconOutline,
    RectangleStackIcon as RectangleStackIconOutline,
    CloudArrowUpIcon as CloudArrowUpIconOutline,
    UserGroupIcon as UserGroupIconOutline
} from '@heroicons/vue/24/outline'
import ApplicationLogoSmall from "@/Components/ApplicationLogoSmall.vue";

const stateSystem = userSystemState()
const showingNavigationDropdown = ref(false);


</script>

<template>
    <div>
        <div class="min-h-full h-full ">
            <!--SideBar-->
            <nav class="fixed md:left-0  h-full  md:block bg-white border-r-2 border-borde transition-all duration-500  hidden z-40"
                 :class="stateSystem.sidebar ? 'w-[var(--sidebar-open)]' : 'w-[var(--sidebar-close)]'">
                <div class="shrink-0 flex items-center border-b-2 border-borde h-20  px-10">
                    <Link :href="route('dashboard')">
                        <ApplicationLogo v-if="stateSystem.sidebar"  class="h-9 w-auto fill-current text-gray-800 dark:text-gray-200 "/>
                        <ApplicationLogoSmall v-else class="h-9 w-auto fill-current text-gray-800 dark:text-gray-200 "/>
                    </Link>
                </div>
                <div class=" flex flex-col justify-center" :class="{'px-8':stateSystem.sidebar, 'px-6':!stateSystem.sidebar}">
                    <div class="flex py-9 w-full" :class="{'justify-between pl-5': stateSystem.sidebar, 'justify-center': !stateSystem.sidebar}">
                        <Transition name="fade" >
                            <p v-show="stateSystem.sidebar" class="text-default text-lg break-keep whitespace-nowrap">Menu Principal</p>
                        </Transition>
                        <Bars3Icon @click="stateSystem.sidebar = !stateSystem.sidebar" class=" w-6 h-6"/>
                    </div>
                    <div class="w-full flex flex-col gap-2">
                        <NavLink :href="route('dashboard')"  :active="route().current('dashboard')" :class="{ 'px-5 py-3':stateSystem.sidebar}">
                            <HomeIcon v-if="route().current('dashboard')" class="w-6 h-6" :class="stateSystem.sidebar ? 'mr-5': 'ml-4'"/>
                            <HomeIconOutline v-else class="w-6 h-6" :class="stateSystem.sidebar ? 'mr-5': 'ml-4'"/>
                            <Transition name="fade" >
                                <span class="whitespace-nowrap" v-show="stateSystem.sidebar">Visão Geral</span>
                            </Transition>
                        </NavLink>
                        <NavLink :href="route('programa.index')" :active="route().current('programa.*')" :class="{ 'px-5 py-3':stateSystem.sidebar}">
                            <RectangleStackIcon v-if="route().current('programa.*')" class="w-6 h-6" :class="stateSystem.sidebar ? 'mr-5': 'ml-4'"/>
                            <RectangleStackIconOutline v-else class="w-6 h-6" :class="stateSystem.sidebar ? 'mr-5': 'ml-4'"/>
                            <Transition name="fade" >
                                <span class="whitespace-nowrap"  v-show="stateSystem.sidebar">Programas</span>
                            </Transition>
                        </NavLink>
                        <NavLink :href="route('coleta.index')" :active="route().current('coleta.*')" :class="{'px-5 py-3':stateSystem.sidebar}">
                            <CloudArrowUpIcon v-if="route().current('coleta.*')" class="w-6 h-6" :class="stateSystem.sidebar ? 'mr-5': 'ml-4'"/>
                            <CloudArrowUpIconOutline v-else class="w-6 h-6" :class="stateSystem.sidebar ? 'mr-5': 'ml-4'"/>
                            <Transition name="fade" >
                                <span class="whitespace-nowrap"  v-show="stateSystem.sidebar">Coleta</span>
                            </Transition>
                        </NavLink>
                        <NavLink :href="route('pessoas.index')" :active="route().current('pessoas.*')" :class="{'px-5 py-3':stateSystem.sidebar}">
                            <UserGroupIcon v-if="route().current('pessoas.*')" class="w-6 h-6" :class="stateSystem.sidebar ? 'mr-5': 'ml-4'"/>
                            <UserGroupIconOutline v-else class="w-6 h-6" :class="stateSystem.sidebar ? 'mr-5': 'ml-4'"/>
                            <Transition name="fade" >
                                <span class="whitespace-nowrap"  v-show="stateSystem.sidebar">Pessoas</span>
                            </Transition>
                        </NavLink>
                    </div>
                </div>
            </nav>
            <!-- TopBar-->
            <nav
                :class="stateSystem.sidebar ? 'left-[--sidebar-open] transition-all duration-500 ' : 'left-[--sidebar-close] transition-all duration-500 '"
                class="fixed w-full bg-white dark:bg-gray-800 border-b-2 h-20 border-borde dark:border-gray-700 z-40 "
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto  sm:px-6 ">
                    <div class="flex justify-between  items-center h-20">
                        <div class=" sm:flex sm:items-center sm:ms-6 ">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative ">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main
                :class="stateSystem.sidebar ? 'pl-[var(--sidebar-open)]' : 'pl-[var(--sidebar-close)]'"
                class=" relative mx-auto w-full top-24 transition-all duration-500"
            >
                <div class="px-4">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<style>
.fade-enter-active {
    transition: opacity 1s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity:0;
}
</style>
