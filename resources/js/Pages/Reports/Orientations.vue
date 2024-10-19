<script setup >
import FullLayout from "@/Layouts/full/FullLayout.vue";
import {reactive, ref} from "vue";
import axios from "axios";
import {Link, useForm} from "@inertiajs/vue3";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import Filters from "@/Components/Filters.vue";

defineProps({
    ppgs:Object,
    people:Object,
    years:Array
})

const data = ref()

const filters = useForm({
    ppgs:null,
    orientador_id:null,
    init_year:null,
    end_year:null,
})


async function getOrientationsReport(url=route('api.report-orientations')) {
    const params = new URLSearchParams()
    params.append('program_id',filters.ppgs || '')
    params.append('year',filters.init_year || '')
    params.append('orientador_id',filters.orientador_id || '')
    await axios.get(url,{params})
        .then(response=>{
            data.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}
</script>

<template>
    <FullLayout>
        <BaseBreadcrumb title="Orientações" ></BaseBreadcrumb>
        <Filters :searcheable="false">
            <v-row class="!w-fit">
                <v-col  cols="4">
                    <v-autocomplete
                        clearable
                        label="Orientador"
                        variant="outlined"
                        hide-details
                        item-title="nome"
                        item-value="id"
                        v-model="filters.orientador_id"
                        @update:modelValue="(args)=>getOrientationsReport()"
                        :items="people"
                    />
                </v-col>
                <v-col  cols="4">
                    <v-autocomplete
                        clearable
                        label="Programas"
                        variant="outlined"
                        hide-details
                        item-title="nome"
                        item-value="id"
                        v-model="filters.ppgs"
                        @update:modelValue="(args)=>getOrientationsReport()"
                        :items="ppgs"
                    />
                </v-col>
                <v-col  cols="2">
                    <v-autocomplete
                        clearable
                        label="Ano"
                        variant="outlined"
                        hide-details
                        v-model="filters.init_year"
                        @update:modelValue="(args)=>getOrientationsReport()"
                        :items="years"
                    />
                </v-col>
            </v-row>
            <a :href="route('report.qualis.export',filters.data())" class="tw-h-full tw-flex tw-items-center">
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
                    <tr v-for="item in data" :key="item.id" class="month-item">
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

    </FullLayout>
</template>

<style scoped >
.v-input--density-comfortable {
    --v-input-control-height: 51px !important;
    --v-input-padding-top: 14px !important;
}
</style>
