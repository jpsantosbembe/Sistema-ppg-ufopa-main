<script setup>
import {computed} from "vue";
import {dateFormat} from "../utils/DateFormat.js";

const props = defineProps({
    project:Object,
    resp:{
      type:Boolean,
      default:false
    }
})

const members = computed(()=>{
    console.log(props.project.membros)
    return props.project.membros.slice(0,Math.min(3, props.project.membros.length))
})

const colorStatus = computed(()=>{
    switch (props.project.situacao){
        case 'EM ANDAMENTO': return 'primary'
        case 'CONCLUÍDO': return  'success'
        case 'DESATIVADO': return  'error'
    }
})

const colorType = computed(()=>{
    switch (props.project.natureza_projeto){
        case 'OUTRA': return 'warning';
        case 'PESQUISA': return  'success'
        case 'EXTENSÃO': return  'info'
        case 'INOVAÇÃO': return  'indigo'
    }
})

</script>

<template>
    <v-card :href="route('projeto.show',project.id)" elevation="10" hover class="card-hover tw-h-full"  >
        <div class="tw-flex tw-flex-col gap-2 tw-h-full">
      <div class="tw-p-4 tw-flex tw-flex-col gap-3 tw-h-full">
        <div class="tw-flex tw-item-center tw-justify-between">
             <div class="tw-flex tw-items-center">
                 <v-chip variant="outlined" :color="colorType" class="text-body-2 tw-w-fit" v-text="project.natureza_projeto"></v-chip>
             </div>
            <div class="tw-flex tw-items-center tw-gap-3">
                <v-chip  v-if="resp" variant="outlined" color="primary" class=" text-body-2 tw-w-fit" v-text="'Responsavel'"></v-chip>
                <v-chip v-if="!project.tem_membro_cad" variant="outlined" color="warning" class=" text-body-2 tw-w-fit " v-text="'SEM MEMBROS DA UFOPA'"></v-chip>
            </div>
        </div>
        <div class="tw-flex  tw-flex-col gap-1  tw-h-full">
          <h4 class="tw-font-[500] h4 tw-line-clamp-2">{{project.nome}}</h4>
          <div class="pt-2 align-items-center tw-text-gray-500" style="display: flex; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
              <p >Data de início</p>
            </div>
            <span class="font-weight-semibold mb-0">{{dateFormat(project.data_inicio) ?? '--'}}</span>
          </div>
          <div class="align-items-center tw-text-gray-500" style="display: flex; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
              <p >Encerramento</p>
            </div>
            <span class="font-weight-semibold mb-0">{{dateFormat(project.data_fim) ?? '--'}}</span>
          </div>
        </div>
      </div>
      <div class="tw-px-4 tw-flex gap-2 tw-justify-between tw-border-t-2 py-2 tw-items-center ">
        <div class="d-flex align-items-center">
          <v-avatar v-for="(item) in members" :key="item.nome" size="40" class="bg-white tw-border-[3px]" :class="item.incompleto ? '!tw-border-red-400' : '!tw-border-green-400' ">
              <v-tooltip
                  activator="parent"
                  location="top"
              >{{item.incompleto ?'Pessoa com cadastro incompleto' :'Pessoa com cadastro completo'}}</v-tooltip>
            <img :src="item.image_path" alt="profile" height="40" width="40" class="">
          </v-avatar>
          <v-avatar v-if="project.membros.length > 3" size="40" class="  bg-lightprimary text-subtitle-1 font-weight-semibold text-primary">
            <div height="40" width="40">+{{project.membros.length - 3}}</div>
          </v-avatar>
        </div>
        <v-chip :color="colorStatus" class="text-body-2">{{project.situacao}}</v-chip>
      </div>
    </div>
    </v-card>
</template>
<style>
.avatar-border{
    border: 2px solid rgb(var(--v-theme-surface));
}
</style>
