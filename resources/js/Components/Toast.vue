<script setup>
import {CheckIcon, XMarkIcon} from "@heroicons/vue/24/outline/index.js";

defineProps({
    showToast:Boolean,
    clearToast:Function
})
</script>

<template>
    <div v-if="showToast" id="toast-default" class="tw-transform-all tw-duration-500 tw-flex tw-items-center tw-w-full  tw-p-4 tw-text-gray-500 tw-bg-white tw-rounded-lg tw-shadow tw-dark:text-gray-400 tw-dark:bg-gray-800 tw-mb-4" role="alert">
        <div :class="$page.props.toast.success ? 'tw-bg-green-100' : 'tw-bg-red-100'" class="tw-inline-flex tw-items-center tw-justify-center  tw-w-8 tw-h-8 tw-text-blue-500 tw-rounded-lg tw-dark:bg-blue-800 tw-dark:text-blue-200">
            <CheckIcon v-if="$page.props.toast.success" class="tw-h-6 tw-w-8"/>
            <XMarkIcon v-else class="tw-h-6 tw-w-8"/>
        </div>
        <div v-if="$page.props.toast.success" class="tw-ml-3 tw-text-sm tw-font-normal">{{$page.props.toast.success}}</div>
        <div v-else-if="Object.keys($page.props.errors).length !== 0" class="tw-ml-3 tw-text-sm tw-font-normal">{{$page.props.errors.msg}}</div>
        <div v-else class="tw-ml-3 tw-text-sm tw-font-normal">{{$page.props.toast.fail}}</div>
        <button @click="clearToast" type="button" class="tw-ml-auto tw-mx-1.5 tw--my-1.5 tw-bg-white tw-text-gray-400 tw-hover:text-gray-900 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-gray-300 tw-p-1.5 tw-hover:bg-gray-100 tw-inline-flex tw-items-center tw-justify-center tw-h-8 tw-w-8 tw-dark:text-gray-500 tw-dark:hover:text-white tw-dark:bg-gray-800 tw-dark:hover:bg-gray-700" data-dismiss-target="#toast-default" aria-label="Close">
            <span class="tw-sr-only">Close</span>
            <svg class="tw-w-3 tw-h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
</template>

<style scoped>

</style>
