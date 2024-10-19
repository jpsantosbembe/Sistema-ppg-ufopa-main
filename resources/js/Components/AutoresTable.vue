

<script setup>
import {computed, onMounted, ref} from "vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
  data: Array,
})

const dataTable = ref([])
const search = ref('');
const pageSize = ref(5)
const currentPage = ref(1)

onMounted(()=>{
  console.log(props.data)
  dataTable.value = props.data.map(it=>{
    return {
      id: it.id,
      autor: it.pivot.nome_autor || it.nome,
      order: it.pivot?.ordem,
        categoria:it.pivot.categoria
    }
  })
})

const filteredList = computed(() => {
  return dataTable.value.filter(item => {
    if (typeof item.autor === 'string') {
      return item.autor.toLowerCase().includes(search.value.toLowerCase());
    }
    return false;
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
    <h5 class="text-h5 mb-1 ml-2 mt-3 font-weight-semibold">Autores</h5>
  </div>
  <v-card elevation="0" class="mt-6 border">
    <div class="border-table">
      <v-table class="month-table">
        <thead>
        <tr>
            <th class="text-subtitle-1 font-weight-semibold">Ordem</th>
            <th class="text-subtitle-1 font-weight-semibold">Nome</th>
            <th class="text-subtitle-1 font-weight-semibold">Categoria</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in displayedItems" :key="item.id" class="month-item">
          <td>
            <div class="text-subtitle-1 text-primary font-weight-medium">{{ item.order }}</div>
          </td>
          <td>
            <div class="d-flex align-center">
              <div class="d-flex">
                <v-chip
                    rounded="pill"
                    color="primary"
                    :class="item.order===1 ? 'bg-primary' : 'bg-lightprimary'"
                    class="font-weight-bold px-2 mr-2"
                    size="small"
                >
                  <Link :href="route('pessoas.show',item.id)">
                    {{ item.autor }}
                  </Link>
                </v-chip>
              </div>
            </div>
          </td>
            <td>
                <div class="d-flex align-center">
                    <div class="d-flex">
                        <v-chip
                            rounded="pill"
                            color="primary"
                            :class="item.order===1 ? 'bg-primary' : 'bg-lightprimary'"
                            class="font-weight-bold px-2 mr-2"
                            size="small"
                        >
                            {{ item.categoria }}
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
    <div v-if="filteredList.length < pageSize" class="d-sm-flex justify-md-space-between align-center mt-3 tw-px-4">
      <div class="text-subtitle-1 text-grey100">
        Exibindo {{((currentPage - 1) * pageSize)+1}} a {{filteredList.length}} de {{filteredList.length}} autores
      </div>
      <div >
        <v-pagination v-model="currentPage" :length="totalPages" @input="updatePage" rounded="circle" density="comfortable" class="text-subtitle-1 text-grey100 my-4" ></v-pagination>
      </div>
    </div>
      <div v-else class="d-sm-flex justify-md-space-between align-center mt-3 tw-px-4">
          <div class="text-subtitle-1 text-grey100">
              Exibindo {{((currentPage - 1) * pageSize)+1}} a {{currentPage * pageSize}} de {{filteredList.length}} Autores
          </div>
          <div >
              <v-pagination v-model="currentPage" :length="totalPages" @input="updatePage" rounded="circle" density="comfortable" class="text-subtitle-1 text-grey100 my-4" ></v-pagination>
          </div>
      </div>
  </v-card>
</template>
