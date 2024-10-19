<script setup xmlns="http://www.w3.org/1999/html">

import {dateFormat} from "../utils/DateFormat.js";
import {computed} from "vue";

const props = defineProps({
  orientacao:{
    type:Object,
    required:true,
  },
})

const colorStatus = computed(()=>{
    switch (props.orientacao.discente.situacao){
        case 'ABANDONOU': return 'error';
        case 'TITULADO': return  'success'
        case 'MATRICULADO': return  'primary'
        case 'DESLIGADO': return  'indigo'
    }
})


</script>
<template>
  <v-card :href="route('pessoas.show', orientacao.discente.id)" elevation="10" hover class="card-hover tw-h-full !tw-flex tw-flex-col">
    <div class="tw-flex tw-items-center tw-p-4 tw-h-full">
      <div class="tw-mx-4 ">
        <v-img
            cover
            class="tw-rounded-full "
            width="110"
            height="110"
            :src="orientacao.discente.vinculo.pessoa.image_path"></v-img>
      </div>
      <div class="tw-flex-1  ">
        <h6 class="text-h6 mt-3 mb-1 !tw-text-zinc-700 ">{{ orientacao.discente.vinculo.pessoa.nome}}</h6>
        <div class="flex gap-1 justify-center">
          <p class="text-subtitle-1 font-weight-semibold mb-0">
            <span class="text-subtitle-1 text-grey100">ID {{orientacao.discente.vinculo.pessoa.doc}}</span>
          </p>
        </div>
        <div class="tw-mt-2 tw-flex tw-justify-between" style="display: flex; justify-content: space-between; align-items: center;">
          <div class="text-subtitle-1 text-grey100" style="display: flex;">
            <p class="mt-1">Nível</p>
          </div>
          <span class="text-subtitle-1 font-weight-semibold mb-0">{{orientacao.discente.nivel}}</span>
        </div>
        <div class="tw-flex tw-justify-between align-center tw-w-full">
          <div class="text-subtitle-1 text-grey100" >
            <p class="mr-2 mt-1">Programa</p>
          </div>
          <span class="text-subtitle-1 font-weight-semibold tw-text-right tw-text-wrap">{{ orientacao.discente.vinculo.programa.nome }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div class="text-subtitle-1 text-grey100" style="display: flex; ">
            <p class="mr-2 mt-1">Data de início</p>
          </div>
          <span class="text-subtitle-1 font-weight-semibold ">{{dateFormat(orientacao.data_inicio)}}</span>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div class="text-subtitle-1 text-grey100" style="display: flex; ">
            <p class="mr-2 mt-1">Conclusão</p>
          </div>
          <span class="text-subtitle-1 font-weight-semibold ">{{dateFormat(orientacao.data_fim)}}</span>
        </div>
      </div>
    </div>
    <div class="tw-px-4 tw-flex gap-1 tw-justify-end tw-border-t-2 py-2 ">
        <v-chip variant="outlined" :color="colorStatus" class=" text-body-2 tw-w-fit" v-text="orientacao.discente.situacao"></v-chip>
    </div>
  </v-card>
</template>

