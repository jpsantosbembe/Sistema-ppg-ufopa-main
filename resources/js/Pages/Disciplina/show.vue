<script setup>

import FullLayout from "@/Layouts/full/FullLayout.vue";
import {Icon} from "@iconify/vue";
import {ref} from "vue";
import TurmasTable from "@/Components/TurmasTable.vue";


const search = ref()
const props = defineProps({
    disciplina:Object
})

const headersTurmas = ref([
    { title: 'Número', align: 'start', key: 'codigo_turma' },
    { title: 'Nome', align: 'start', key: 'nome' },
    { title: 'Período', align: 'start', key: 'periodoAno' },
]);

</script>

<template>
    <FullLayout>
        <v-card elevation="10" class="overflow-hidden ">
            <v-card-item>
                <v-row class=" justify-space-between ">
                    <v-col cols="12" md="6" sm="9" class="w-full">
                        <div class="d-sm-flex align-center justify-sm-start justify-center ">
                            <div class="text-sm-left text-center">
                                <v-avatar size="100" class="userImage position-relative overflow-visible">
                                    <Icon icon="solar:clipboard-broken" height="50" width="50" class="text-primary-1" />
                                </v-avatar>
                            </div>
                            <div class="ml-sm-4 text-sm-left text-center ">
                                <h5 class="text-h3 font-weight-semibold mb-1 my-sm-0 my-2">
                                    {{disciplina.nome}}
                                    <v-chip color="primary" class="bg-lightprimary font-weight-semibold ml-2 mt-n1" variant="outlined" size="x-small">
                                        <span >Carga horária:{{disciplina.ch}}</span>
                                    </v-chip>
                                </h5>
                            </div>
                        </div>
                    </v-col>
                </v-row>
                <TurmasTable :data="disciplina.turmas"/>
            </v-card-item>
        </v-card>

    </FullLayout>
</template>

<style scoped lang="scss">

</style>
