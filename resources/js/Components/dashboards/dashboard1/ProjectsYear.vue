<script setup>
import { ref, computed } from 'vue';
import { getPrimary, getTextGrey100 } from '@/utils/UpdateColors';
import { defineProps } from 'vue';

const props = defineProps({
    data: {
        type: Array,
        required: true,
    }
});

const items = computed(() => props.data.filter((item) => item.projetos_ano));

const total = 0

const chartOptions = computed(() => {
    const years = items.value.map(item => item.ano);
    const projects_year_started = items.value.map(item => item.projetos_ano.started);
    const projects_year_finished = items.value.map(item => item.projetos_ano.finished);


    return {
        series: [
            {
                name: "Iniciados",
                data: projects_year_started,
            },{
                name: "Concluídos",
                data: projects_year_finished,
            }
        ],
        chart: {
            fontFamily: `inherit`,
            type: "area",
            height: 150,
            stacked: false,
            toolbar: {
                show: false,
            },
        },
        grid: {
            show: false,
            borderColor: "rgba(0,0,0,0.1)",
            strokeDashArray: 1,
            xaxis: {
                lines: {
                    show: false,
                },
            },
            yaxis: {
                lines: {
                    show: true,
                },
            },
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
            },
        },
        
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "10%",
                borderRadius: [3],
                borderRadiusApplication: 'end',
                borderRadiusWhenStacked: 'all'
            },
        },
        dataLabels: {
            enabled: false,
        },
        xaxis: {
            categories: years,
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                style: {
                    colors: getTextGrey100.value
                }
            }
        },
        yaxis: {
            labels: {
                show: false,
            },
        },
        tooltip: {
            theme: "dark",
        },
        legend: {
            show: false,
        },
    };
});
</script>


<template>
    <v-card elevation="10" class="roun-" style="height: 100%;">
        <v-card-text class="position-relative">
            <div class="d-flex justify-space-between d-block align-center">
                <div>
                    <h5 class="text-h5 mb-1 font-weight-semibold">Projetos por ano</h5>
                </div>
                <div class="text-right">
                    <h4 class="text-h5 mb-1 font-weight-semibold">{{ total }}</h4>
                </div>
            </div>
            <div class="mb-4">
                <apexchart style="height: 100%;" type="area" class="paymentchart" height="150" :options="chartOptions"
                    :series="chartOptions.series"> </apexchart>
            </div>
        </v-card-text>
    </v-card>
</template>

<style type="text/css">
.paymentchart .apexcharts-bar-series.apexcharts-plot-series .apexcharts-series path {
    clip-path: inset(0 0 5% 0 round 20px);
}
</style>
