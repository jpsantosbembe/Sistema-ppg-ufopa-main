<script setup>
import {Icon} from "@iconify/vue";
import {computed, reactive, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import {Cropper} from 'vue-advanced-cropper';
import Stencil from '@/Components/apps/user-profile/Stencil.vue';
import 'vue-advanced-cropper/dist/style.css';

const dialog = ref(false);

const cropper = ref(null);
const props = defineProps({
  people: {
    type: Object,
    required: true,
  }
});

const image = reactive({
  src: props.people.image_path,
  type: '',
});

const form = useForm({
  _method:'put',
  image:null
})

function save() {
  console.log(form.image)
  form.transform(data=>({...data,image:data.image}))
      .post(route('pessoas.update', props.people.id),{
        onSuccess:()=>{dialog.value = false},
        onError:()=>{},
      })
}

const cropImageAndSave = () => {
  if (cropper.value) {
    const canvas = cropper.value.getResult().canvas
    canvas.toBlob((blob) => {
      form.image = blob;
      save();
    });
  }
};

const onFileChange = (files) => {
  console.log(files)
  if (files || files[0]) {
    if (image.src) {
      URL.revokeObjectURL(image.src);
    }
    image.src = URL.createObjectURL(files)
    image.type = files.type
    console.log(image)
  }
};

function corVinculo (vinculavel_type) {
  if (vinculavel_type === 'Discente') {
    return { color: 'primary', text: 'Discente' };
  } else if (vinculavel_type === 'Docente') {
    return { color: 'success', text: 'Docente' };
  } else if (vinculavel_type === 'Externo') {
    return { color: 'indigo', text: 'Externo'};
  } else if (vinculavel_type === 'PosDoc') {
    return { color: 'error', text: 'PosDoc' };
  } else {
    return { color: 'default', text: 'Egresso' };
  }
}

function getUniqueVinculos(vinculos) {
  let setTypes = new Set();
  let uniqueVinculos = [];

  for (const vinculo of vinculos) {
    if (!setTypes.has(vinculo.vinculavel_type)){
      setTypes.add(vinculo.vinculavel_type);
      uniqueVinculos.push(vinculo);
    }
  }
  return uniqueVinculos;
}

const uniqueVinculos = computed(() => getUniqueVinculos(props.people.vinculos));

</script>
<template>
  <v-card elevation="10">
    <v-col cols="12" lg="8" md="6" class="text-right">
      <v-dialog v-model="dialog" max-width="800">
        <v-card class="overflow-hidden">
          <v-card-title class="px-4 pt-6 justify-space-between d-flex align-center">
            <span class="text-h5">Carregar imagem</span>
            <v-btn @click="dialog = false"  density="compact" icon="mdi-close"></v-btn>
          </v-card-title>
          <div  class="my-4 ">
            <Cropper
                ref="cropper"
                :src="image.src"
                :stencil-props="{ aspectRatio: 1 }"
                :auto-destroy="false"
                class="cropper "
                :stencil-component="Stencil"
            />
          </div>
          <v-card-text class="px-4">
            <form enctype="multipart/form-data">
              <v-file-input
                  v-model="form.image"
                  @update:modelValue="onFileChange"
                  label="Carregar Foto"
                  variant="outlined"
                  prepend-icon="mdi-camera"
              />
            </form>
          </v-card-text>
          <div class="pa-4 d-flex justify-end gap-2">
            <v-spacer></v-spacer>
            <v-btn color="error"  class=" px-3 rounded-pill" @click="dialog = false">Cancel</v-btn>
            <v-btn color="primary" class="px-3 rounded-pill" @click="cropImageAndSave">Save</v-btn>
          </div>
        </v-card>
      </v-dialog>
    </v-col>
    <v-card-text>
      <div class="d-flex justify-center text-center">
        <div class="tw-flex tw-items-center tw-justify-center tw-flex-col">
          <div class="container-image tw-rounded-full cursor-pointer " >
            <v-img
                cover
                :class="people.incompleto ? 'tw-border-2 tw-border-red-500' : '' "
                class="tw-rounded-full "
                width="110"
                height="110"
                :src="people.image_path"
            >
              <template v-slot:placeholder>
                <div class="d-flex align-center justify-center fill-height rounded-full">
                  <v-progress-circular
                      color="primary"
                      indeterminate
                  ></v-progress-circular>
                </div>
              </template>
            </v-img>
            <div @click="dialog=true" class="overlay bg-primary tw-w-[110px] tw-h-[110px] tw-rounded-full tw-flex tw-items-center tw-justify-center">
              <CameraPlusIcon class="white" stroke-width="1.5" size="50" col />
            </div>
          </div>

          <h5 class="text-h5 mt-3">{{people.nome}}</h5>
          <div v-if="!people.incompleto" class="mt-2">
            <p class="flex gap-1 justify-center font-weight-semibold mb-2">
              <span class="text-subtitle-1 text-grey100 ms-1">ID {{people.doc}}</span>
            </p>
            <v-chip
                v-for="(vinculo, index) in uniqueVinculos"
                :key="index"
                :color="corVinculo(vinculo.vinculavel_type).color"
                class="text-subtitle-1 ms-1"
            >
              {{vinculo.vinculavel_type}}
            </v-chip>
          </div>
          <div v-else class="flex gap-1 justify-center">
            <v-chip color="error" class="text-subtitle-1  ms-1">Pessoa com cadastro incompleto </v-chip>
          </div>
        </div>
      </div>
      <div class="d-flex tw-justify-around mt-12">
        <div class="d-flex align-items-center">
          <v-avatar class=" bg-lightsuccess" size="50">
            <CheckIcon class="text-success" stroke-width="1.5" size="24" col />
          </v-avatar>
          <div class="ms-3">
            <p class="text-h5 mb-1">{{people.producoes.length}}</p>
            <p class="text-subtitle-1 text-grey100">Produções</p>
          </div>
        </div>

        <div class="d-flex align-items-center">
          <v-avatar class=" bg-lightsuccess" size="50">
            <BoxIcon class="text-success" stroke-width="1.5" size="24" col />
          </v-avatar>

          <div class="ms-3">
            <p class="text-h5 mb-1">{{people.projetos.length}}</p>
            <p class="text-subtitle-1 text-grey100">Projetos</p>
          </div>
        </div>
      </div>

      <div class="mt-12">
        <div class="pb-1 mb-2 border-bottom pb-3">
          <h6 class="text-subtitle-1 font-weight-semibold">Detalhes</h6>
        </div>
        <div>
          <div class="py-3 align-items-center" style="display: flex; justify-content: space-between;">
            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
              <Icon icon="solar:letter-linear" height="24" width="24" style="margin-right: 8px"/>
              <p>E-mail</p>
            </div>
            <span class="text-subtitle-1 font-weight-semibold mb-0">{{people.email ?? '---'}}</span>
          </div>
          <div class="py-3 align-items-center" style="display: flex; justify-content: space-between;">
            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
              <Icon icon="solar:calendar-minimalistic-linear" height="24" width="24" style="margin-right: 8px"/>
              <p>Data de nascimento</p>
            </div>
            <span class="text-subtitle-1 font-weight-semibold mb-0">{{people.data_nascimento}}</span>
          </div>
          <div class="py-3 align-items-center" style="display: flex; justify-content: space-between;">
            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
              <Icon icon="solar:map-point-linear" height="24" width="24" style="margin-right: 8px"/>
              <p>Nacionalidade</p>
            </div>
            <span class="text-subtitle-1 font-weight-semibold mb-0">{{people.pais ?? '---'}}</span>
          </div>
          <div v-if="people.orcid" class="py-3 align-items-center" style="display: flex; justify-content: space-between;">
            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
              <Icon icon="academicons:orcid-square" height="24" width="24" style="margin-right: 8px"/>
              <p>Orcid</p>
            </div>
            <a target="_blank" :href="'https://orcid.org/'+people.orcid" class="text-subtitle-1 font-weight-semibold mb-0">{{people.orcid}}</a>
          </div>
          <div  v-if=" people.lattes" class="py-3 align-items-center" style="display: flex; justify-content: space-between;">
            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
              <Icon icon="academicons:lattes-square" height="24" width="24" style="margin-right: 8px"/>
              <p>Lattes</p>
            </div>
            <a target="_blank" :href="'http://lattes.cnpq.br/'+people.lattes" class="text-subtitle-1 font-weight-semibold mb-0">{{people.lattes}}</a>
          </div>
        </div>
      </div>
    </v-card-text>
  </v-card>
</template>
<style>

.cropper {
  min-height: 300px;
  width: 100%;
  max-height: 400px;
}
.container-image {
  position: relative;
}


.overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 100%;
  width: 100%;
  opacity: 0;
  transition: .5s ease;
}

.container-image:hover .overlay {
  opacity: 1;
}

</style>
