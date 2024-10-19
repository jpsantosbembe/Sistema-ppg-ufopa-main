<script setup>
import FullLayout from "@/Layouts/full/FullLayout.vue";
import BaseBreadcrumb from '@/Components/shared/BaseBreadcrumb.vue';
import PessoaCard from "@/Components/PessoaCard.vue";
import { onMounted, ref, watch} from 'vue';
import axios from "axios";
import Pagination from "@/Components/Pagination.vue";
import Filters from "@/Components/Filters.vue";

const peoples = ref(null);
const search = ref('');
const filters = ref([])
const filtersOptions=[
    {label:'Docente', value:1},
    {label:'Discente', value:2},
    {label:'Externo', value:3},
    {label:'PosDoc', value:4},
    {label:'Egresso', value: 5}
]

async function getPaginationPeople(url=route('api.peoples')) {
    const params = new URLSearchParams()
    params.append('filters',filters.value)
    params.append('search',search.value)
    await axios.get(url,{params})
        .then(response=>{
            peoples.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}

function clearFilter(){
    filters.value = []
    search.value = ''
    getPaginationPeople()
}

onMounted(()=>{
    getPaginationPeople()
    watch(()=>search.value,()=>{
        getPaginationPeople()
    })
})

</script>

<template>
    <FullLayout>
        <BaseBreadcrumb :title="'Pessoas'" ></BaseBreadcrumb>
        <Filters  @clear-filters="clearFilter"  @search="args => search = args">
            <v-menu  :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
                <template v-slot:activator="{ props }">
                    <div icon class="cursor-pointer" flat v-bind="props" size="small">
                        <div class="font-weight-semibold text-15 text-grey200 d-flex">Vínculos<span
                            class="mdi mdi-menu-down" style="font-size:20px"></span></div>
                    </div>
                </template>
                <v-sheet rounded="md" width="150" elevation="10" class="dropdown-box">
                    <v-list class="py-0 theme-list" lines="two">
                        <v-list-item color="primary" class="pa-3">
                            <v-row no-gutters>
                                <v-col v-for="option in filtersOptions" cols="12">
                                    <v-checkbox :label="option.label" density="compact"
                                                v-model="filters"
                                                @update:modelValue="(args)=>getPaginationPeople()"
                                                color="primary" :value="option.value" hide-details>
                                    </v-checkbox>
                                </v-col>
                            </v-row>
                        </v-list-item>
                    </v-list>
                </v-sheet>
            </v-menu>
        </Filters>
        <v-row class="mb-3">
            <v-col v-for="people in peoples?.data" cols="12" lg="4" md="12" sm="12">
                <PessoaCard :people="people"/>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <div class="d-sm-flex tw-justify-center align-center mt-3">
            <div>
                <Pagination v-if="peoples !== null" :links="peoples?.links" @getPaginated="(args)=> getPaginationPeople(args)"/>
            </div>
        </div>
    </FullLayout>
</template>

<style scoped lang="scss">

</style>
