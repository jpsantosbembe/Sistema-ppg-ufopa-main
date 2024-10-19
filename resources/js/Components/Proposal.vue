<script setup>

import {computed, ref} from "vue";
import {Icon} from "@iconify/vue";
import FullLayout from "@/Layouts/full/FullLayout.vue";
import FaqQuestion from "@/Components/pages/faq/FaqQuestion.vue";

const {proposta}= defineProps({
    proposta:Object
})

// const filteredList = computed(() => {
//     return dataTable.value.filter((user) => {
//         return user.name.toLowerCase().includes(search.value.toLowerCase());
//     });
// });

</script>

<template>
    <v-row class="justify-center">
        <v-col cols="12" md="10">
            <v-card elevation="10" class="bg-surface tw-mb-3 ">
                <v-card-item class="tw-flex tw-w-full">
                    <div>
                        <h3 class="text-h4 font-weight-semibold">
                            Proposta
                            <v-chip color="success" class="bg-lightsuccess font-weight-semibold ml-2 mt-n1" variant="outlined" size="x-small">
                                {{proposta.ano_calendario}}
                            </v-chip>
                        </h3>
                    </div>
                </v-card-item>
            </v-card>
        </v-col>
    </v-row>
    <v-row class="justify-center">
        <v-col cols="12" md="10">
            <v-expansion-panels elevation="10" class="rounded-xl overflow-hidden" variant="accordion">
                <v-expansion-panel elevation="10" v-for="(quesito,key) in proposta.quesitos" :key="key">
                    <v-expansion-panel-title class="text-h6 py-6 font-weight-semibold">{{ quesito.nome }}</v-expansion-panel-title>
                    <v-divider></v-divider>
                    <v-expansion-panel-text class="text-subtitle-1 text-10 text-medium-emphasis pt-3 pb-2">
                        <div v-for="item in quesito.itens" >
                            <div>
                                <h3 class="my-4 tw-text-xl tw-border-b-2 tw-font-normal"> {{item.nome}}</h3>
                                <p class="my-4 tw-text-[15px] tw-text-justify" v-for="linha in item.conteudo.split(/\n/g)">{{linha}}</p>
                            </div>
                        </div>
                    </v-expansion-panel-text>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-col>
    </v-row>
</template>
