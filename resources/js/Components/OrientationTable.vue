

<script setup>
import {basicTableData3} from '#/components/table/basicTables';
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
             id: it.orientado.id,
             name: it.orientado.nome,
             data_start: it.data_inicio,
             data_end: it.data_final,
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
    <v-card elevation="0" class="mt-6 border">
        <div class="border-table">
        <v-table class="month-table">
            <thead>
                <tr>
                    <th class="text-subtitle-1 font-weight-semibold">Orientado</th>
                    <th class="text-subtitle-1 font-weight-semibold">Data de Inicio</th>
                    <th class="text-subtitle-1 font-weight-semibold">Data de Encerramento</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in displayedItems" :key="item.name" class="month-item">
                    <td>
                        <Link :href="route('pessoas.show', item?.id)">
                        <div class="d-flex align-center">
                            <div class="ml-4">
                                <h6 class="text-subtitle-1 font-weight-semibold text-no-wrap">{{ item.name }}</h6>
                            </div>
                        </div>
                        </Link>
                    </td>
                    <td>
                        <div class="text-subtitle-1 text-grey100">{{ item.data_start }}</div>
                    </td>
                    <td>
                        <div class="text-subtitle-1 text-grey100">{{ item.data_end }}</div>
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
</template>
