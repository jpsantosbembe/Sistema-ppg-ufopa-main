<script setup>
import FullLayout from "@/Layouts/full/FullLayout.vue";
import ProjectCard from "@/Components/ProjectCard.vue";
import {onMounted, ref, watch} from "vue";
import Filters from "@/Components/Filters.vue";
import axios from "axios";
import Pagination from "@/Components/Pagination.vue";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import {throttle} from "lodash";

const projects = ref(null);
const search = ref('');

const filtersLabel = {
    nature:'Natureza',
    status:'Situação',
    belong:'Membros'
}
const filters = ref({
    nature:[],
    status:[],
    belong:[1]
})

const filtersOptions = {
    nature:[
        {label:'Pesquisa',value:'pesquisa'},
        {label:'Extensão',value:'extensão'},
        {label:'Inovação',value:'inovação'},
        {label:'Outra',value:'outra'}
    ],
    status:[
        {label:'Em andamento',value:'EM ANDAMENTO'},
        {label:'Concluído',value:'CONCLUÍDO'},
        {label:'Desativado',value:'DESATIVADO'},
    ],
    belong:[
        {label:'Com membros da ufopa',value:1},
        {label:'Sem membros da ufopa',value:0},
    ]
}

async function getPaginationProject(url=route('api.projects')) {
    const params = new URLSearchParams()
    params.append('filters_nature',filters.value.nature)
    params.append('filters_status',filters.value.status)
    params.append('filters_belong',filters.value.belong)

    params.append('search',search.value)
    await axios.get(url,{params})
        .then(response=>{
            projects.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}

function clearFilter(){
    filters.value.nature = []
    filters.value.status = []
    filters.value.belong = []
}


onMounted(()=>{
    getPaginationProject()
    watch(()=>search.value,throttle(() => {
            getPaginationProject()
        },800),
        {
            deep: true,
        })
})



</script>

<template>
    <FullLayout>
        <BaseBreadcrumb :title="'Projetos'" ></BaseBreadcrumb>
        <Filters
            @clear-filters="clearFilter"
            @search="args => search = args">

            <div v-for="(item,key) in Object.keys(filtersOptions)" class="tw-flex tw-items-center">
                <v-menu  :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
                    <template v-slot:activator="{ props }">
                        <div icon class="cursor-pointer" flat v-bind="props" size="small">
                            <div class="font-weight-semibold text-15 text-grey200 d-flex">{{filtersLabel[item]}}<span
                                class="mdi mdi-menu-down" style="font-size:20px"></span></div>
                        </div>
                    </template>
                    <v-sheet rounded="md" width="150" elevation="10" class="mt-5 dropdown-box">
                        <perfect-scrollbar style="max-height: 200px">
                            <v-list class="py-0 theme-list" lines="two">
                                <v-list-item color="primary" class="pa-3">
                                    <v-row no-gutters>
                                        <v-col v-for="option in filtersOptions[item]" cols="12">
                                            <v-checkbox :label="option.label" density="compact"
                                                        v-model="filters[item]"
                                                        @update:modelValue="(args)=>getPaginationProject()"
                                                        color="primary" :value="option.value" hide-details>
                                            </v-checkbox>
                                        </v-col>
                                    </v-row>
                                </v-list-item>
                            </v-list>
                        </perfect-scrollbar>
                    </v-sheet>
                </v-menu>
                <v-divider v-if="key !== Object.keys(filtersOptions).length-1" vertical class="mx-5"></v-divider>
            </div>

        </Filters>
        <v-row class="mb-3">
            <v-col v-for="project in projects?.data" cols="12" lg="4" md="12" sm="12">
                <ProjectCard :project="project"/>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <div class="d-sm-flex tw-justify-center align-center mt-3">
            <div>
                <Pagination v-if="projects !== null" :links="projects?.links" @getPaginated="(args)=> getPaginationProject(args)"/>
            </div>
        </div>
    </FullLayout>
</template>

<style scoped lang="scss">

</style>
