<script setup >
import FullLayout from "@/Layouts/full/FullLayout.vue";
import {reactive, ref} from "vue";
import axios from "axios";
import {Link, useForm} from "@inertiajs/vue3";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import Filters from "@/Components/Filters.vue";

defineProps({
    ppgs:Object,
    years:Array
})

const data = ref()

const filters = useForm({
    ppgs:null,
    init_year:null,
    end_year:null,
})


async function getQualisReport(url=route('api.report-qualis')) {
    const params = new URLSearchParams()
    params.append('program_id',filters.ppgs || '')
    params.append('init_year',filters.init_year || '')
    params.append('end_year',filters.end_year || '')
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
        <BaseBreadcrumb title="Qualis" ></BaseBreadcrumb>
        <Filters :searcheable="false">
            <v-row class="!w-fit">
                <v-col  cols="4">
                    <v-autocomplete
                        clearable
                        label="Programas"
                        variant="outlined"
                        hide-details
                        item-title="nome"
                        item-value="id"
                        v-model="filters.ppgs"
                        @update:modelValue="(args)=>getQualisReport()"
                        :items="ppgs"
                    />
                </v-col>
                <v-col  cols="2">
                    <v-autocomplete
                        clearable
                        label="Ano inicial"
                        variant="outlined"
                        hide-details
                        v-model="filters.init_year"
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
                        v-model="filters.end_year"
                        @update:modelValue="(args)=>getQualisReport()"
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
                    <tr v-for="item in data" :key="item.id" class="month-item">
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

    </FullLayout>
</template>

<style scoped >
.v-input--density-comfortable {
    --v-input-control-height: 51px !important;
    --v-input-padding-top: 14px !important;
}
</style>
