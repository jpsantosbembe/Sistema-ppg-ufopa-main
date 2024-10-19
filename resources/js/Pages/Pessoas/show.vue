<script setup>

import axios from "axios";
import FullLayout from "@/Layouts/full/FullLayout.vue";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import PessoaProfile from "@/Components/PessoaProfile.vue";
import {onMounted, computed, ref} from "vue";
import TccDetails from "@/Components/TccDetails.vue";
import {LayoutIcon, TemplateIcon} from "vue-tabler-icons";
import ProgramCard from "@/Components/ProgramCard.vue";
import ProjectCard from "@/Components/ProjectCard.vue";
import Filters from "@/Components/Filters.vue";
import ProducoesCard from "@/Components/ProducoesCard/index.vue";
import Pagination from "@/Components/Pagination.vue";
import FiltersPanel from "@/Components/FiltersPanel.vue";
import OrientandoCard from "@/Components/OrientandoCard.vue";

const props = defineProps({
  people: {
    type: Object,
    required:true
  },
 tiposProduction:Array,
 subtiposProductions: Array,
 qualis: Array,
 anos: Array,
})

const tab = ref(null);
const programs = ref()
const projects = ref()
const peoples = ref()
const productions = ref(null)
const filtersOriented = ref()
const filtersPrograms = ref('')
const production = ref(null);
const searchPrograms = ref('');
const searchProject = ref('');
const searchOriented = ref('');
const oriented = ref();

let filtersProduction = ref({
  search:'',
  tipo:null,
  subtipo:null,
  qualis:null,
  ano_inicial:null,
  ano_final: null,
})

const filtersOptionsVinculos=[
    {label:'Docente', value:1},
    {label:'Discente', value:2},
    {label:'Externo', value:3},
    {label:'PosDoc', value:4},
    {label:'Egresso', value: 5}
]

const filtersOptionsStatus=[
  {label:'Matriculado', value:1},
  {label:'Titulado', value:2},
  {label:'Abandonou', value:3},
  {label:'Desligado', value:4},
]

const filtersProject = ref({
  nature:[],
  status:[]
})


const filtersLabelProject = {
  nature:'Natureza',
  status:'Situação'
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
  ]
}

function reset(){
  filtersOriented.value = []
  filtersProject.value = [];
  filtersPrograms.value = [];
  searchProject.value='';
  searchOriented.value=''
  searchPrograms.value='';
}

function clearFilter(){
  filtersProject.value.nature = []
  filtersProject.value.status = []
  filtersPrograms.value = []
  filtersOriented.value = []
  getProduction()
  filtersProduction.value = []
}

function onSelect(item) {
  production.value = item;
}



async function getPrograms(url=route('api.programs')) {
  const params = new URLSearchParams()
  params.append('pessoa_id',props.people.id)
  params.append('search',searchPrograms.value)
  await axios.get(url,{params})
      .then(response=>{
        programs.value = response.data
      })
      .catch(error=>{
        console.error(error);
      })
}

