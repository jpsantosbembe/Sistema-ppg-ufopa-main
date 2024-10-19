<script setup>
import { computed, defineProps, defineEmits, ref } from 'vue';
import { Icon } from '@iconify/vue';

const props = defineProps({
    name: String,
    options: Array,
    searchable:{
        type:Boolean,
        default:true
    },
    filtersProduction: {
      type: Object,
      default: () => ({})
    }
})

const emit = defineEmits(['update-options','search','update:modelValue','clear-filters'])
const search = ref('');
const selectedBonds = ref([]);

const selectedFiltersCount = computed(() => {
  let count = 0;
  const filters = props.filtersProduction;
  if (filters.tipo) count++;
  if (filters.subtipo) count++;
  if (filters.qualis && filters.qualis.length > 0) count++;
  if (filters.ano_inicial) count++;
  if (filters.ano_final) count++;
  return count;
});


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
                    <v-menu :close-on-content-click="false" class="notification_popup">
                        <template v-slot:activator="{ props }">
                            <v-btn icon flat v-bind="props" size="small">
                                <v-badge color="primary" :content="selectedFiltersCount" offset-x="-4" offset-y="-6">
                                    <Icon icon="solar:filter-broken" height="24" width="24" />
                                </v-badge>
                            </v-btn>
                        </template>
                        <v-sheet rounded="lg" width="900px" height="150px" elevation="10" class="mt-5 dropdown-box">
                            <div class="px-8 pb-4 pt-6">
                                <div class="d-flex align-center">
                                    <h6 class="text-h5 font-weight-semibold">Categorias</h6>
                                    <v-chip color="primary" variant="flat" size="x-small" class="text-white ml-4" rounded="xl"> {{selectedFiltersCount}} buscas selecionadas </v-chip>
                                </div>
                            </div>
                            <div class="mx-6">
                                <slot/>
                            </div>
                        </v-sheet>
                    </v-menu>
                    <v-divider v-if="searchable"  vertical class="mx-5"></v-divider>
                    <v-text-field v-if="searchable"  @update:modelValue="(args)=>emit('search',args)" v-model="search"  append-inner-icon="mdi-magnify" label="Buscar" single-line hide-details/>
                    <v-divider  vertical class="mx-5"></v-divider>
                </div>
                <div>
                    <v-btn color="primary" @click="filterReset()" size="large" rounded="pill">Limpar filtros</v-btn>
                </div>
            </div>
        </v-card-text>
    </VCard>
</template>

