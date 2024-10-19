<script setup xmlns="http://www.w3.org/1999/html">

import {dateFormat} from "../utils/DateFormat.js";
import {computed} from "vue";
import {Icon} from "@iconify/vue";

const props = defineProps({
  linhaPesquisa:{
    type:Object,
    required:true,
  },
})


</script>
<template>
  <v-card elevation="10" hover class="card-hover tw-h-full !tw-flex tw-flex-col">
    <div class="tw-flex tw-items-center tw-p-4 tw-h-full ">
      <div class="tw-flex-1">
        <h6 class="text-h6 mt-3 mb-1 !tw-text-zinc-700 ">{{ linhaPesquisa.nome }}</h6>
        <div class="tw-mt-2 tw-flex tw-justify-between" style="display: flex; justify-content: space-between; align-items: center;">
          <div class="text-subtitle-1 text-grey100" style="display: flex;">
            <p class="mt-1">Área de Concentração</p>
          </div>
          <span class="text-subtitle-1 font-weight-semibold mb-0 tw-text-right">{{linhaPesquisa.area}}</span>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div class="text-subtitle-1 text-grey100" style="display: flex; ">
            <p class="mr-2 mt-1">Data de início</p>
          </div>
          <span class="text-subtitle-1 font-weight-semibold ">{{ linhaPesquisa.data_inicio }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div class="text-subtitle-1 text-grey100" style="display: flex; ">
            <p class="mr-2 mt-1">Encerramento</p>
          </div>
          <span class="text-subtitle-1 font-weight-semibold ">{{ linhaPesquisa.data_fim }}</span>
        </div>
      </div>
    </div>
    <div class="tw-px-4 tw-flex gap-1 tw-justify-between tw-border-t-2 py-2 ">
      <div class="text-subtitle-1 text-grey100" style="display: flex; ">
        <Icon icon="solar:box-minimalistic-broken" height="24" width="24" style="margin-right: 8px"/>
        <p class="mr-2 mt-1">PROJETOS</p>
      </div>
      <v-chip variant="outlined" color="primary" class=" text-body-2 tw-w-fit">{{linhaPesquisa.projetos_count}}</v-chip>
    </div>
  </v-card>
</template>

