<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { dateFormat } from '@/utils/DateFormat.js';
import DisciplineDetailsModal from './DisciplineDetailsModal.vue'; // Importe o modal aqui

const props = defineProps({
    discipline: Object
});

const emit = defineEmits(['onSelect']);

const required = computed(() => {
    return props.discipline.indicador_obrigatoria ? {
        color: 'error',
        text: 'Obrigatória'
    } : {
        color: 'primary',
        text: 'Optativa'
    }
});

//tw-flex tw-flex-col gap-3 tw-h-full
</script>

<template>
    <div @click="$emit('onSelect', discipline)"> <!-- Mude para abrir o modal -->
        <v-card variant="flat" elevation="10" hover class="card-hover tw-h-full">
            <div class="tw-flex tw-flex-col gap-2 tw-h-full">
                <div class="tw-pt-6 tw-px-6 tw-flex tw-flex-col gap-3 tw-h-full">
                    <v-chip variant="outlined" :color="required.color" class="text-body-2 tw-w-fit" v-text="required.text"></v-chip>
                    <div class="tw-flex tw-flex-col tw-h-full">
                        <h3 class="tw-font-[600] h3 tw-line-clamp-2">{{ discipline.nome }}</h3>
                        <div class="py-1 align-items-center" style="display: flex; justify-content: space-between;">
                            <div class="text-subtitle-1 text-grey100" >
                                <p>Programa</p>
                            </div>
                            <p class=" tw-text-sm font-weight-semibold tw-uppercase">{{ discipline.curso.nome }}</p>
                        </div>
                        <div class="py-1 align-items-center" style="display: flex; justify-content: space-between;">
                            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
                                <p>Área de Concentração</p>
                            </div>
                            <p class=" tw-text-sm font-weight-semibold tw-text-right">{{ discipline.area_concentracao?.nome ?? '--' }}</p>
                        </div>
                        <div class="py-1 align-items-center" style="display: flex; justify-content: space-between;">
                            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
                                <p>Data de Início</p>
                            </div>
                            <span class="text-subtitle-1 font-weight-semibold mb-0">{{ dateFormat(discipline.data_inicio) }}</span>
                        </div>
                        <div class="py-1 align-items-center" style="display: flex; justify-content: space-between;">
                            <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
                                <p>Encerramento</p>
                            </div>
                            <span class="text-subtitle-1 font-weight-semibold mb-0">{{ dateFormat(discipline.data_fim) }}</span>
                        </div>
                    </div>
                </div>
                <div class="tw-flex gap-2 tw-justify-between tw-border-t-2 py-2 tw-items-center ">
                    <div class=" tw-pl-6 text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
                        <p >Carga horária</p>
                    </div>
                    <v-chip variant="outlined" :color="required.color" class="mr-6 text-body-2 tw-w-fit" v-text="discipline.ch + ' H'"></v-chip>
                </div>
            </div>
        </v-card>
    </div>
</template>
