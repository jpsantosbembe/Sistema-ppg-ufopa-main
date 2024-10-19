<script setup >

import FullLayout from "@/Layouts/full/FullLayout.vue";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
import Filters from "@/Components/Filters.vue";
import {onMounted, ref, watch} from "vue";
import axios from "axios";
import {throttle} from "lodash";
import ProducoesCard from "@/Components/ProducoesCard/index.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    tipos:Array,
    subtipos:Array,
    qualis:Array
})
const productions = ref(null)
const search = ref('');
const filters = ref({
    tipo:null,
    subtipo:null,
    qualis:null,
    anos:null
})


async function getPaginationProduction(url=route('api.production')) {
    console.log(filters.value)
    const params = new URLSearchParams()
    params.append('filters_tipo',filters.value.tipo ?? '')
    params.append('filters_subtipo',filters.value.subtipo ?? '')
    params.append('filters_ano_publi',filters.value.anos ?? '')
    params.append('filters_qualis',filters.value.qualis ?? '')
    params.append('search',search.value)


    await axios.get(url,{params})
    .then(response=>{
        productions.value = response.data
    })
    .catch(error=>{
        console.error(error);
    })
}

function clearFilter(){
  getPaginationProduction()
  filters.value = []
}

onMounted(()=>{
    getPaginationProduction()
    watch(()=>search.value,throttle(() => {
            getPaginationProduction()
        },800),
        {
            deep: true,
        })
})

</script>

<template>
    <FullLayout>
        <BaseBreadcrumb title="Produções" ></BaseBreadcrumb>
        <Filters @clear-filters="clearFilter" @search="args => search = args">
            <v-row class="!w-fit">
                <v-col  cols="4">
                    <v-select
                        clearable
                        label="Tipo"
                        variant="outlined"
                        hide-details
                        item-title="nome"
                        item-value="id"
                        v-model="filters.tipo"
                        @update:modelValue="(args)=>getPaginationProduction()"
                        :items="tipos"
                    />
                </v-col>
                <v-col  cols="4">
                    <v-select
                        clearable
                        label="SubTipo"
                        variant="outlined"
                        hide-details
                        item-title="nome"
                        item-value="id"
                        v-model="filters.subtipo"
                        @update:modelValue="(args)=>getPaginationProduction()"
                        :items="subtipos"
                    />
                </v-col>
                <v-col  cols="4">
                    <v-select
                        label="Qualis"
                        variant="outlined"
                        multiple
                        hide-details
                        clearable
                        v-model="filters.qualis"
                        @update:modelValue="(args)=>getPaginationProduction()"
                        :items="qualis"
                    />
                </v-col>
            </v-row>
        </Filters>
        <v-row class="mb-3">
            <v-col v-for="production in productions?.data" cols="12" lg="4" md="12" sm="12">
               <ProducoesCard :producao="production"/>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <div class="d-sm-flex tw-justify-center align-center mt-3">
            <div>
                <Pagination v-if="productions !== null" :links="productions?.links" @getPaginated="(args)=> getPaginationProduction(args)"/>
            </div>
        </div>
    </FullLayout>
</template>



