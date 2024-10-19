<script setup>
import {ref, watch} from 'vue';

const props = defineProps({
    name: String,
    options: Array,
    searcheable:{
        type:Boolean,
        default:true
    }
})

const emit = defineEmits(['update-options','search','update:moldeValue','clear-filters'])
const search = ref('');
const selectedBonds = ref([]);

function filterReset() {
    emit('clear-filters')
    selectedBonds.value = []
    search.value = ''
    emit('update-options', selectedBonds.value)
    emit('search', search.value)
}


</script>
<template>
    <VCard elevation="10" class="mb-4  d-lg-block d-none">
        <v-card-text class="py-4 px-6">
            <div class="d-flex align-center justify-space-between">
                <div class="d-flex align-center tw-w-full">
                    <p class="text-grey100 text-subtitle-1 font-weight-medium pr-4">Filtrar Por:</p>
                    <slot/>
                    <v-divider v-if="searcheable"  vertical class="mx-5"></v-divider>
                    <v-text-field v-if="searcheable"  @update:modelValue="(args)=>emit('search',args)" v-model="search"  append-inner-icon="mdi-magnify" label="Buscar" single-line hide-details/>
                    <v-divider  vertical class="mx-5"></v-divider>
                </div>
                <div>
                    <v-btn color="primary" @click="filterReset()" size="large" rounded="pill">Limpar filtros</v-btn>
                </div>
            </div>
        </v-card-text>
    </VCard>
</template>

