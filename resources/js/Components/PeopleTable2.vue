

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


const filteredList = computed(() => {
    dataTable.value = props.data.map(it=>{
        return {
            id: it.id,
            name: it.nome,
            handle: it.abreviatura,
            image:it.image_path,
            status: it.ativo,
            statuscolor: it.active ? 'success' :'offline',
            email: it.email,
            vinculos: it.vinculos
        }
    })
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

function getTypes(types){
    let setTypes = new Set()
    for (const type in types) {
        setTypes.add(castTypePeople(types[type].vinculavel_type))
    }
    return setTypes
}


function castTypePeople(type){
    return type.split('\\')[2].substring(7)
}

</script>
<template>
    <v-card elevation="0" class=" border">
        <div class="border-table">
        <v-table class="month-table">
            <thead>
                <tr>
                    <th class="text-subtitle-1 font-weight-semibold">Perfil</th>
                    <th class="text-subtitle-1 font-weight-semibold">Situação</th>
                    <th class="text-subtitle-1 font-weight-semibold">Email</th>
                    <th class="text-subtitle-1 font-weight-semibold">Vínculos</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data" :key="item.name" class="month-item">
                    <td>
                        <Link :href="route('pessoas.show', item?.id)">
                        <div class="d-flex align-center">
                            <v-avatar size="40">
                                <img :src="item.image_path" alt="avatar" height="40" />
                            </v-avatar>
                            <div class="ml-4">
                                <h6 class="text-subtitle-1 font-weight-semibold text-no-wrap">{{ item.nome }}</h6>
                                <div class="text-subtitle-1 text-grey100 text-no-wrap mt-1">{{ item.abreviatura }}</div>
                            </div>
                        </div>
                        </Link>
                    </td>
                    <td>

                        <v-chip rounded="pill"  v-if="item.active" class="font-weight-bold pl-1 pr-2" :color="item.active ? 'success' : 'offline' " size="small">
                            <ClockHour4Icon size="15" class="mr-1" />
                            {{ item.active }}
                        </v-chip>

                        <v-chip rounded="pill" v-else class="font-weight-bold pl-1 pr-2" :color="item.active ? 'success' : 'offline' " size="small">
                            <CircleIcon size="15" class="mr-1" />
                            {{ item.active ? 'Ativo' : 'Desligado' }}
                        </v-chip>

                    </td>
                    <td>
                        <div class="text-subtitle-1 text-grey100">{{ item.email }}</div>
                    </td>
                    <td>
                        <div class="d-flex align-center">
                            <div class="d-flex">
                                <v-chip
                                    v-for="(team,key) in getTypes(item.vinculos)"
                                    :key="key"
                                    rounded="pill"
                                    :class="'font-weight-bold px-2 mr-2 bg-success'"
                                    size="small"
                                >
                                    {{ team }}
                                </v-chip>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </v-table>
            <div v-if="!data.length" class="tw-w-full tw-flex tw-justify-center tw-items-center py-5">
                Nenhum dado disponível
            </div>
        </div>
    </v-card>
</template>
