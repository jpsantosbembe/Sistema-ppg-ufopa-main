

<script setup>
import {computed, onMounted, ref} from "vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    data:Array
})

const dataTable = ref([])
const search = ref('');
const pageSize = ref(5)
const currentPage = ref(1)

onMounted(()=>{
     dataTable.value = props.data.map(it=>{
         return {
             numero: it.codigo_turma,
             name: it.nome,
             periodoAno: it.periodoAno,
             responsavel: it.responsavel,
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

</script>
<template>
    <div class="tw-my-2">
        <h5 class="text-h5 mb-1 font-weight-semibold">Turmas</h5>
    </div>
<!--    <v-text-field v-model="search" append-inner-icon="mdi-magnify" label="Search" single-line hide-details class="mb-5" />-->
    <v-card elevation="0" class="mt-6 border">
        <div class="border-table">
        <v-table class="month-table">
            <thead>
                <tr>
                    <th class="text-subtitle-1 font-weight-semibold">Período</th>
                    <th class="text-subtitle-1 font-weight-semibold">Responsável</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in displayedItems" :key="item.name" class="month-item">
                    <td>
                        <div class="text-subtitle-1 text-grey100">{{ item.periodoAno }}</div>
                    </td>
                    <td>
                        <div class="d-flex align-center">
                            <div class="d-flex">
                                <v-chip
                                    v-for="(resp,key) in item.responsavel"
                                    :key="key"
                                    rounded="pill"
                                    :class="resp.indicador_resp_principal ?'bg-success' : 'bg-normal'"
                                    class="font-weight-bold px-2 mr-2"
                                    size="small"
                                >
                                    <Link :href="route('pessoas.show',resp.pessoa.id)">
                                        {{ resp.pessoa.nome   }}
                                    </Link>
                                </v-chip>
                            </div>
                        </div>
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
                Mostrando {{(currentPage - 1) * pageSize}} a {{currentPage * pageSize}} de {{filteredList.length}} Turmas
            </div>
            <div >
                <v-pagination v-model="currentPage" :length="totalPages" @input="updatePage" rounded="circle" density="comfortable" class="text-subtitle-1 text-grey100 my-4" ></v-pagination>
            </div>
        </div>
    </v-card>
</template>
