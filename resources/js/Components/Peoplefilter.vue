<script setup >
import {ref, watch} from 'vue';


const emit = defineEmits(['update-options'])

const selectedBonds = ref([]);

//Reset Filter Function
function filterReset() {
    selectedBonds.value=[]
}

watch(()=>selectedBonds.value,()=>{
    console.log(selectedBonds.value)
    emit('update-options', selectedBonds.value)
})

</script>
<template>
  <VCard elevation="10" class="mb-4 topfilter d-lg-block d-none">
    <v-card-text class="py-4 px-6">
      <div class="d-flex align-center justify-space-between">
        <div class="d-flex align-center">
          <p class="text-grey100 text-subtitle-1 font-weight-medium pr-4">Filtrar Por:</p>

          <v-menu :close-on-content-click="false" class="Gender_popup" transition="scale-transition">
            <template v-slot:activator="{ props }">
              <div icon class="cursor-pointer" flat v-bind="props" size="small">
                <div class="font-weight-semibold text-15 text-grey200 d-flex">Vínculo <span
                    class="mdi mdi-menu-down" style="font-size:20px"></span></div>
              </div>
            </template>
            <v-sheet rounded="md" width="150" elevation="10" class="mt-5 dropdown-box">
              <perfect-scrollbar style="max-height: 200px">
                <v-list class="py-0 theme-list" lines="two">
                  <v-list-item color="primary" class="pa-3">
                    <v-row no-gutters>
                      <v-col cols="12">
                        <v-checkbox label="Docente" density="compact" v-model="selectedBonds"
                                    color="primary" value="1" hide-details>
                        </v-checkbox>
                      </v-col>
                      <v-col cols="12">
                        <v-checkbox label="Discente" density="compact" v-model="selectedBonds"
                                    color="primary" value="2" hide-details></v-checkbox>
                      </v-col>
                      <v-col cols="12">
                        <v-checkbox label="Participante Externo" density="compact" v-model="selectedBonds"
                                    color="primary" value="3" hide-details></v-checkbox>
                      </v-col>
                      <v-col cols="12">
                        <v-checkbox label="PosDoc" density="compact" v-model="selectedBonds"
                                    color="primary" value="4" hide-details></v-checkbox>
                      </v-col>
                      <v-col cols="12">
                        <v-checkbox label="Egresso" density="compact" v-model="selectedBonds"
                                    color="primary" value="5" hide-details></v-checkbox>
                      </v-col>
                    </v-row>
                  </v-list-item>
                </v-list>
              </perfect-scrollbar>
            </v-sheet>
          </v-menu>
          <v-divider vertical class="mx-5"></v-divider>

        </div>
        <div>
          <v-btn color="primary" @click="filterReset()" size="large" rounded="pill">Limpar Filtros</v-btn>
        </div>
      </div>
    </v-card-text>
  </VCard>
</template>