async function getProjects(url=route('api.projects')) {
  const params = new URLSearchParams()
  params.append('people_id', props.people.id)
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

async function getProduction(url=route('api.production')) {
  const params = new URLSearchParams()
  params.append('people_id', props.people.id)
  params.append('filters_tipo',filtersProduction.value.tipo ?? '')
  params.append('filters_subtipo',filtersProduction.value.subtipo ?? '')

  if (filtersProduction.value.ano_inicial && filtersProduction.value.ano_final) {
      params.append('filters_ano_inicial', filtersProduction.value.ano_inicial ?? '');
      params.append('filters_ano_final', filtersProduction.value.ano_final ?? '');
  }

  params.append('filters_qualis',filtersProduction.value.qualis ?? '')
  params.append('search',filtersProduction.value.search)

  await axios.get(url,{params})
      .then(response=>{
        productions.value = response.data
      })
      .catch(error=>{
        console.error(error);
      })
}

async function getOriented(url=route('api.orienteds')) {
  const params = new URLSearchParams()
  params.append('id_orientador',props.people.id)
  params.append('filters',filtersOriented.value || "")
  params.append('search',searchOriented.value)
  await axios.get(url,{params})
      .then(response=>{
        oriented.value = response.data
      })
      .catch(error=>{
        console.error(error);
      })
}

function updateSearch(args){
  switch (tab.value){
    case "program": searchPrograms.value = args; getPrograms(); break;
    case "projects": searchProject.value = args; getProjects();break;
    case "Orientacoes": searchOriented.value = args; getOriented(); break;
  }
}

onMounted(()=>{
  getPrograms()
  getProjects()
  getProduction()
  getOriented()
})

const programFiltered = computed(()=>{
    return props.people.vinculos.filter(it => filtersPrograms.value.length > 0 ?  filtersPrograms.value.includes(it.vinculavel_type) : true)
})

const page = ref({title: 'Informações da Pessoa'});

const isDocente = computed(() => {
  return props.people.vinculos.some(vinculo => vinculo.vinculavel_type === 'Docente')
})

const producoesTecnica = computed(() => {
  return props.people.producoes.filter(it => it.tipo_producao?.nome === "TÉCNICA").length;
})

const producoesBibliograficas = computed(() => {
  return props.people.producoes.filter(it => it.tipo_producao?.nome === "BIBLIOGRÁFICA").length;
})

</script>

<template>
  <FullLayout>
    <BaseBreadcrumb :title="page.title"></BaseBreadcrumb>
    <v-row>
      <v-col cols="12" sm="12" lg="4">
        <PessoaProfile :people="people"/>
      </v-col>
      <v-col cols="12" sm="12" lg="8">
        <div class="upcomming-schedule">
          <v-tabs v-model="tab" bg-color="transparent" min-height="42" height="42">
            <v-tab value="analise" color="white" class="text-h6 mr-3" rounded="pill">Análise</v-tab>
            <v-tab value="program" color="white" class="text-h6 mr-3 " rounded="pill">Programas</v-tab>
            <v-tab value="projects" color="white" class="text-h6 mr-3" rounded="pill">Projetos</v-tab>
            <v-tab  v-if="!!people.producoes.length" value="production" color="white" class="text-h6 mr-3" rounded="pill">Produções</v-tab>
            <v-tab v-if="!!people.orientacoes_count" value="orientation" color="white" class="text-h6 mr-3" rounded="pill">Orientações</v-tab>
            <v-tab v-if="!!people.tcc" value="tcc" color="white" class="text-h6" rounded="pill">TCC</v-tab>
          </v-tabs>
          <v-window v-model="tab"  @update:modelValue="reset">
            <v-window-item value="analise">
              <div class="justify-center mt-4 px-4">
                <h5 class="text-h5 font-weight-semibold pb-3">Grade de Trabalho</h5>
                <v-row class="tw-justify-content-center mb-2">
                  <v-col cols="4" sm="4">
                    <v-card @click="tab='program'" elevation="10" class="bg-surface">
                      <v-card-item class="py-6 px-md-6 px-5">
                        <div class="d-flex align-center">
                          <v-avatar size="48" class="bg-lightsuccess">
                            <LayoutIcon size="24" stroke-width="1.5" class="text-success"/>
                          </v-avatar>
                          <div class="ml-3">
                            <h5 class="text-h4 font-weight-semibold text-grey200 mb-1">
                              {{ props.people.vinculos.length }}</h5>
                            <p class="text-subtitle-1 font-weight-medium text-grey100">Programas</p>
                          </div>
                        </div>
                      </v-card-item>
                    </v-card>
                  </v-col>
                  <v-col cols="4" sm="4">
                    <v-card @click="tab='projects'" elevation="10" class="bg-surface">
                      <v-card-item class="py-6 px-md-6 px-5">
                        <div class="d-flex align-center">
                          <v-avatar size="48" class="bg-lightprimary">
                            <BoxIcon size="24" stroke-width="1.5" class="text-primary"/>
                          </v-avatar>
                          <div class="ml-3">
                            <h5 class="text-h4 font-weight-semibold text-grey200 mb-1">
                              {{ props.people.projetos.length }}</h5>
                            <p class="text-subtitle-1 font-weight-medium text-grey100">Projetos</p>
                          </div>
                        </div>
                      </v-card-item>
                    </v-card>
                  </v-col>
                  <v-col cols="4" sm="4">
                    <v-card @click="tab='production'" elevation="10" class="bg-surface">
                      <v-card-item class="py-6 px-md-6 px-5">
                        <div class="d-flex align-center">
                          <v-avatar size="48" class="bg-lightprimary">
                            <TemplateIcon size="24" stroke-width="1.5" class="text-primary"/>
                          </v-avatar>
                          <div class="ml-3">
                            <h5 class="text-h4 font-weight-semibold text-grey200 mb-1">{{ producoesTecnica }}</h5>
                            <p class="text-subtitle-1 font-weight-medium text-grey100">Produções Técnicas</p>
                          </div>
                        </div>
                      </v-card-item>
                    </v-card>
                  </v-col>
                  <v-col v-if="isDocente" cols="4" sm="4">
                    <v-card @click="tab='production'" elevation="10" class="bg-surface">
                      <v-card-item class="py-6 px-md-6 px-5">
                        <div class="d-flex align-center">
                          <v-avatar size="48" class="bg-lightprimary">
                            <FileDescriptionIcon size="24" stroke-width="1.5" class="text-primary"/>
                          </v-avatar>
                          <div class="ml-3">
                            <h5 class="text-h4 font-weight-semibold text-grey200 mb-1">
                              {{ producoesBibliograficas }}</h5>
                            <p class="text-subtitle-1 font-weight-medium text-grey100">Produções Bibliográficas</p>
                          </div>
                        </div>
                      </v-card-item>
                    </v-card>
                  </v-col>
                  <v-col v-if="!!people.orientacoes_count" cols="4" sm="4">
                    <v-card @click="tab='orientation'" elevation="10" class="bg-surface">
                      <v-card-item class="py-6 px-md-6 px-5">
                        <div class="d-flex align-center">
                          <v-avatar size="48" class="bg-lightsuccess">
                            <UsersIcon size="24" stroke-width="1.5" class="text-success"/>
                          </v-avatar>
                          <div class="ml-3">
                            <h5 class="text-h4 font-weight-semibold text-grey200 mb-1">
                              {{ people.orientacoes_count }}</h5>
                            <p class="text-subtitle-1 font-weight-medium text-grey100">Orientados</p>
                          </div>
                        </div>
                      </v-card-item>
                    </v-card>
                  </v-col>
                  <v-col v-if="people.tcc" cols="4" sm="4">
                    <v-card @click="tab='tcc'" elevation="10" class="bg-surface">
                      <v-card-item class="py-6 px-md-6 px-5">
                        <div class="d-flex align-center">
                          <v-avatar size="48" class="bg-lightsuccess">
                            <CertificateIcon size="24" stroke-width="1.5" class="text-success"/>
                          </v-avatar>
                          <div class="ml-3">
                            <h5 class="text-h4 font-weight-semibold text-grey200 mb-1">
                              {{ props.people.tcc.length}}</h5>
                            <p class="text-subtitle-1 font-weight-medium text-grey100">TCC Avaliado</p>
                          </div>
                        </div>
                      </v-card-item>
                    </v-card>
                  </v-col>
                </v-row>
              </div>
            </v-window-item>

            <v-window-item value="program">
              <v-row class="mt-2">
                <v-col cols="12">
                  <Filters @clear-filters="clearFilter" @search="updateSearch">
                    <v-menu  :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
                      <template v-slot:activator="{ props }">
                        <div icon class="cursor-pointer" flat v-bind="props" size="small">
                          <div class="font-weight-semibold text-15 text-grey200 d-flex">Vínculos<span
                              class="mdi mdi-menu-down" style="font-size:20px"></span>
                          </div>
                        </div>
                      </template>
                      <v-sheet rounded="md" width="150" elevation="10" class="dropdown-box">
                        <v-list class="py-0 theme-list" lines="two">
                          <v-list-item color="primary" class="pa-3">
                            <v-row no-gutters>
                              <v-col v-for="option in filtersOptionsVinculos" cols="12">
                                <v-checkbox :label="option.label" density="compact"
                                            v-model="filtersPrograms"
                                            @update:modelValue="(args)=>getPrograms()"
                                            color="primary" :value="option.label" hide-details>
                                </v-checkbox>
                              </v-col>
                            </v-row>
                          </v-list-item>
                        </v-list>
                      </v-sheet>
                    </v-menu>
                  </Filters>
                  <v-row class="my-3">
                    <v-col v-for="program in programFiltered" :key="program.id" cols="12" lg="4" md="12" sm="12">
                      <ProgramCard :program="program"/>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>
            </v-window-item>

            <v-window-item value="projects">
              <v-row class="mt-2">
                <v-col cols="12">
                  <Filters
                      @clear-filters="clearFilter"
                      @search="updateSearch">
                    <div v-for="(item,key) in Object.keys(filtersOptionsProject)" class="tw-flex tw-items-center">
                      <v-menu  :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
                        <template v-slot:activator="{ props }">
                          <div icon class="cursor-pointer" flat v-bind="props" size="small">
                            <div class="font-weight-semibold text-15 text-grey200 d-flex">{{filtersLabelProject[item]}}<span
                                class="mdi mdi-menu-down" style="font-size:20px"></span>
                            </div>
                          </div>
                        </template>
                        <v-sheet rounded="md" width="150" elevation="10" class="mt-5 dropdown-box">
                          <perfect-scrollbar style="max-height: 200px">
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
                          </perfect-scrollbar>
                        </v-sheet>
                      </v-menu>
                      <v-divider v-if="key !== Object.keys(filtersOptionsProject).length-1" vertical class="mx-5"></v-divider>
                    </div>
                  </Filters>
                  <v-row class="my-3">
                    <v-col v-for="project in projects.data" cols="12" lg="6" md="12" sm="12">
                      <ProjectCard :resp="project.membros.find(it=>it.id == people.id).pivot.membro_responsavel" :project="project"/>
                    </v-col>
                  </v-row>
                    <div class="d-sm-flex tw-justify-center align-center mt-3">
                        <div>
                            <Pagination v-if="projects !== null" :links="projects?.links" @getPaginated="(args)=> getProjects(args)"/>
                        </div>
                    </div>
                </v-col>
              </v-row>
            </v-window-item>

            <v-window-item value="production">
              <v-row class="mt-2">
                <v-col cols="12">
                    <FiltersPanel @clear-filters="clearFilter" @search="args => {filtersProduction.search = args; getProduction()}"
                    :filters-production="filtersProduction">
                        <v-row class="!w-fit ">
                            <v-col  cols="2">
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
                            <v-col  cols="2">
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
                            <v-col  cols="2">
                                <v-select
                                        label="Qualis"
                                        variant="outlined"
                                        multiple
                                        hide-details
                                        clearable
                                        v-model="filtersProduction.qualis"
                                        @update:modelValue="(args)=>getProduction()"
                                        :items="qualis"
                                />
                            </v-col>
                            <v-col  cols="3">
                                <v-select
                                    label="Mais recente"
                                    variant="outlined"
                                    hide-details
                                    clearable
                                    v-model="filtersProduction.ano_final"
                                    @update:modelValue="(args)=>getProduction()"
                                    :items="anos"
                                />
                            </v-col>
                            <v-col  cols="3">
                              <v-select
                                  label="Mais antigo"
                                  variant="outlined"
                                  hide-details
                                  clearable
                                  v-model="filtersProduction.ano_inicial"
                                  @update:modelValue="(args)=>getProduction()"
                                  :items="anos.slice().sort((a, b) => a - b)"
                              />
                            </v-col>
                        </v-row>
                    </FiltersPanel>
                  <v-row class="my-3">
                    <v-col v-for="production in productions.data" cols="12" lg="6" md="12" sm="12">
                      <ProducoesCard class="tw-h-full" :producao="production" :ordem="production.autores.find(it=>it.id === people.id).pivot?.ordem ?? '--'" @onSelect="onSelect"/>
                    </v-col>
                  </v-row>
                  <div class="d-sm-flex tw-justify-center align-center mt-3">
                    <div>
                      <Pagination v-if="true" :links="productions?.links" @getPaginated="(args)=> getProduction(args)"/>
                    </div>
                  </div>
                </v-col>
              </v-row>

            </v-window-item>

            <v-window-item value="orientation">
              <v-row class="mt-2">
                <v-col cols="12">
                  <Filters @clear-filters="clearFilter" @search="updateSearch">
                    <v-menu  :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
                      <template v-slot:activator="{ props }">
                        <div icon class="cursor-pointer" flat v-bind="props" size="small">
                          <div class="font-weight-semibold text-15 text-grey200 d-flex">Situação<span
                              class="mdi mdi-menu-down" style="font-size:20px"></span>
                          </div>
                        </div>
                      </template>
                      <v-sheet rounded="md" width="150" elevation="10" class="dropdown-box">
                        <perfect-scrollbar style="max-height: 200px">
                          <v-list class="py-0 theme-list" lines="two">
                            <v-list-item color="primary" class="pa-3">
                              <v-row no-gutters>
                                <v-col v-for="option in filtersOptionsStatus" cols="12">
                                  <v-checkbox :label="option.label" density="compact"
                                              v-model="filtersOriented"
                                              @update:modelValue="(args)=>getOriented()"
                                              color="primary" :value="option.label" hide-details>
                                  </v-checkbox>
                                </v-col>
                              </v-row>
                            </v-list-item>
                          </v-list>
                        </perfect-scrollbar>
                      </v-sheet>
                    </v-menu>
                  </Filters>
                  <v-row class="my-3">
                      <v-col v-for="orientation in oriented?.data" cols="12" lg="6" md="12" sm="12">
                        <OrientandoCard :orientacao="orientation" class="tw-h-full"/>
                      </v-col>
                  </v-row>
                  <div class="d-sm-flex tw-justify-center align-center mt-3">
                    <div>
                      <Pagination v-if="oriented !== null" :links="oriented?.links" @getPaginated="(args)=> getOriented(args)"/>
                    </div>
                  </div>
                </v-col>
              </v-row>
            </v-window-item>

            <v-window-item value="tcc">
              <VCard elevation="10" class="mt-6">
                <v-card-text>
                  <div class="justify-center ">
                    <h5 class="text-h5 font-weight-semibold pb-3">{{people.tcc?.tipo.nome}}</h5>
                    <TccDetails :data="people.tcc"/>
                  </div>
                </v-card-text>
              </VCard>
            </v-window-item>
          </v-window>
        </div>
      </v-col>
    </v-row>
  </FullLayout>
</template>

<style scoped>
.v-input--density-comfortable {
    --v-input-control-height: 51px !important;
    --v-input-padding-top: 14px !important;
}
</style>
