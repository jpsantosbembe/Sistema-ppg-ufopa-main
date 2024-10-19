<script setup>
import {  ref, watch } from 'vue';
import { Icon } from "@iconify/vue";
import AutoresTable from "@/Components/AutoresTable.vue";

const props = defineProps({
  production: {
    type: Object,
    required: true
  },
    show:Boolean
});

const emit = defineEmits(['closeModal']);
const showModal = ref(props.show);

watch(()=>props.show,()=>{
    showModal.value = props.show
})

// Função para fechar o modal
const closeDialog = () => {
  emit('closeModal');
};

</script>

<template>
  <v-dialog v-model="showModal" @after-leave="closeDialog"  width="900">
    <v-card elevation="10" class="overflow-hidden px-2 ">
      <v-card-item class="mb-5">
        <v-row class="justify-space-between">
          <v-col cols="12"  class="w-full">
            <div class="d-sm-flex align-center justify-sm-start justify-center">
              <div class="text-sm-left text-center">
                <v-avatar size="100" class="userImage position-relative overflow-visible">
                  <Icon icon="solar:documents-linear" height="50" width="50" class="text-primary-1" />
                </v-avatar>
              </div>
              <div class="ml-sm-4 text-sm-left text-center">
                <h5 class="text-h4 tw-tracking-wider font-weight-semibold mb-1 my-sm-0 my-2">
                  {{ production.nome }}
                  <v-chip v-if="production.tipo_producao.nome === 'BIBLIOGRÁFICA'"
                          color="primary"
                          class="bg-lightprimary font-weight-semibold ml-2 mt-n1"
                          variant="outlined"
                          size="x-small">
                    <span>{{production.tipo_producao.nome}}</span>
                  </v-chip><v-chip v-else-if="production.tipo_producao.nome === 'TÉCNICA'"
                            color="success"
                            class="bg-lightsuccess font-weight-semibold ml-2 mt-n1"
                            variant="outlined"
                            size="x-small">
                        <span>{{production.tipo_producao.nome}}</span>
                    </v-chip><v-chip v-else
                                     color="indigo"
                                     class="bg-lightindigo font-weight-semibold ml-2 mt-n1"
                                     variant="outlined"
                                     size="x-small">
                    <span>{{production.tipo_producao.nome}}</span>
                </v-chip>
                </h5>
              </div>
            </div>
            <div class="d-sm-flex tw-ml-28 gap-2 justify-sm-start mt-2 justify-center">
              <div class="tw-flex tw-items-top">
                <v-chip :color="colorType" class="font-weight-semibold" variant="outlined" size="x-small">
                  {{production.ano_publicacao}}
                </v-chip>
              </div>
              <div class="tw-flex tw-items-top">
                <v-chip :color="colorType" class="font-weight-semibold" variant="outlined" size="x-small">
                  {{production.subtipo_producao.nome ?? '--'}}
                </v-chip>
              </div>

            </div>

          </v-col>
        </v-row>
        <AutoresTable :data="production?.autores" />
      </v-card-item>
    </v-card>
  </v-dialog>
</template>
