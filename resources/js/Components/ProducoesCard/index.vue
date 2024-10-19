<script setup>
import {computed, ref} from "vue";
import ProducoesCardModal from "@/Components/ProducoesCard/ProducoesCardModal.vue";

const props = defineProps({
  producao: {
    type: Object,
    required: true,
  },
  ordem:{
    default: null,
  },
});

const emit = defineEmits(['onSelect']);
const showModal = ref(false)

const colorType = computed(()=>{
  switch ( props.producao.tipo_producao.nome ){
    case 'BIBLIOGRÁFICA': return 'primary';
    case 'TÉCNICA': return  'success';
    case 'ARTÍSTICO-CULTURAL': return  'indigo';
  }
})

</script>

<template>
    <v-card @click="showModal=true" link elevation="10" class="card-hover !tw-h-full"  >
        <div class="tw-flex tw-flex-col gap-2 tw-h-full">
            <div class="tw-p-4 tw-flex tw-flex-col gap-3 tw-h-full">
                <div class="tw-flex tw-item-center tw-justify-between">
                    <div class="tw-flex tw-items-center">
                        <v-chip :color="colorType" class="text-body-2 tw-w-fit ">{{producao.tipo_producao.nome}}</v-chip>
                    </div>
                    <div class="tw-ml-auto tw-flex tw-items-top">
                        <v-chip :color="colorType" class="font-weight-semibold" variant="outlined" size="x-small">
                            {{producao.ano_publicacao}}
                        </v-chip>
                    </div>
                </div>
                <div class="tw-flex  tw-flex-col gap-1  tw-h-full">
                    <h4 class="tw-font-[500] h4 tw-line-clamp-2">{{producao.nome}}</h4>

                    <div class="pt-2 mt-1 align-items-center mb-0 tw-text-gray-500" style="display: flex; justify-content: space-between;">
                        <div style="display: flex; align-items: center;"><p >Programa</p></div>
                        <span class="font-weight-semibold tw-text-right">{{ producao.ppg ? producao.ppg.nome : '--' }}</span>
                    </div>
                    <div class=" align-items-center tw-text-gray-500" style="display: flex; justify-content: space-between;">
                        <div style="display: flex; align-items: center;"><p >Subtipo</p></div>
                        <span class="font-weight-semibold mb-0">{{props.producao.subtipo_producao.nome ?? '--'}}</span>
                    </div>
                    <div v-if="ordem" class="align-items-center tw-mt-0.5 tw-text-gray-500" style="display: flex; justify-content: space-between;">
                        <div style="display: flex; align-items: center;"><p >Ordem de autoria</p></div>
                        <span class="font-weight-semibold mb-0">{{ordem}}</span>
                    </div>
                </div>
            </div>
            <div class="tw-px-4 tw-flex gap-2 tw-justify-between tw-border-t-2 py-2 tw-items-center ">
                <div class="d-flex align-items-center">
                    <v-avatar v-for="(autor) in producao?.autores.slice(0, 4)" :key="autor.nome" size="40" class=" tw-border-[3px]" :class="{'!tw-border-red-400': autor.incompleto, '!tw-border-green-400': !autor.incompleto}">
                        <v-tooltip activator="parent" location="top">{{autor.incompleto ? 'Pessoa com cadastro incompleto' :'Pessoa com cadastro completo'}}</v-tooltip>
                        <img :src="autor.image_path" alt="profile" height="40" width="40" class="">
                    </v-avatar>
                    <v-avatar v-if="producao.autores.length > 4" class=" bg-lightprimary text-subtitle-1 font-weight-semibold text-primary">
                        <div height="40" width="40">+{{producao.autores.length - 4}}</div>
                    </v-avatar>
                </div>
                <div v-if="producao.qualis?.estratos" class="tw-flex tw-items-center">
                    <v-chip :color="colorType" class="text-body-2 tw-w-fit ">{{producao.qualis?.estratos}}</v-chip>
                </div>
            </div>
        </div>
    </v-card>
    <ProducoesCardModal :show="showModal" :production="producao" @closeModal="showModal=false"/>
</template>
<style>
.avatar-border{
  border: 2px solid rgb(var(--v-theme-surface));
}
</style>
