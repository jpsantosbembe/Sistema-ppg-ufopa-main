<script setup>

import axios from "axios";
import {Icon} from "@iconify/vue";
import FullLayout from "@/Layouts/full/FullLayout.vue";
import {computed, onBeforeMount, onMounted, ref, shallowRef, watch} from "vue";
import ProjectCard from "@/Components/ProjectCard.vue";
import Proposal from "@/Components/Proposal.vue";
import ProjectsChart from "@/Components/dashboards/ProjectsChart.vue";
import Pagination from "@/Components/Pagination.vue";
import Filters from "@/Components/Filters.vue";
import PessoaCard from "@/Components/PessoaCard.vue";
import DisciplinaCard from "@/Components/DisciplinaCard/index.vue";
import DisciplineDetailsModal from "@/Components/DisciplinaCard/DisciplineDetailsModal.vue";
import QualisChart from "@/Components/dashboards/QualisChart.vue";
import ProducoesCard from "@/Components/ProducoesCard/index.vue";
import LinhaPesquisaCard from "@/Components/LinhaPesquisaCard.vue";
import FiltersPanel from "@/Components/FiltersPanel.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    programa:Object,
    tiposProduction:Array,
    subtiposProductions:Array,
    qualis:Array,
})


const tab = ref();
const tabReports = ref()
const projects = ref()
const peoples = ref()
const disciplines = ref()
const orientadores = ref([])
const filtersDiscipline = ref()
const filtersPeople = ref()
const dataReportQualis = ref([])
const dataReportOrientations = ref([])
const discipline = ref(null);
const productions = ref(null)
const searchPeople = ref('');
const searchProject = ref('');
const searchDiscipline = ref('')


const items = shallowRef([
    { tab: 'Detalhes', icon: 'info-square-outline', num_item:0},
    { tab: 'Proposta', icon: 'document-text-broken',num_item:0 },
    { tab: 'Produções', icon: 'documents-outline',num_item:props.programa.producoes_count},
    { tab: 'Pessoas', icon: 'people-nearby-broken',num_item:props.programa.pessoas_count },
    { tab: 'Disciplinas', icon: 'clipboard-broken',num_item:props.programa.disciplina_count},
    { tab: 'Projetos', icon: 'box-minimalistic-broken',num_item:props.programa.projetos_count},
    { tab: 'Linhas de Pesquisas', icon: 'rounded-magnifer-broken',num_item:props.programa.linhas.length},
    { tab: 'Relatórios', icon: 'chart-2-broken',num_item:null},
]);

const itemsReports = shallowRef([
    { tab: 'Qualis', icon: 'info-square-outline', num_item:0},
    { tab: 'Orientações', icon: 'document-text-broken',num_item:0 },
]);

const filtersProject = ref({
    nature:[],
    status:[],
    belong:[1]
})

const filtersProduction = ref({
    search:'',
    tipo:null,
    subtipo:null,
    qualis:[],
    anos:null
})

const filtersOptionsPeoples = [
    {label:'Docente',value:1},
    {label:'Discente',value:2},
    {label:'Participante Externo',value:3},
    {label:'PosDoc',value:4},
    {label:'Egresso',value:5},
]

const filtersOptionsDiscipline = [
    {label:'Obrigatória',value:1},
    {label:'Optativa',value:2},
]

const filtersLabelProject = {
    nature:'Natureza',
    status:'Situação',
    belong:'Membros'
}

