<script setup>
import FullLayout from "@/Layouts/full/FullLayout.vue";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import DisciplinaCard from "@/Components/DisciplinaCard/index.vue";
import {onMounted, ref, watch} from "vue";
import axios from "axios";
import Pagination from "@/Components/Pagination.vue";
import Filters from "@/Components/Filters.vue";
import DisciplineDetailsModal from "@/Components/DisciplinaCard/DisciplineDetailsModal.vue";


const disciplines = ref(null)
const discipline = ref(null);
const search = ref('');
const filters = ref([])
const filtersOptions = [
    {label:'Obrigatória',value:1},
    {label:'Optativa',value:2},
]
async function getDisciplines(url=route('api.disciplines')) {
    const params = new URLSearchParams()
    params.append('filters',filters.value)
    params.append('search',search.value)
    await axios.get(url,{params})
        .then(response=>{
            disciplines.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}

function onSelect(item) {
    discipline.value = item;
}

function closeModal(){
    discipline.value = null;
}

function clearFilter(){
    filters.value = []
    search.value = ''
    getDisciplines()
}

onMounted(()=>{
    getDisciplines()
    watch(()=>search.value,()=>{
        getDisciplines()
    })
})

</script>

<template>
    <FullLayout>
        <BaseBreadcrumb title="Disciplinas" ></BaseBreadcrumb>
        <Filters @search="args => search = args">
            <v-menu  :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
                <template v-slot:activator="{ props }">
                    <div icon class="cursor-pointer" flat v-bind="props" size="small">
                        <div class="font-weight-semibold text-15 text-grey200 d-flex">Tipo<span
                            class="mdi mdi-menu-down" style="font-size:20px"></span></div>
                    </div>
                </template>
                <v-sheet rounded="md" width="150" elevation="10" class="mt-5 dropdown-box">
                    <perfect-scrollbar style="max-height: 200px">
                        <v-list class="py-0 theme-list" lines="two">
                            <v-list-item color="primary" class="pa-3">
                                <v-row no-gutters>
                                    <v-col v-for="option in filtersOptions" cols="12">
                                        <v-checkbox :label="option.label" density="compact"
                                                    v-model="filters"
                                                    @update:modelValue="(args)=>getDisciplines()"
                                                    color="primary" :value="option.value" hide-details>
                                        </v-checkbox>
                                    </v-col>
                                </v-row>
                            </v-list-item>
                        </v-list>
                    </perfect-scrollbar>
                </v-sheet>
            </v-menu>
        </Filters>
        <v-row class="mb-3">
            <v-col  v-for="item in disciplines?.data" cols="12" lg="4" md="12" sm="12">
                <DisciplinaCard  class="!tw-h-full" :discipline="item" @onSelect="onSelect"/>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <div class="d-sm-flex tw-justify-center align-center mt-3">
            <div>
                <Pagination v-if="disciplines !== null" :links="disciplines?.links" @getPaginated="(args)=> getDisciplines(args)"/>
            </div>
        </div>
        <DisciplineDetailsModal :discipline="discipline" @closeModal="closeModal"/>
    </FullLayout>

</template>

<style scoped lang="scss">

</style>
