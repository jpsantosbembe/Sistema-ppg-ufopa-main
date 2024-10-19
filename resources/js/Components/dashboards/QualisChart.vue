<script setup >
import {onMounted, reactive, ref} from 'vue';
import { computed } from 'vue';
import { getPrimary, getLightborder,getTextGrey100 } from '@/utils/UpdateColors';
import { DotsVerticalIcon } from 'vue-tabler-icons';
import axios from "axios";

const props = defineProps({
    program:Object,
    title: String,
    subtitle:String,
    prefix: String,
    label: {
        type: String,
        default: "ano"
    },
    value: {
        type: String,
        default: "qtde"
    }
})

const emits = defineEmits(['setFilter'])

const data = ref([])
const filter = reactive({
    ano:null
})

const items = ref([
    { title: "Action" },
    { title: "Another action" },
    { title: "Something else here" },
]);


async function getData(url=route('api.qualis',props.program.id)) {
    const params = new URLSearchParams()
    params.append('ano',filter.ano ?? '')
    await axios.get(url,{params})
        .then(response=>{
            data.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}


const anos = computed(()=>{
    const anoAtual = new Date().getFullYear();
    const anos = [];
    for (let ano = 2017; ano <= anoAtual; ano++) {
        anos.push(ano);
    }
    return anos;
})



/* Chart */
const chartOptions = computed(() => {
    return {
        series: [
            {
                name: props.prefix,
                data: data.value.map(it=>it[props.value]),
            }
        ],
        colors: [getPrimary.value, "#fb977d"],
        chart: {
            type: "bar",
            fontFamily: `inherit`,
            foreColor: "#adb0bb",
            width: "100%",
            height: 300,
            stacked: true,
            toolbar: {
                show: !1,
            },
            events: {
                dataPointSelection: function(event, chartContext, opts) {
                    emits('setFilter',data.value.map(it=>it[props.label])[opts.dataPointIndex])
                }
            }
        },

        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "27%",
                borderRadius: 6,
            },
        },
        dataLabels: {
            enabled: false,
        },
        grid: {
            borderColor: getLightborder.value,
            padding: { top: 0, bottom: -8, left: 20, right: 20 },
        },
        tooltip: {
            theme: "dark",
        },
        toolbar: {
            show: false,
        },
        xaxis: {
            categories: data.value.map(it=>it[props.label]),
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                style: {
                    colors: getTextGrey100.value,
                }
            },
        },
        yaxis: {
            labels: {
                style: {
                    colors: getTextGrey100.value,
                }
            },
        },
        legend: {
            show: false,
        },
    };
});

onMounted(()=>getData())

</script>
<template>
    <v-card elevation="10">
        <v-card-item>
            <div class="d-flex align-center justify-space-between">
                <div>
                    <h5 class="text-h5 mb-1 font-weight-semibold">{{title}}</h5>
                    <v-row class="mb-5">
                        <v-col cols="12" >
                            <v-select
                                clearable
                                label="Selecionar Ano"
                                :items="anos"
                                v-model="filter.ano"
                                @update:modelValue="getData()"
                                variant="outlined"
                                hide-details="auto"
                            ></v-select>
                        </v-col>
                    </v-row>
                </div>
                <div>
                    <v-menu bottom left>
                        <template v-slot:activator="{ props }">
                            <v-btn icon color="inherit" v-bind="props" flat>
                                <DotsVerticalIcon stroke-width="1.5" size="24" class="text-grey100" />
                            </v-btn>
                        </template>
                        <v-list density="compact">
                            <v-list-item v-for="(item, i) in items" :key="i" :value="i">
                                <v-list-item-title>{{ item.title }}</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>
            </div>

            <v-row>
                <v-col cols="12" lg="12" sm="7" >
                    <apexchart type="bar" class="profit-expense" height="240" :options="chartOptions"
                        :series="chartOptions.series"> </apexchart>
                </v-col>
            </v-row>
        </v-card-item>
    </v-card>
</template>

<style type="text/css">
.profit-expense .apexcharts-bar-series.apexcharts-plot-series .apexcharts-series path {
    clip-path: inset(0 0 5% 0 round 20px);
}
</style>