const filtersOptionsProject = {
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

const filtersReportQualis = useForm({
    ppgs:props.programa.id,
    init_year:null,
    end_year:null,
})

const filtersOrientations = useForm({
    ppgs:props.programa.id,
    orientador_id:null,
    init_year:null,
    end_year:null,
})

const years = computed(() => {
    const anoInicial = 2013
    const anoAtual = new Date().getFullYear();
    let anos = [];
    for (let ano = anoInicial; ano <= anoAtual; ano++) {
        anos.push(ano);
    }
    return anos;
});

const headersLinhas = ref([
    { title: 'Nome', align: 'start', key: 'nome' },
    { title: 'Area de Concentração', align: 'start', key: 'area' },
    { title: 'Projetos', align: 'start', key: 'projetos_count' },
    { title: 'Data de Início', align: 'start', key: 'data_inicio' },
    { title: 'Data Final', align: 'start', key: 'data_fim' },
]);

function reset(){
    filtersPeople.value = []
    filtersDiscipline.value = []
    filtersProject.value = []
    searchPeople.value=''
    searchProject.value=''
    searchDiscipline.value=''
}

function clearFilter(){
    filtersProject.value.nature = []
    filtersProject.value.status = []
    filtersProject.value.belong = []
    filtersDiscipline.value = []
    filtersPeople.value = []
    getProduction()
    filtersProduction.value = []
}

function onSelect(item) {
    discipline.value = item;
}

function closeModal(){
    discipline.value = null;
}

async function getQualisReport(url=route('api.report-qualis')) {
    const params = new URLSearchParams()
    params.append('program_id',filtersReportQualis.ppgs)
    params.append('init_year',filtersReportQualis.init_year || '')
    params.append('end_year',filtersReportQualis.end_year || '')
    await axios.get(url,{params})
        .then(response=>{
            dataReportQualis.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}

async function getOrientationsReport(url=route('api.report-orientations')) {
    const params = new URLSearchParams()
    params.append('program_id',filtersOrientations.ppgs)
    params.append('year',filtersOrientations.init_year || '')
    params.append('orientador_id',filtersOrientations.orientador_id || '')
    await axios.get(url,{params})
        .then(response=>{
            dataReportOrientations.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}

async function getPeoples(url=route('api.peoples')) {
    const params = new URLSearchParams()
    params.append('program_id',props.programa.id)
    params.append('filters',filtersPeople.value || "")
    params.append('search',searchPeople.value)
    await axios.get(url,{params})
        .then(response=>{
            peoples.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}
async function getOrientadores(token) {
    const params = new URLSearchParams()
    params.append('program_id',props.programa.id)
    params.append('search',token || '')
    await axios.get(route('api.pessoas.orientadores'),{params})
        .then(response=>{
            orientadores.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}

async function getProjects(url=route('api.projects')) {
    const params = new URLSearchParams()
    params.append('program_id',props.programa.id)
    params.append('filters_nature',filtersProject.value.nature || "")
    params.append('filters_status',filtersProject.value.status || "")
    params.append('filters_belong',filtersProject.value.belong || "")
    params.append('search',searchProject.value)
    await axios.get(url,{params})
        .then(response=>{
            projects.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}

async function getDisciplines(url=route('api.disciplines')) {
    const params = new URLSearchParams()
    params.append('program_id',props.programa.id)
    params.append('filters',filtersDiscipline.value || "")
    params.append('search',searchDiscipline.value)
    await axios.get(url,{params})
        .then(response=>{
            disciplines.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}

async function getProduction(url=route('api.production')) {
    const params = new URLSearchParams()
    params.append('program_id', props.programa.id)
    params.append('filters_tipo',filtersProduction.value.tipo ?? '')
    params.append('filters_subtipo',filtersProduction.value.subtipo ?? '')
    params.append('filters_ano_publi',filtersProduction.value.anos || '')
    params.append('filters_qualis',filtersProduction.value.qualis || '')
    params.append('search',filtersProduction.value.search)

    await axios.get(url,{params})
        .then(response=>{
            productions.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}

function setFilterByGraph(item){
    filtersProduction.value.qualis = item
    getProduction()
    tab.value = 'Produções'
}


function updateSearch(args){
    switch (tab.value){
        case "Pessoas": searchPeople.value = args; getPeoples(); break;
        case "Projetos": searchProject.value = args; getProjects();break;
        case "Disciplinas": searchDiscipline.value = args; getDisciplines();break;
    }
}

onMounted(()=>{
    getProjects()
    getPeoples()
    getDisciplines()
    getProduction()
    getOrientadores()
})
</script>

<template>
    <FullLayout>
        <section>
            <div>
                <v-card elevation="10" class="overflow-hidden ">
                    <v-card-item class="pb-0 ">
                        <v-row class=" justify-space-between ">
                            <v-col cols="12" md="6" sm="9" lg="12" class="w-full">
                                <div class="d-sm-flex align-center justify-sm-start justify-center ">
                                    <div class="text-sm-left text-center">
                                        <v-avatar size="100" class="userImage position-relative overflow-visible">
                                            <Icon icon="solar:inbox-archive-outline" height="50" width="50" class="text-primary-1" />
                                        </v-avatar>
                                    </div>
                                    <div class="ml-sm-4 text-sm-left text-center ">
                                        <h5 class="text-h3 font-weight-semibold mb-1 my-sm-0 my-2">
                                            {{programa.nome}}
                                            <v-chip color="primary" class="bg-lightprimary font-weight-semibold ml-2 mt-n1" variant="outlined" size="x-small">
                                                {{programa.nivel}}
                                            </v-chip>
                                        </h5>
                                        <span class="text-h6 font-weight-medium text-grey100">{{programa.area_avaliacao}}</span>
                                    </div>
                                </div>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col md="12" class="profile-one">
                                <v-tabs v-model="tab" color="primary" dark class="profiletab">
                                    <v-tab v-for="item in items" :value="item.tab"  class="text-grey100 mr-sm-3">
                                        <Icon :icon="'solar:' + item.icon" height="24" width="24"  class="mr-sm-2 text-h6 text-grey100 icon" />
                                        <span class="d-sm-flex d-none">{{ item.tab }}  <v-chip v-if="item.num_item > 0" color="primary" variant="flat" size="x-small" class="text-white ml-4" rounded="xl">{{item.num_item}}</v-chip> </span>
                                    </v-tab>
                                </v-tabs>
                            </v-col>
                        </v-row>
                    </v-card-item>
                </v-card>
                <section class="mt-6">
                    <v-window v-model="tab" @update:modelValue="reset">
                        <v-window-item value="Detalhes" >
                            <v-row>
                                <v-col class="my-1">
                                    <v-row  class="tw-justify-content-center">
                                        <v-col cols="12" lg="3" md="2">
                                            <v-card @click="tab='Pessoas'" elevation="10" class="bg-surface">
                                                <v-card-item class="py-6 px-md-6 px-5">
                                                    <div class="d-flex align-center">
                                                        <v-avatar size="48" class="bg-lightprimary">
                                                            <Icon icon="solar:people-nearby-broken" height="25" width="25" class="text-primary"/>
                                                        </v-avatar>
                                                        <div class="ml-3">
                                                            <h5 class="text-h4 font-weight-semibold text-grey200 mb-1">{{programa.pessoas_count}}</h5>
                                                            <p class="text-subtitle-1 font-weight-medium text-grey100">Membros</p>
                                                        </div>
                                                    </div>
                                                </v-card-item>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="12" lg="3" md="2">
                                            <v-card elevation="10" class="bg-surface">
                                                <v-card-item class="py-6 px-md-6 px-5">
                                                    <div class="d-flex align-center">
                                                        <v-avatar size="48" class="bg-lightsuccess">
                                                            <Icon icon="solar:documents-outline" height="25" width="25" class="text-success"/>
                                                        </v-avatar>
                                                        <div class="ml-3">
                                                            <h5 class="text-h4 font-weight-semibold text-grey200 mb-1">{{programa.indicadores.qtde_producao_com_qualis}}</h5>
                                                            <p class="text-subtitle-1 font-weight-medium text-grey100">Produções com qualis</p>
                                                        </div>
                                                    </div>
                                                </v-card-item>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="12" lg="3" md="2">
                                            <v-card @click="tab='Projetos'" elevation="10" class="bg-surface">
                                                <v-card-item class="py-6 px-md-6 px-5">
                                                    <div class="d-flex align-center">
                                                        <v-avatar size="48" class="bg-lightsuccess">
                                                            <Icon icon="solar:box-minimalistic-broken" height="30" width="30"  class="text-success"/>
                                                        </v-avatar>
                                                        <div class="ml-3">
                                                            <h5 class="text-h4 font-weight-semibold text-grey200 mb-1">{{programa.projetos_count}}</h5>
                                                            <p class="text-subtitle-1 font-weight-medium text-grey100">Projetos</p>
                                                        </div>
                                                    </div>
                                                </v-card-item>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="12" lg="3" md="2">
                                            <v-card elevation="10" class="bg-surface">
                                                <v-card-item class="py-6 px-md-6 px-5">
                                                    <div class="d-flex align-center">
                                                        <v-avatar size="48" class="bg-lighterror">
                                                            <CoinsIcon size="30" stroke-width="1.5" class="text-error"/>
                                                        </v-avatar>
                                                        <div class="ml-3">
                                                            <h5 class="text-h4 font-weight-semibold text-grey200 mb-1">{{Math.floor(programa.indicadores.percentual_proj_financiados)}}%</h5>
                                                            <p class="text-subtitle-1 font-weight-medium text-grey100">dos Projetos tem financiadores</p>
                                                        </div>
                                                    </div>
                                                </v-card-item>
                                            </v-card>
                                        </v-col>

                                    </v-row>
                                    <v-row>
                                        <v-col>
                                            <v-card elevation="10" class="bg-surface ">
                                                <v-card-item class="tw-flex tw-w-full">
                                                    <v-row class="tw-p-5 tw-gap-4">
                                                        <div>
                                                            <div class="flex align-center ">
                                                                <div class="ml-3">
                                                                    <h5 class="text-subtitle-1 font-weight-semibold text-grey200 mb-1">Instituição de Ensino Superior</h5>
                                                                    <p class="text-subtitle-1 font-weight-medium text-grey100">{{programa.nome_ies}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </v-row>
                                                </v-card-item>
                                            </v-card>
                                        </v-col>
                                        <v-col>
                                            <v-card elevation="10" class="bg-surface ">
                                                <v-card-item>
                                                    <v-row class="tw-p-5 tw-gap-4">
                                                    <div>
                                                        <div class="d-flex align-center ">
                                                            <div class="ml-3">
                                                                <h5 class="text-subtitle-1 font-weight-semibold text-grey200 mb-1">Média de Projetos por Linha de Pesquisa: </h5>
                                                                <p class="text-subtitle-1 font-weight-medium text-grey100">{{Math.floor(programa.indicadores.media_projetos_por_pesquisa)}} projetos por linha de pesquisa</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </v-row>
                                                </v-card-item>
                                            </v-card>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12" lg="6">
                                            <v-card elevation="10" class="bg-surface ">
                                                <ProjectsChart
                                                    :title="'Projetos por ano'"
                                                    :prefix="'Projetos'"
                                                    :subtitle="'Novos projetos'"
                                                    :data="programa?.indicadores?.qtde_por_ano_projetos" />
                                            </v-card>
                                        </v-col>
                                        <v-col cols="12" lg="6">
                                            <v-card elevation="10" class="bg-surface ">
                                                <ProjectsChart
                                                    :title="'Egressos por ano'"
                                                    :subtitle="'Novos egressos'"
                                                    :prefix="'Egressos'"
                                                    :data="programa?.indicadores?.qtde_por_ano_egressos" />
                                            </v-card>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-card elevation="10" class="bg-surface ">
                                                <ProjectsChart
                                                    :title="'Pessoas por linha de pesquisa'"
                                                    :subtitle="'Novos egressos'"
                                                    :prefix="'Quantidade'"
                                                    :label="'nome'"
                                                    :data="programa?.indicadores?.qtde_pessoas_linha_pesquisa" />
                                            </v-card>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-card elevation="10" class="bg-surface ">
                                                <QualisChart
                                                    :program="programa"
                                                    :title="'Quantidade de produção por Qualis'"
                                                    :prefix="'Quantidade'"
                                                    :label="'estratos'"
                                                    @setFilter="setFilterByGraph"
                                                    :data="programa?.indicadores?.qtde_producao_por_qualis" />
                                            </v-card>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-window-item>

                        <v-window-item value="Proposta">
                            <Proposal v-if="programa?.proposta.length > 0" :proposta="programa.proposta[0]"/>
                            <v-col v-else cols="12" md="6" sm="9" lg="12" class="w-full">
                                <v-card @click="tab='Pessoas'" elevation="10" class="bg-surface">
                                    <v-card-item class="py-6 px-md-6 px-5">
                                        <div class="d-flex align-center">
                                            <v-avatar size="48" class="bg-lightprimary">
                                                <Icon icon="solar:notebook-minimalistic-broken" height="25" width="25" class="text-primary"/>
                                            </v-avatar>
                                            <div class="ml-3">
                                                <h5 class="text-h4 font-weight-semibold text-grey200 mb-1">Programa não possui propostas cadastradas!</h5>
                                            </div>
                                        </div>
                                    </v-card-item>
                                </v-card>
                            </v-col>
                        </v-window-item>

                        <v-window-item value="Produções">
                            <v-row class="mb-3">
                                <v-col cols="12">
                                    <FiltersPanel @clear-filters="clearFilter" @search="args => {filtersProduction.search = args; getProduction()}"
                                                  :filters-production="filtersProduction">
                                        <v-row class="!w-fit">
                                            <v-col  cols="3">
                                                <v-select
                                                    clearable
                                                    label="Tipo"
                                                    variant="outlined"
                                                    hide-details
                                                    item-title="nome"
                                                    item-value="id"
                                                    v-model="filtersProduction.tipo"
                                                    @update:modelValue="(args)=>getProduction()"
                                                    :items="tiposProduction"
                                                />
                                            </v-col>
                                            <v-col  cols="3">
                                                <v-select
                                                    clearable
                                                    label="SubTipo"
                                                    variant="outlined"
                                                    hide-details
                                                    item-title="nome"
                                                    item-value="id"
                                                    v-model="filtersProduction.subtipo"
                                                    @update:modelValue="(args)=>getProduction()"
                                                    :items="subtiposProductions"
                                                />
                                            </v-col>
                                            <v-col  cols="3">
                                                <v-menu  :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
                                                    <template v-slot:activator="{ props }">
                                                        <div  class="cursor-pointer tw-border tw-rounded-lg tw-h-full tw-w-full tw-flex tw-items-center tw-px-2" v-bind="props" size="small">
                                                            <div class="font-weight-semibold tw-text-[14px] text-grey200 d-flex tw-justify-between tw-w-full">
                                                                <span>Qualis <span class="px-2" v-if="filtersProduction.qualis">{{filtersProduction.qualis.join(',')}}</span>
                                                                </span><span class="mdi mdi-menu-down" style="font-size:20px"></span></div>
                                                        </div>
                                                    </template>
                                                    <v-sheet rounded="md" width="150" elevation="10" class=" dropdown-box">
                                                        <perfect-scrollbar style="max-height: 200px">
                                                            <v-list class="py-0 theme-list" lines="two">
                                                                <v-list-item color="primary" class="pa-3">
                                                                    <v-row no-gutters>
                                                                        <v-col v-for="option in qualis" cols="12">
                                                                            <v-checkbox :label="option" density="compact"
                                                                                        v-model="filtersProduction.qualis"
                                                                                        @update:modelValue="(args)=>getProduction()"
                                                                                        color="primary" :value="option" hide-details>
                                                                            </v-checkbox>
                                                                        </v-col>
                                                                    </v-row>
                                                                </v-list-item>
                                                            </v-list>
                                                        </perfect-scrollbar>
                                                    </v-sheet>
                                                </v-menu>
                                            </v-col>
                                            <v-col  cols="3">
                                                <v-menu  :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
                                                    <template v-slot:activator="{ props }">
                                                        <div  class="cursor-pointer tw-border tw-rounded-lg tw-h-full tw-w-full tw-flex tw-items-center tw-px-2" v-bind="props" size="small">
                                                            <div class="font-weight-semibold tw-text-[14px] text-grey200 d-flex tw-justify-between tw-w-full">
                                                                <span>Ano <span class="px-2" v-if="filtersProduction.anos">{{filtersProduction.anos}}</span>
                                                                </span><span class="mdi mdi-menu-down" style="font-size:20px"></span></div>
                                                        </div>
                                                    </template>
                                                    <v-sheet rounded="md" width="150" elevation="10" class=" dropdown-box">
                                                        <perfect-scrollbar style="max-height: 200px">
                                                            <v-list class="py-0 theme-list" lines="two">
                                                                <v-list-item color="primary" class="pa-3">
                                                                    <v-row no-gutters>
                                                                        <v-col v-for="option in ['2020']" cols="12">
                                                                            <v-checkbox :label="option" density="compact"
                                                                                        v-model="filtersProduction.anos"
                                                                                        @update:modelValue="(args)=>getProduction()"
                                                                                        color="primary" :value="option" hide-details>
                                                                            </v-checkbox>
                                                                        </v-col>
                                                                    </v-row>
                                                                </v-list-item>
                                                            </v-list>
                                                        </perfect-scrollbar>
                                                    </v-sheet>
                                                </v-menu>
                                            </v-col>
                                        </v-row>
                                    </FiltersPanel>
                                </v-col>
                                <v-col v-for="production in productions?.data" :key="production.id" cols="12" lg="4" md="12" sm="12">
                                    <ProducoesCard :producao="production"/>
                                </v-col>
                                <v-col cols="12" lg="12" md="12" sm="12">
                                    <div class="d-sm-flex tw-justify-center align-center mt-3">
                                        <div class="">
                                            <Pagination v-if="productions !== null" :links="productions?.links" @getPaginated="(args)=> getProduction(args)"/>
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-window-item>

                        <v-window-item value="Pessoas">
                            <v-row >
                                <v-col cols="12">
                                    <Filters   @search="updateSearch">
                                        <v-menu  :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
                                            <template v-slot:activator="{ props }">
                                                <div icon class="cursor-pointer" flat v-bind="props" size="small">
                                                    <div class="font-weight-semibold text-15 text-grey200 d-flex">Vínculos<span
                                                        class="mdi mdi-menu-down" style="font-size:20px"></span></div>
                                                </div>
                                            </template>
                                            <v-sheet rounded="md" width="150" elevation="10" class="mt-5 dropdown-box">
                                                <perfect-scrollbar style="max-height: 200px">
                                                    <v-list class="py-0 theme-list" lines="two">
                                                        <v-list-item color="primary" class="pa-3">
                                                            <v-row no-gutters>
                                                                <v-col v-for="option in filtersOptionsPeoples" cols="12">
                                                                    <v-checkbox :label="option.label" density="compact"
                                                                                v-model="filtersPeople"
                                                                                @update:modelValue="(args)=>getPeoples()"
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
                                </v-col>
                            </v-row>
                            <v-row class="mb-3">
                                <v-col v-for="people in peoples?.data" cols="12" lg="4" md="12" sm="12">
                                    <PessoaCard :people="people"/>
                                </v-col>
                            </v-row>
                            <v-divider></v-divider>
                            <div class="d-sm-flex tw-justify-center align-center mt-3">
                                <div>
                                    <Pagination v-if="peoples !== null" :links="peoples?.links" @getPaginated="(args)=> getPeoples(args)"/>
                                </div>
                            </div>
                        </v-window-item>

                        <v-window-item value="Disciplinas">
                            <v-row>
                                <v-col cols="12">
                                    <Filters   @clear-filters="clearFilter" @search="updateSearch">
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
                                                                <v-col v-for="option in filtersOptionsDiscipline" cols="12">
                                                                    <v-checkbox :label="option.label" density="compact"
                                                                                v-model="filtersDiscipline"
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
                                </v-col>
                            </v-row>
                            <v-row class="mb-3">
                                <v-col  v-for="item in disciplines?.data" cols="12" lg="4" md="6" sm="12">
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
                        </v-window-item>

                        <v-window-item value="Projetos">
                          <v-row class="mb-3">
                              <v-col cols="12">
                                  <Filters
                                      @clear-filters="clearFilter"
                                      @search="updateSearch">

                                      <div v-for="(item,key) in Object.keys(filtersOptionsProject)" class="tw-flex tw-items-center">
                                          <v-menu  :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
                                              <template v-slot:activator="{ props }">
                                                  <div icon class="cursor-pointer" flat v-bind="props" size="small">
                                                      <div class="font-weight-semibold text-15 text-grey200 d-flex">{{filtersLabelProject[item]}}<span
                                                          class="mdi mdi-menu-down" style="font-size:20px"></span></div>
                                                  </div>
                                              </template>
                                              <v-sheet rounded="md" width="150" elevation="10" class="mt-5 dropdown-box">
                                                      <v-list class="py-0 theme-list" lines="two">
                                                          <v-list-item color="primary" class="pa-3">
                                                              <v-row no-gutters>
                                                                  <v-col v-for="option in filtersOptionsProject[item]" cols="12">
                                                                      <v-checkbox :label="option.label" density="compact"
                                                                                  v-model="filtersProject[item]"
                                                                                  @update:modelValue="(args)=>getProjects()"
                                                                                  color="primary" :value="option.value" hide-details>
                                                                      </v-checkbox>
                                                                  </v-col>
                                                              </v-row>
                                                          </v-list-item>
                                                      </v-list>
                                              </v-sheet>
                                          </v-menu>
                                          <v-divider v-if="key !== Object.keys(filtersOptionsProject).length-1" vertical class="mx-5"></v-divider>
                                      </div>

                                  </Filters>
                              </v-col>
                              <v-col v-for="project in projects?.data" cols="12" lg="4" md="12" sm="12">
                                  <ProjectCard :project="project"/>
                              </v-col>
                              <v-col cols="12" lg="12" md="12" sm="12">
                                  <div class="d-sm-flex tw-justify-center align-center mt-3 ">
                                      <div class="">
                                          <Pagination v-if="projects !== null" :links="projects?.links" @getPaginated="(args)=> getProjects(args)"/>
                                      </div>
                                  </div>
                              </v-col>
                          </v-row>
                        </v-window-item>

                        <v-window-item value="Linhas de Pesquisas">
                          <v-row class="mb-3">
                            <v-col v-for="linha in programa.linhas" cols="12" lg="4" md="12" sm="12">
                              <LinhaPesquisaCard :linhaPesquisa="linha"/>
                            </v-col>
                          </v-row>
                        </v-window-item>

                        <v-window-item value="Relatórios">
                            <v-card rounded="lg" variant="flat" class="tw-mb-5 !tw-pt-3 !tw-px-3">
                                <v-tabs  v-model="tabReports" color="primary" >
                                    <v-tab v-for="item in itemsReports" :value="item.tab" class="text-grey100 mr-sm-3">
                                        <Icon :icon="'solar:' + item.icon" height="24" width="24"  class="mr-sm-2 text-h6 text-grey100 icon" />
                                        <span class="d-sm-flex d-none">{{ item.tab }}  <v-chip v-if="item.num_item > 0" color="primary" variant="flat" size="x-small" class="text-white ml-4" rounded="xl">{{item.num_item}}</v-chip> </span>
                                    </v-tab>
                                </v-tabs>
                            </v-card>
                            <v-window v-model="tabReports">
                                <v-window-item value="Qualis" >
                                    <Filters :searcheable="false">
                                        <v-row class="!w-fit">
                                            <v-col  cols="2">
                                                <v-autocomplete
                                                    clearable
                                                    label="Ano inicial"
                                                    variant="outlined"
                                                    hide-details
                                                    v-model="filtersReportQualis.init_year"
                                                    @update:modelValue="(args)=>getQualisReport()"
                                                    :items="years"
                                                />
                                            </v-col>
                                            <v-col  cols="2">
                                                <v-autocomplete
                                                    clearable
                                                    label="Ano final"
                                                    variant="outlined"
                                                    hide-details
                                                    v-model="filtersReportQualis.end_year"
                                                    @update:modelValue="(args)=>getQualisReport()"
                                                    :items="years"
                                                />
                                            </v-col>
                                        </v-row>
                                        <a :href="route('report.qualis.export',filtersReportQualis.data())" class="tw-h-full tw-flex tw-items-center">
                                            <v-btn  color="secondary" @click="()=>{}" size="large" rounded="pill">Gerar planilha</v-btn>
                                        </a>
                                    </Filters>
                                    <v-card class="border" elevation="0">
                                        <div class="border-table ">
                                            <v-table class="month-table tw-overflow-auto tw-h-[600px]" fixed-header>
                                                <thead>
                                                <tr>
                                                    <th class="text-subtitle-1 font-weight-semibold">#</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">Nome da Pessoa</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">A1</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">A2</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">A3</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">A4</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">B1</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">B2</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">B3</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">B4</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">C</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="item in dataReportQualis" :key="item.id" class="month-item">
                                                    <td>
                                                        {{item.id}}
                                                    </td>
                                                    <td>
                                                        <h6 class="text-subtitle-1 text-grey100 font-weight-medium text-no-wrap">{{ item.nome }}</h6>
                                                    </td>
                                                    <td>{{item.A1}}</td>
                                                    <td>{{item.A2}}</td>
                                                    <td>{{item.A3}}</td>
                                                    <td>{{item.A4}}</td>
                                                    <td>{{item.B1}}</td>
                                                    <td>{{item.B2}}</td>
                                                    <td>{{item.B3}}</td>
                                                    <td>{{item.B4}}</td>
                                                    <td>{{item.C}}</td>
                                                </tr>
                                                </tbody>
                                            </v-table>
                                        </div>
                                    </v-card>
                                </v-window-item>
                                <v-window-item value="Orientações" >
                                    <Filters :searcheable="false">
                                        <v-row class="!w-fit">
                                            <v-col  cols="4">
                                                <v-autocomplete
                                                    clearable
                                                    label="Orientador"
                                                    variant="outlined"
                                                    hide-details
                                                    @update:search="getOrientadores"
                                                    item-title="nome"
                                                    item-value="id"
                                                    v-model="filtersOrientations.orientador_id"
                                                    @update:modelValue="(args)=>getOrientationsReport()"
                                                    :items="orientadores"
                                                />
                                            </v-col>
                                            <v-col  cols="2">
                                                <v-autocomplete
                                                    clearable
                                                    label="Ano"
                                                    variant="outlined"
                                                    hide-details
                                                    v-model="filtersOrientations.init_year"
                                                    @update:modelValue="(args)=>getOrientationsReport()"
                                                    :items="years"
                                                />
                                            </v-col>
                                        </v-row>
                                        <a :href="route('report.qualis.export',filtersOrientations.data())" class="tw-h-full tw-flex tw-items-center">
                                            <v-btn  color="secondary" @click="()=>{}" size="large" rounded="pill">Gerar planilha</v-btn>
                                        </a>
                                    </Filters>

                                    <v-card class="border" elevation="0">
                                        <div class="border-table ">
                                            <v-table class="month-table tw-overflow-auto tw-h-[600px]" fixed-header>
                                                <thead>
                                                <tr>
                                                    <th class="text-subtitle-1 font-weight-semibold">Orientador</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">Orientado</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">Programa</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">Data de Inicio</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">Data Fim</th>
                                                    <th class="text-subtitle-1 font-weight-semibold">Ativo</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="item in dataReportOrientations" :key="item.id" class="month-item">
                                                    <td>
                                                        <h6 class="text-subtitle-1 text-grey100 font-weight-medium text-no-wrap">{{ item.orientador_nome }}</h6>
                                                    </td>
                                                    <td>{{item.discente_nome}}</td>
                                                    <td>{{item.programa_nome}}</td>
                                                    <td>{{item.data_inicio}}</td>
                                                    <td>{{item.data_fim}}</td>
                                                    <td>{{item.ativo ? 'Sim' : 'Não'}}</td>
                                                </tr>
                                                </tbody>
                                            </v-table>
                                        </div>
                                    </v-card>
                                </v-window-item>
                            </v-window>
                        </v-window-item>
                    </v-window>
                </section>
            </div>
        </section>
    </FullLayout>
</template>

<style lang="scss">

.texto-cut {
    max-height: 100px; /* Define a altura máxima */
    overflow: hidden; /* Esconde o conteúdo que ultrapassa a altura máxima */
    text-overflow: ellipsis; /* Adiciona reticências (...) quando o texto é cortado */
}

.avatar-border {
    background-image: linear-gradient(rgb(80, 178, 252), rgb(244, 76, 102));
    border-radius: 50%;
    width: 110px;
    height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;

    .userImage {
        border: 4px solid rgb(var(--v-theme-surface));
    }
}

.top-spacer {
    margin-top: -95px;
}

.profile-one {
    .profiletab .v-slide-group__content {
        justify-content: start;

        .v-btn--variant-text .v-btn__overlay {
            background: transparent;
        }
    }

    .v-tab.v-tab {
        font-size: 16px;

        &.v-slide-group-item--active {
            color: rgb(var(--v-theme-primary)) !important;

            .icon {
                color: rgb(var(--v-theme-primary)) !important;
            }
        }
    }
}

.plus {
    bottom: 0;
    right: 0;
    border: 2px solid #fff;
}

@media (max-width: 1023px) {
    .order-sm-second {
        order: 2;
    }

    .order-sml-first {
        order: 1;
    }

    .order-sm-third {
        order: 3;
    }

    .order-sm-last {
        order: 4;
    }
}</style>
