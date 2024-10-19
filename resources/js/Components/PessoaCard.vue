<script setup xmlns="http://www.w3.org/1999/html">
import {Icon} from "@iconify/vue";

const props = defineProps({
  people:Object,
  resp: Boolean,
  vinculoMembroProjeto:{
      type:String
  }
})

function required (vinculavel_type) {
  if (vinculavel_type === 'Discente') {
    return { color: 'primary', text: 'Discente' };
  } else if (vinculavel_type === 'Docente') {
    return { color: 'success', text: 'Docente' };
  } else if (vinculavel_type === 'Externo' || 'Participante Externo') {
    return { color: 'indigo', text: 'Externo' };
  } else if (vinculavel_type === 'PosDoc') {
    return { color: 'error', text: 'PosDoc' };
  } else {
    return { color: 'default', text: 'Egresso' };
  }
}

function getTypes(types){
  let setTypes = new Set()
  for (const type in types) {
    setTypes.add(castTypePeople(types[type].vinculavel_type));
  }
  return Array.from(setTypes);
}

function castTypePeople(type){
  return type.split('\\')[2].substring(7)
}

</script>

<template>
  <v-card :href="route('pessoas.show', people.id)" elevation="10" hover class="card-hover tw-h-full !tw-flex tw-flex-col">
      <div class="tw-flex tw-items-center tw-p-4 tw-h-full">
          <div class="tw-mx-4 ">
             <v-img
                    cover
                    class="tw-rounded-full "
                    width="110"
                    height="110"
                    :src="people.image_path"
             ></v-img>
          </div>
          <div class="tw-flex-1  ">
            <h5 class="text-h5 mt-3 mb-1 !tw-text-zinc-700 ">{{people.nome}}</h5>
            <div class="flex gap-1 justify-center">
              <p class="text-subtitle-1 font-weight-semibold mb-0">
                <span class="text-subtitle-1 text-grey100">ID {{people.doc}}</span>
              </p>
            </div>
            <div class="py-2 tw-mt-2 tw-flex tw-justify-between" style="display: flex; justify-content: space-between; align-items: center;">
              <div class="text-subtitle-1 text-grey100" style="display: flex;">
                <Icon icon="solar:letter-linear" height="24" width="24" style="margin-right: 8px"/>
                <p class="mt-1">E-mail</p>
              </div>
              <span class="text-subtitle-1 font-weight-semibold mb-0">{{people.email}}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <div class="text-subtitle-1 text-grey100" style="display: flex; ">
                <Icon icon="solar:paperclip-2-outline" height="24" width="24" style="margin-right: 8px"/>
                <p class="mr-2 mt-1">Abreviatura</p>
              </div>
              <span class="text-subtitle-1 font-weight-semibold ">{{people.abreviatura}}</span>
            </div>
          </div>
      </div>
      <div  class="tw-px-4 tw-flex gap-1 tw-justify-between tw-border-t-2 py-2 ">
        <div class="">
          <v-chip v-if="vinculoMembroProjeto"
                  rounded="pill"
                  class="font-weight-medium px-2 mr-2 bg-s"
                  size="small"
                  :color="required(vinculoMembroProjeto).color"
          >
            {{ vinculoMembroProjeto }}
          </v-chip>
          <v-chip
              v-else
              v-for="(team, key) in getTypes(people?.vinculos)"
              :key="key"
              rounded="pill"
              class="'font-weight-bold px-2 mr-2 bg-s'"
              size="small"
              :color="required(team).color"
          >
              {{ team }}
          </v-chip>

        </div>
        <div v-if="resp" class="">
          <v-chip variant="outlined" color="primary" class=" text-body-2 tw-w-fit" v-text="'Responsável'"></v-chip>
        </div>
      </div>
  </v-card>
</template>

