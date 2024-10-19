<script setup>
import {UserCircleIcon} from '@heroicons/vue/24/outline'
defineProps({
    image:{
        type:String,
        default:null
    }
})
</script>

<template>
    <div v-if="image" class="flex items-center justify-between w-full p-5 bg-gray-100 rounded-lg border-borde border">
        <UserCircleIcon class="w-10 h-10 text-gray-400"/>
    </div>
    <div v-else class="flex items-center justify-between " >
        <img class=" rounded-xl lg:min-w-[96px] lg:min-h-[96px]  lg:max-w-[96px] lg:max-h-[96px] w-full h-full" src="/image/default.svg" alt="" >
    </div>
</template>

<style scoped>

</style>
