<script setup>
import {ChevronDownIcon,ChevronUpIcon, TableCellsIcon} from "@heroicons/vue/24/outline/index.js";
import {ref} from "vue";
defineProps({
    upload:Object
})

const show = ref(false)
</script>

<template>
    <div  class="tw-border-borde tw-border-2 tw-rounded-lg tw-py-2 tw-px-4 tw-select-none" @click="show = !show">
        <div class="tw-flex tw-justify-between tw-items-center tw-pr-2">
            <div class="tw-flex tw-items-center tw-gap-2 tw-text-default">
                <TableCellsIcon class="tw-w-10 tw-h-10 "/>
                <span>{{upload.original_file_name}}</span>
                <span>{{upload.ano}}</span>
            </div>
            <div >
                <ChevronUpIcon  v-if="show" class="tw-w-6 tw-h-6"/>
                <ChevronDownIcon v-else class="tw-w-6 tw-h-6"/>
            </div>
        </div>
        <div v-show="show" class=" tw-w-full tw-border-borde tw-border-2 tw-rounded-lg tw-text-default tw-mt-2">
            <div v-for="item in upload.result.split(/\r?\n/)" class="tw-px-2 tw-py-1">
                {{item}}
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
