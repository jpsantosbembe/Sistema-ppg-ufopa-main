<script setup>
import {computed, onMounted, ref} from "vue";
import {Link} from "@inertiajs/vue3";
import DisciplineDetailsModal from "./DisciplinaCard/DisciplineDetailsModal.vue";

const props = defineProps({
    data:Array
})

const dataTable = ref([])
const search = ref('');
const pageSize = ref(5)
const currentPage = ref(1)
const discipline = ref(null);

onMounted(()=>{
     dataTable.value = props.data.map(it=>{
         return {
             id: it.id,
             numero: it.numero,
             name: it.nome,
             ch: it.ch,
             turma_count: it.turma_count,
             obrigatoria: it.obrigatoria,
             data_inicio: it.data_inicio,
             data_fim: it.data_fim,
         }
     })
})

const filteredList = computed(() => {
    return dataTable.value.filter((user) => {
        return user.name.toLowerCase().includes(search.value.toLowerCase());
    });
});

const totalPages = computed(()=>{
    return Math.ceil(filteredList.value.length / pageSize.value);
})
const displayedItems = computed(()=>{
    const startIndex = (currentPage.value - 1) * pageSize.value;
    const endIndex = currentPage.value * pageSize.value;
    return filteredList.value.slice(startIndex, endIndex);
})

function updatePage(value) {
    currentPage.value = value;
}

function onSelect(item) {
    console.log(item);
    discipline.value = item;
}

function closeModal(){
    discipline.value = null;
}

</script>
<template>
    <v-text-field v-model="search" append-inner-icon="mdi-magnify" label="Busca Produção" single-line hide-details class="mb-5" />
    <v-card elevation="0" class="mt-6 border">
        <div class="border-table">
        <v-table class="month-table">
            <thead>
                <tr>
                    <th class="text-subtitle-1 font-weight-semibold">Número</th>
                    <th class="text-subtitle-1 font-weight-semibold">Nome</th>
                    <th class="text-subtitle-1 font-weight-semibold">Carga horária</th>
                    <th class="text-subtitle-1 font-weight-semibold">Obrigatória</th>
                    <th class="text-subtitle-1 font-weight-semibold">Numero de turmas</th>
                    <th class="text-subtitle-1 font-weight-semibold">Data de Início</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data" :key="item?.id" class="month-item">
                    <td>
                        <div class="text-subtitle-1 text-grey100">{{ item.codigo_disciplina }}</div>
                    </td>
                    <td>
                        <div @click="onSelect(item)" class="cursor-pointer text-subtitle-1 text-grey100">{{ item.nome }}</div>
                    </td>
                    <td>
                        <div class="text-subtitle-1 text-grey100">{{ item.ch }}</div>
                    </td>
                    <td>
                        <div class="text-subtitle-1 text-grey100">{{ item.indicador_obrigatoria ? 'Sim':'Não' }}</div>
                    </td>
                    <td>
                        <div class="text-subtitle-1 text-grey100">{{ item.turma.length }}</div>
                    </td>
                    <td>
                        <div class="text-subtitle-1 text-grey100">{{ item.data_inicio }}</div>
                    </td>
                </tr>
            </tbody>
        </v-table>
            <div v-if="!displayedItems.length" class="tw-w-full tw-flex tw-justify-center tw-items-center py-5">
                Nenhum dado disponível
            </div>
        </div>
        <div class="d-sm-flex justify-md-space-between align-center mt-3 tw-px-4">
            <div class="text-subtitle-1 text-grey100">
                Mostrando {{(currentPage - 1) * pageSize}} a {{currentPage * pageSize}} de {{filteredList.length}} Pessoas
            </div>
            <div >
                <v-pagination v-model="currentPage" :length="totalPages" @input="updatePage" rounded="circle" density="comfortable" class="text-subtitle-1 text-grey100 my-4" ></v-pagination>
            </div>
        </div>
    </v-card>

    <DisciplineDetailsModal :discipline="discipline" @closeModal="closeModal"/>
</template>
