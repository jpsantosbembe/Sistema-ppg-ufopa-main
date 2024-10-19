<script setup>
import {
    InboxIcon,
    EllipsisVerticalIcon,
} from "@heroicons/vue/24/outline/index.js";
import {computed, onMounted, ref, watch} from "vue";
import FullLayout from "@/Layouts/full/FullLayout.vue";
import {Icon} from "@iconify/vue";
import {Link, useForm, usePage} from "@inertiajs/vue3";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import axios from "axios";
import Pagination from "@/Components/Pagination.vue";
import Filters from "@/Components/Filters.vue";

const search  =ref('');
const programs = ref(null)
const filters = ref([])
const dialog = ref(false)
const user = usePage().props.auth
const form = useForm({
    codigo_ppg:null,
    nome:null,
    area_avaliacao:null,
    sigla_ies:null,
    nome_ies:null,
    nivel:null
})

const filtersOptions=[
    {label:'Doutorado', value:1},
    {label:'Mestrado', value:2},
    {label:'Mestrado Profissional', value:3},
]

//Adicionar na api.programs para que ele filtre as opcoes
async function getPaginationPrograms(url=route('api.programs')) {
    const params = new URLSearchParams()
    params.append('filters',filters.value)
    params.append('search',search.value)
    await axios.get(url,{params})
        .then(response=>{
            programs.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}

function save(){
    form.post(route('programa.store'),{
        onSuccess:()=>{
            close()
        }
    })
}

function close(){
    dialog.value = false
    form.reset()
}

function clearFilter(){
    filters.value = []
    search.value = ''
    getPaginationPrograms()
}

onMounted(()=>{
    getPaginationPrograms()
    watch(()=>search.value,()=>{
        getPaginationPrograms()
    })
})

</script>

<template>
    <FullLayout>
        <BaseBreadcrumb :title="'Programas de Pós-Graduação'">
            <v-dialog v-model="dialog" max-width="800" v-if="user.roles.includes('Administrador')">
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props" variant="outlined" color="primary" prepend-icon="$plus" @click="" size="large" rounded="pill">Novo Programa</v-btn>
                </template>
                <v-card>
                    <v-card-title
                        class="px-4 pt-6 justify-space-between d-flex align-center"
                    >
                        <span class="text-h5">Cadastrar Programa</span>
                        <v-btn
                            @click="dialog = false"
                            :ripple="false"
                            density="compact"
                            icon="mdi-close"
                        ></v-btn>
                    </v-card-title>
                    <v-card-text class="px-4 py-5">
                        <v-row>
                            <v-col cols="12">
                                <v-textField
                                    variant="outlined"
                                    hide-details="auto"
                                    :error-messages="form.errors.codigo_ppg"
                                    v-model="form.codigo_ppg"
                                    label="Código do programa"
                                ></v-textField>
                            </v-col>
                            <v-col cols="12">
                                <v-textField
                                    variant="outlined"
                                    hide-details="auto"
                                    :error-messages="form.errors.nome"
                                    v-model="form.nome"
                                    label="Nome"
                                ></v-textField>
                            </v-col>
                            <v-col cols="12">
                                <v-textField
                                    variant="outlined"
                                    hide-details="auto"
                                    :error-messages="form.errors.area_avaliacao"
                                    v-model="form.area_avaliacao"
                                    label="Área de avaliação"
                                ></v-textField>
                            </v-col>
                            <v-col cols="12">
                                <v-textField
                                    variant="outlined"
                                    hide-details="auto"
                                    :error-messages="form.errors.nome_ies"
                                    v-model="form.nome_ies"
                                    label="Nome da IES"
                                ></v-textField>
                            </v-col>

                            <v-col cols="12">
                                <v-textField
                                    variant="outlined"
                                    hide-details="auto"
                                    :error-messages="form.errors.sigla_ies"
                                    v-model="form.sigla_ies"
                                    label="Sigla da IES"
                                ></v-textField>
                            </v-col>

                            <v-col cols="12">
                                <v-select
                                    variant="outlined"
                                    hide-details="auto"
                                    :error-messages="form.errors.nivel"
                                    :items="['Mestrado','Mestrado Profissional','Doutorado']"
                                    v-model="form.nivel"
                                    label="Nivel"
                                ></v-select>
                            </v-col>
                        </v-row>
                        <div class="pa-2 d-flex justify-end gap-2 mt-3">
                            <v-spacer></v-spacer>
                            <v-btn
                                color="error"
                                class="px-3 rounded-pill"
                                @click="close"
                            >Fechar</v-btn
                            >
                            <v-btn
                                @click="save"
                                color="primary"
                                class="px-3 rounded-pill"
                                type="submit"
                            >
                                Salvar
                            </v-btn>
                        </div>
                    </v-card-text>
                </v-card>
            </v-dialog>

        </BaseBreadcrumb>
        <Filters  @clear-filters="clearFilter"  @search="args => search = args">
            <v-menu  :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
                <template v-slot:activator="{ props }">
                    <div icon class="cursor-pointer" flat v-bind="props" size="small">
                        <div class="font-weight-semibold text-15 text-grey200 d-flex">Nível<span
                                class="mdi mdi-menu-down" style="font-size:20px"></span></div>
                    </div>
                </template>
                <v-sheet rounded="md" width="150" elevation="10" class="dropdown-box">
                    <perfect-scrollbar style="max-height: 200px">
                        <v-list class="py-0 theme-list" lines="two">
                            <v-list-item color="primary" class="pa-3">
                                <v-row no-gutters>
                                    <v-col v-for="option in filtersOptions" cols="12">
                                        <v-checkbox :label="option.label" density="compact"
                                                    v-model="filters"
                                                    @update:modelValue="(args)=>getPaginationPrograms()"
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
        <v-row class="mb-3">
            <v-col cols="12" md="12">
                <v-card v-if="!programs?.data.length" elevation="10" class="tw-w-full tw-cursor-pointer">
                    <v-card-text class="tw-flex-col tw-flex tw-items-center justify-center">
                        <InboxIcon class="tw-w-32 tw-stroke-[0.5] tw-text-borde" />
                        <span class="tw-text-default">Nenhum programa encontrado</span>
                    </v-card-text>
                </v-card>
                <section class="tw-grid lg:tw-grid-cols-2 tw-gap-3">
                    <Link v-for="item in programs?.data" :href="route('programa.show',item.id)">
                        <v-card link elevation="10"  class="tw-w-full tw-cursor-pointer">
                            <v-card-text class="tw-flex tw-w-full tw-gap-4">
                                <div class="tw-flex tw-items-center tw-text-default">
                                    <div class="tw-flex tw-items-center ">
                                        <div class="tw-w-16 tw-h-16 tw-rounded-lg tw-flex tw-items-center tw-justify-center tw-bg-action-1 tw-bg-opacity-10">
                                            <Icon icon="solar:inbox-archive-outline" height="40" width="40" class="tw-text-action-1" />
                                        </div>
                                    </div>
                                </div>
                                <div class="tw-flex tw-py-1 flex-column tw-items-start tw-text-[14px] ">
                                    <p>{{item.nome.toUpperCase()}}</p>
                                    <div  class="tw-py-1 tw-text-default tw-flex tw-gap-3 tw-text-[12px] tw-w-full">
                                        <div class="tw-flex tw-items-center tw-gap-1">
                                            <Icon icon="solar:box-minimalistic-broken" height="26" width="26" />
                                            <span>{{item.projetos_count}}</span>
                                            <span>Projetos</span>
                                        </div>
                                        <div class="tw-flex tw-items-center tw-gap-1">
                                            <Icon icon="solar:users-group-two-rounded-outline" height="26" width="26" />
                                            <span>{{item.vinculo_docentes_count}}</span>
                                            <span>Docentes</span>
                                        </div>
                                        <div class="tw-flex tw-items-center tw-gap-1">
                                            <Icon icon="solar:users-group-rounded-outline" height="26" width="26" />
                                            <span>{{item.vinculo_discentes_count}}</span>

                                            <span>Discentes</span>
                                        </div>
                                        <div class="tw-flex tw-items-center tw-gap-1 ">
                                            <Icon icon="solar:notebook-minimalistic-outline" height="26" width="26" />
                                            <span>{{item.disciplina_count}}</span>
                                            <span>Disciplinas</span>
                                        </div>

                                    </div>

                                </div>
                                <div class="tw-ml-auto tw-flex tw-items-top">
                                    <v-chip color="success" class="bg-success font-weight-semibold" variant="outlined" size="x-small">
                                        {{ item.nivel }}
                                    </v-chip>
                                </div>
                            </v-card-text>
                        </v-card>
                    </Link>
                </section>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <div class="d-sm-flex tw-justify-center align-center mt-3">
            <div>
                <Pagination v-if="programs" :links="programs?.links" @getPaginated="(args)=> getPaginationPrograms(args)"/>
            </div>
        </div>
    </FullLayout>
</template>

