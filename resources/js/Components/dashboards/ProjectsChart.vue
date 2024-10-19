<script setup >
import {ref, toRef} from 'vue';
import { computed } from 'vue';
import { getPrimary, getLightborder,getTextGrey100 } from '@/utils/UpdateColors';
import { DotsVerticalIcon } from 'vue-tabler-icons';
import { Icon } from '@iconify/vue';
const items = ref([
    { title: "Action" },
    { title: "Another action" },
    { title: "Something else here" },
]);

const emits = defineEmits(['setFilter'])

const props = defineProps({
    data:Object,
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

const data = computed(() => props.data)
const last = computed(()=>{
    return data.value[data.value.length -1]?.[props.value]
})

const categories = data.value.map((it) => it[props.label]);

/* Chart */
const chartOptions = computed(() => {
    return {
        series: [
            {
                name: props.prefix ?? "Projetos",
                data: data.value.map((it) => it?.[props.value]),
            },
        ],
        chart: {
            height: 240,
            type: "area",
            fontFamily: `inherit`,
            foreColor: "#626b81",
            toolbar: {
                show: false,
            },
            events: {
                click: function(event, chartContext, opts) {
                    console.log(event)
                  }
                }
        },
        dataLabels: {
            enabled: false,
        },
        grid: {
            borderColor: getLightborder.value,
            strokeDashArray: 4,
            strokeWidth: 1,
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0,
            },
        },
        colors: [getPrimary.value],
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 0,
                inverseColors: false,
                opacityFrom: 0.5,
                opacityTo: 0,
                stops: [20, 180],
            },
        },
        stroke: {
            curve: "smooth",
            width: "2",
        },
        xaxis: {
            categories: data.value.map((it) => it[props.label]),
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                formatter: function(value) {
                    if (value?.length > 10) {
                        return value.substring(0, 10) + '...';
                    }
                    return value;
                },
                style: {
                    fontSize: '12px',
                },
            },
        },
        yaxis: {
            labels: {
                show: false,
                style: {
                    colors: getTextGrey100.value,
                }
            },
        },
        tooltip: {
            theme: "dark",
            x: {
                formatter: function(value, { dataPointIndex }) {
                    return data.value[dataPointIndex]?.[props.label];
                }
            }
        },
    };
});




</script>
<template>
    <v-card elevation="10">
        <v-card-item>
            <div class="d-flex align-center justify-space-between">
                <div>
                    <h5 class="text-h5 mb-1 font-weight-semibold">{{title}}</h5>
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
                <v-col cols="12">
                    <apexchart type="area" height="240" :options="chartOptions" :series="chartOptions.series"> </apexchart>
<!--                    <div class="d-flex align-center mt-2 gap-4">-->
<!--                        <div class="d-flex align-center">-->
<!--                            <v-avatar class="bg-lightprimary me-4">-->
<!--                                <Icon icon="solar:user-circle-linear" class="text-primary" width="24" height="24"/>-->
<!--                            </v-avatar>-->
<!--                            <div>-->
<!--                                <h6 class="text-h6 font-weight-semibold d-flex align-center">{{last}}-->
<!--                                    &lt;!&ndash;                                <v-chip color="success" class="bg-lightsuccess ml-1" variant="outlined" size="x-small">+12%</v-chip>&ndash;&gt;-->
<!--                                </h6>-->
<!--                                <p class="text-subtitle-1 text-grey100 font-weight-medium">{{  subtitle ?? 'Novos projetos' }}</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                </v-col>

            </v-row>
        </v-card-item>
    </v-card>
</template>
