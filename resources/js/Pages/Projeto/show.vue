<script setup>

import FullLayout from "@/Layouts/full/FullLayout.vue";
import {computed, onMounted, ref, shallowRef} from "vue";
import {Icon} from "@iconify/vue";
import PessoaCard from "@/Components/PessoaCard.vue";
import FinanciadorCard from "@/Pages/Projeto/FinanciadorCard.vue";
import axios from "axios";
import Filters from "@/Components/Filters.vue";
import Pagination from "@/Components/Pagination.vue";
import DetalhesSection from "@/Pages/Projeto/DetalhesSection.vue";

const props = defineProps({
    projeto:Object
})

const tab = ref();
const peoples = ref();
const search = ref('');
const filters = ref([])
const filtersOptions=[
  {label:'Docente', value:1},
  {label:'Discente', value:2},
  {label:'Externo', value:3},
  {label:'PosDoc', value:4},
  {label:'Egresso', value: 5}
]

function reset(){
  filters.value = []
  search.value=''
}

function clearFilter(){
  filters.value = []
}

async function getPeoples(url=route('api.peoples')) {
      const params = new URLSearchParams()
      params.append('project_id', props.projeto.id)
      params.append('filters',filters.value || "")
      params.append('search',search.value)
    params.append('person_empty',1)
  await axios.get(url,{params})
      .then(response=>{
        peoples.value = response.data
      })
      .catch(error=>{
        console.error(error);
      })
}
function is_main(item){
    return item.responsavel === 'Sim'
}


// const peopleFiltered = computed(()=>{
//     const temp = props.projeto.membros
//     const idx = temp.findIndex(it=>it.responsavel === 'Sim')
//     const person = temp.find(it=>it.responsavel === 'Sim')
//     temp.splice(idx,1)
//     return props.projeto.membros
//     return [person,...temp]
// })

function updateSearch(args){
  switch (tab.value){
    case "Membros": search.value = args; getPeoples(); break;
  }
}

onMounted(()=>{
  getPeoples()
})

const items = shallowRef([
  { tab: 'Detalhes', icon: 'info-square-outline', num_item:0},
  { tab: 'Membros', icon: 'people-nearby-broken',num_item:props.projeto.membros.length},
]);

</script>
<template>
    <FullLayout>
        <div>
          <v-card elevation="10" class="overflow-hidden ">
            <v-card-item class="pb-0 ">
              <v-row class=" justify-space-between ">
                <v-col cols="12"  class="w-full">
                  <div class="d-sm-flex align-center justify-sm-start justify-center ">
                    <div class="text-sm-left text-center">
                      <v-avatar size="100" class="userImage position-relative overflow-visible">
                        <Icon icon="solar:box-minimalistic-broken" height="60" width="60" class="text-primary-1" />
                      </v-avatar>
                    </div>
                    <div class="ml-sm-4 text-sm-left text-center ">
                      <h5 class="text-h3 font-weight-semibold mb-1 my-sm-0 my-2">
                        {{projeto.nome}}
                        <v-chip color="primary" class="bg-lightprimary font-weight-semibold ml-2 mt-n1" variant="outlined" size="x-small">
                          {{projeto.natureza_projeto}}
                        </v-chip>
                      </h5>
                      <span class="tw-text-sm font-weight-medium tw-mt-2 text-grey100">{{ projeto.linha_pesquisa[0]?.nome ?? 'Nenhuma' }} </span>
                      <div class="text-subtitle-1 font-weight-bold text-grey200 d-flex align-center mt-3 justify-sm-start justify-center">
                        <div class="bg-success pa-1 rounded-circle mr-2"></div>
                        {{ projeto.situacao }}
                      </div>
                    </div>
                  </div>
                </v-col>
              </v-row>
              <v-row>
                <v-col md="12" class="profile-one">
                  <v-tabs v-model="tab" color="primary" dark class="profiletab">
                    <v-tab v-for="item in items" :value="item.tab"  class="text-grey100 mr-sm-3">
                      <Icon :icon="'solar:' + item.icon" height="24" width="24"  class="mr-sm-2 text-h6 text-grey100 icon" />
                      <span class="d-sm-flex d-none">{{ item.tab }}
                        <v-chip v-if="item.num_item > 0" color="primary" variant="flat" size="x-small" class="text-white ml-4" rounded="xl">{{item.num_item}}</v-chip>
                      </span>
                    </v-tab>
                  </v-tabs>
                </v-col>
              </v-row>
            </v-card-item>
          </v-card>
        </div>
        <section>
          <v-window v-model="tab" @update:modelValue="reset">
            <v-window-item value="Detalhes">
              <DetalhesSection :projeto="projeto" />
            </v-window-item>

            <v-window-item value="Membros">
              <v-row>
                <v-col cols="12">
                  <Filters class="mt-8" @clear-filters="clearFilter" @search="updateSearch">
                    <v-menu  :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
                      <template v-slot:activator="{ props }">
                        <div icon class="cursor-pointer" flat v-bind="props" size="small">
                          <div class="font-weight-semibold text-15 text-grey200 d-flex">Vínculos<span
                              class="mdi mdi-menu-down" style="font-size:20px"></span></div>
                        </div>
                      </template>
                      <v-sheet rounded="md" width="150" elevation="10" class="mt-5 dropdown-box">
                          <v-list class="py-0 theme-list" lines="two">
                              <v-list-item color="primary" class="pa-3">
                                  <v-row no-gutters>
                                      <v-col v-for="option in filtersOptions" cols="12">
                                          <v-checkbox :label="option.label" density="compact"
                                                      v-model="filters"
                                                      @update:modelValue="(args)=>getPeoples()"
                                                      color="primary" :value="option.value" hide-details>
                                          </v-checkbox>
                                      </v-col>
                                  </v-row>
                              </v-list-item>
                          </v-list>
                      </v-sheet>
                    </v-menu>
                  </Filters>
                  <v-row class="mb-3 mt-2">

                    <v-col v-for="membro in peoples?.data" :key="membro.id" cols="12" lg="4" md="12" sm="12">
                      <PessoaCard :people="membro" :resp="membro?.projetos[0].pivot?.membro_responsavel" :vinculoMembroProjeto="membro?.projetos[0].pivot?.categoria" />
                    </v-col>
                  </v-row>
                  <div class="d-sm-flex tw-justify-center align-center mt-3">
                    <div>
                      <Pagination v-if="peoples !== null" :links="peoples?.links" @getPaginated="(args)=> getPeoples(args)"/>
                    </div>
                  </div>
                </v-col>
              </v-row>
            </v-window-item>
          </v-window>

        </section>
    </FullLayout>
</template>

<style scoped lang="scss">


</style>
