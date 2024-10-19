<script setup>

import {computed, ref} from 'vue';

const props =defineProps({
  links:{
    type: Array,
    required: true
  }
});

const emit = defineEmits(['getPaginated']);

async function getPagination(url){
  try {
    emit('getPaginated', url);
  }catch(error){
    console.error('Pagination Error:', error);
  }
}

const isFirstPage = computed(() => {
  return !props.links[0] || !props.links[0].url;
});


</script>

<template>
    <div class="tw-flex tw-items-center tw-gap-4 tw-justify-evenly  tw-rounded-lg tw-py-2 tw-px-4">
        <button v-if="!isFirstPage"
            @click="getPagination(links[0].url)"
            :disabled="!links[0].url "
            class="tw-flex tw-items-center tw-gap-2 tw-px-6 tw-py-3 tw-font-sans tw-text-xs tw-font-bold tw-text-center tw-text-gray-900 tw-uppercase tw-align-middle tw-transition-all tw-rounded-lg tw-select-none hover:tw-bg-primary-1/40 hover:tw-text-white tw-disabled:pointer-events-none tw-disabled:opacity-50 tw-disabled:shadow-none"
            type="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                 aria-hidden="true" class="tw-w-4 tw-h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
            </svg>
            Anterior
        </button>
        <div class="lg:tw-flex tw-items-center tw-gap-2 tw-hidden">
            <div v-for="(link, index) in links " :key="index">
                <button v-if="index !== 0 && index !== links.length-1"
                    @click="getPagination(link.url)"
                        :class="link.active ? 'bg-primary tw-text-white hover:tw-shadow-lg tw-hover:shadow-gray-900/20' : ' tw-bg-primary-1/10 hover:tw-bg-primary-1/40 hover:tw-text-white' "
                        class=" tw-shadow-blue-500 tw-shadow-2xl  tw-relative tw-h-10 tw-max-h-[30px] tw-w-10 tw-max-w-[30px] tw-select-none tw-rounded-lg tw-text-center tw-align-middle tw-font-sans tw-text-xs tw-font-medium tw-uppercase  tw-transition-all   tw-disabled:pointer-events-none tw-disabled:opacity-50 tw-disabled:shadow-none"
                        type="button">
                          <span class="tw-absolute tw-transform tw--translate-x-1/2 tw--translate-y-1/2 tw-top-1/2 tw-left-1/2">
                            {{link.label}}
                          </span>
                </button>
            </div>
        </div>
        <button v-if="props.links[props.links.length - 1].url"
            @click="getPagination(links[links.length-1].url)"
            :disabled="!links[links.length-1].url "
            class="tw-flex tw-items-center tw-gap-2 tw-px-6 tw-py-3 tw-font-sans tw-text-xs tw-font-bold tw-text-center tw-text-gray-900 tw-uppercase tw-align-middle tw-transition-all tw-rounded-lg tw-select-none hover:tw-bg-primary-1/40 hover:tw-text-white tw-disabled:pointer-events-none tw-disabled:opacity-50 tw-disabled:shadow-none"
            type="button">
            Próximo
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                 aria-hidden="true" class="tw-w-4 tw-h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
            </svg>
        </button>
    </div>
</template>

<style scoped>

</style>
