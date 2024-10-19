<script setup>
import { ref, computed } from 'vue';
import { getPrimary, getTextGrey100 } from '@/utils/UpdateColors';
import { defineProps } from 'vue';

const props = defineProps({
  data: {
    type: Array,
    required: true,
    default: () => [] // nova linha
  }
});

const items = computed(() => props.data.filter((item) => item.grafico_entrando_saindo));

const activeSeries = ref({
  Egressos: true,
  Ingressos: true,
  Ativos: true,
  Abandonos: true,
  Desligados: true
});

const toggleSeries = (seriesName) => {
  activeSeries.value[seriesName] = !activeSeries.value[seriesName];
};

const lastItem = computed(() => items.value[items.value.length - 1] || {});

const chartOptions = computed(() => {
  const years = items.value.map(item => item.ano);
  const ingressosSeries = activeSeries.value.Ingressos ? items.value.map(item => item.grafico_entrando_saindo.ingressos) : [];
  const egressosSeries = activeSeries.value.Egressos ? items.value.map(item => item.grafico_entrando_saindo.egressos) : [];
  const ativosSeries = activeSeries.value.Ativos ? items.value.map(item => item.grafico_entrando_saindo.ativos) : [];
  const abandonosSeries = activeSeries.value.Abandonos ? items.value.map(item => item.grafico_entrando_saindo.abandonos) : [];
  const desligadosSeries = activeSeries.value.Desligados ? items.value.map(item => item.grafico_entrando_saindo.desligados) : [];

  return {
    series: [
      {
        name: "Egressos",
        data: egressosSeries,
      },
      {
        name: "Ingressos",
        data: ingressosSeries,
      },
      {
        name: "Ativos",
        data: ativosSeries,
      },
      {
        name: "Abandonos",
        data: abandonosSeries,
      },
      {
        name: "Desligados",
        data: desligadosSeries,
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
    colors: ["#4ba4de", "#8bc34a", "#fbc02d", "#e57373", "#ba68c8"],
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
          <h5 class="text-h5 mb-1 font-weight-semibold">Estudantes ativos</h5>
        </div>
      </div>
      <div class="mb-4">
        <apexchart type="area" class="paymentchart" height="150" :options="chartOptions"
          :series="chartOptions.series"> </apexchart>
      </div>
      <div class="d-flex align-center justify-space-between cursor-pointer mb-3" @click="toggleSeries('Egressos')" :class="{ 'ticked': !activeSeries.Egressos }">
        <div class="d-flex align-center">
          <CircleIcon size="16" style="color: #4ba4de;" />
          <div class="text-subtitle-1 text-grey100 font-weight-medium ml-1">Egressos</div>
        </div>
        <div class="text-subtitle-1 text-grey100 font-weight-medium">{{ lastItem.grafico_entrando_saindo?.egressos || 0 }}</div>
      </div>
      <div class="d-flex align-center justify-space-between cursor-pointer mb-3" @click="toggleSeries('Ingressos')" :class="{ 'ticked': !activeSeries.Ingressos }">
        <div class="d-flex align-center">
          <CircleIcon size="16" style="color: #8bc34a;" />
          <div class="text-subtitle-1 text-grey100 font-weight-medium ml-1">Ingressos</div>
        </div>
        <div class="text-subtitle-1 text-grey100 font-weight-medium">{{ lastItem.grafico_entrando_saindo?.ingressos || 0 }}</div>
      </div>
      <div class="d-flex align-center justify-space-between cursor-pointer mb-3" @click="toggleSeries('Ativos')" :class="{ 'ticked': !activeSeries.Ativos }">
        <div class="d-flex align-center">
          <CircleIcon size="16" style="color: #fbc02d;" />
          <div class="text-subtitle-1 text-grey100 font-weight-medium ml-1">Ativos</div>
        </div>
        <div class="text-subtitle-1 text-grey100 font-weight-medium">{{ lastItem.grafico_entrando_saindo?.ativos || 0 }}</div>
      </div>
      <div class="d-flex align-center justify-space-between cursor-pointer mb-3" @click="toggleSeries('Abandonos')" :class="{ 'ticked': !activeSeries.Abandonos }">
        <div class="d-flex align-center">
          <CircleIcon size="16" style="color: #e57373;" />
          <div class="text-subtitle-1 text-grey100 font-weight-medium ml-1">Abandonos</div>
        </div>
        <div class="text-subtitle-1 text-grey100 font-weight-medium">{{ lastItem.grafico_entrando_saindo?.abandonos || 0 }}</div>
      </div>
      <div class="d-flex align-center justify-space-between cursor-pointer" @click="toggleSeries('Desligados')" :class="{ 'ticked': !activeSeries.Desligados }">
        <div class="d-flex align-center">
          <CircleIcon size="16" style="color: #ba68c8;" />
          <div class="text-subtitle-1 text-grey100 font-weight-medium ml-1">Desligados</div>
        </div>
        <div class="text-subtitle-1 text-grey100 font-weight-medium">{{ lastItem.grafico_entrando_saindo?.desligados || 0 }}</div>
      </div>
    </v-card-text>
  </v-card>
</template>

<style type="text/css">
.paymentchart .apexcharts-bar-series.apexcharts-plot-series .apexcharts-series path {
  clip-path: inset(0 0 5% 0 round 20px);
}
.ticked {
  text-decoration: line-through;
  color: grey;
}
</style>
