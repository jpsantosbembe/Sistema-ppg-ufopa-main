<script setup>
import {computed, ref} from "vue";
import {dateFormat} from "../utils/DateFormat.js";

const props = defineProps({
  program:Object,
})

const data = ref([])
const search = ref('');

data.value = {
  id: props.program.id,
  name:  props.program.programa,
  slug:  props.program.sigla_ies,
  regime:  props.program.regime_trabalho ?? '--',
  categoria:  props.program.categoria ?? '--',
  ch: props.program.ch,
  data_start:  props.program.data_inicio,
  data_end:  props.program.data_fim,
  bond:  props.program.vinculavel_type,
  nivel: props.program.nivel,
}

const filteredList = computed(() => {
  return data.value.filter((user) => {
    return user.name.toLowerCase().includes(search.value.toLowerCase());
  });
});

</script>

<template>
  <v-card :href="route('programa.show',data.id)" elevation="10" hover class="card-hover tw-h-full " >
    <div class="tw-flex tw-flex-col gap-2 tw-h-full">
      <div class="tw-p-4 tw-flex tw-flex-col gap-3 tw-h-full">
        <v-chip v-if="data.data_end == '--' && data.bond != 'Egresso'" variant="outlined" color="success" class="bg-lightsuccess text-body-2 tw-w-fit" v-text="data.bond"></v-chip>
        <v-chip v-else variant="outlined" color="primary" class="bg-lightprimary text-body-2 tw-w-fit" v-text="data.bond"></v-chip>
        <div class="tw-flex  tw-flex-col gap-2  tw-h-full">
          <h4 class="tw-font-[500] h4 tw-line-clamp-2">{{data.name}}</h4>
          <div class="py-1 align-items-center" style="display: flex; justify-content: space-between;">
            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
              <p>IES</p>
            </div>
            <span class="text-subtitle-1 font-weight-semibold mb-0">{{data.slug}}</span>
          </div>
          <div v-if="data.bond == 'Docente'" class="align-items-center" style="display: flex; justify-content: space-between;">
            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
              <p >Categoria</p>
            </div>
            <span class="text-subtitle-1 font-weight-semibold mb-0">{{data.categoria}}</span>
          </div>
          <div v-if="data.bond != 'Egresso' && data.bond == 'Docente'" class="align-items-center" style="display: flex; justify-content: space-between;">
            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
              <p>Regime</p>
            </div>
            <span class="text-subtitle-1 font-weight-semibold mb-0">{{data.regime}}</span>
          </div>
            <div v-if="data.bond == 'Docente'" class="align-items-center" style="display: flex; justify-content: space-between;">
                <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
                    <p>Carga horária</p>
                </div>
                <span class="text-subtitle-1 font-weight-semibold mb-0">{{data.ch}}h </span>
            </div>
          <div v-if="data.bond == 'Egresso'" class="align-items-center" style="display: flex; justify-content: space-between;">
            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
                <p>Ano titulação</p>
            </div>
            <span class="text-subtitle-1 font-weight-semibold mb-0">{{data.data_start ?? 'Não definida'}}</span>
          </div>
            <div v-else class="align-items-center" style="display: flex; justify-content: space-between;">
                <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
                    <p>Data de início</p>
                </div>
                <span class="text-subtitle-1 font-weight-semibold mb-0">{{dateFormat(data.data_start) ?? 'Não definida'}}</span>
            </div>
          <div v-if="data.bond !== 'Egresso'" class="align-items-center" style="display: flex; justify-content: space-between;">
            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
              <p >Encerramento</p>
            </div>
            <span class="text-subtitle-1 font-weight-semibold mb-0">{{data.data_end}}</span>
          </div>
        </div>
      </div>
      <div class="tw-px-4 tw-flex gap-2 tw-justify-between t tw-border-t-2 py-4 tw-items-center ">
        <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
          <p>Nível</p>
        </div>
          <v-chip v-if="data.data_end == '--' && data.bond != 'Egresso'" color="success" class="font-weight-semibold ml-2 mt-n1" variant="outlined" size="x-small">
          {{data.nivel}}
        </v-chip>
          <v-chip v-else color="primary" class="font-weight-semibold ml-2 mt-n1" variant="outlined" size="x-small">
          {{data.nivel}}
        </v-chip>
      </div>
    </div>
  </v-card>
</template>

