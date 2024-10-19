<template>
    <v-card elevation="10" style="height: 100%;">
        <v-card-text class="position-relative">
            <h5 class="text-h5 mb-3 font-weight-semibold">
                Relação entre discentes em diferentes países
            </h5>

            <!-- Select Filters -->
            <v-row class="mb-5">
                <v-col cols="12" sm="6">
                    <v-select
                        :items="anosDisponiveis"
                        label="Selecionar Ano"
                        v-model="filtroAno"
                        variant="outlined"
                        hide-details="auto"
                        return-object
                    ></v-select>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-select
                        class="!tw-text-gray-800"
                        :items="statusDisponiveis"
                        hide-details="auto"
                        label="Status Ativo/Inativo"
                        v-model="filtroStatus"
                        variant="outlined"
                        return-object
                    ></v-select>
                </v-col>
            </v-row>

            <div id="svgMap" ref="map" class="mt-5"></div>

            <v-row
                v-for="country in filteredCountryList"
                :key="country.countryName"
                class="align-center justify-space-between mt-6"
            >
                <v-col cols="2" md="auto" sm="2">
                    <h6
                        class="text-subtitle-1 font-weight-semibold text-grey200"
                    >
                        {{ country.countryName }}
                    </h6>
                </v-col>

                <v-col cols="7" md="8" class="px-0"
                    ><v-progress-linear
                        :value="country.percentage"
                        height="5"
                        color="info"
                        rounded
                    ></v-progress-linear
                ></v-col>
                <v-col cols="3" md="auto" sm="3">
                    <h6
                        class="text-subtitle-1 font-weight-semibold text-grey200 text-right"
                    >
                        {{ country.totalDiscentes}}
                    </h6>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>
import svgMap from "svgmap";
import "svgmap/dist/svgMap.min.css";
import { computed, onMounted, ref, watch } from "vue";
import {  mapCoutryNames } from "@/utils/getCountryCode.js";

const map = ref(null);

const props = defineProps({
    data: Array,
});

const data = computed(() => props.data.filter(i => i.mapa_pais));

const filtroAno = ref("Todos");
const filtroStatus = ref("Todos");

const anosDisponiveis = computed(() => {
    return ["Todos", ...new Set(data.value.map((item) => item.ano))];
});

const statusDisponiveis = ["Todos", "Ativos", "Inativos"];
const filteredCountryList = ref([]);

const filteredData = computed(() => {
    return data.value.filter((item) => {
        const yearMatch =
            filtroAno.value !== "Todos" ? item.ano === filtroAno.value : true;
        return yearMatch;
    });
});

const calc = (data) => {
    let totalEstudantes = 0;
    let contagemPaises = {};

    // Calcular o total de estudantes e contar por país
    data.forEach((item) => {
        Object.keys(item.mapa_pais).forEach((pais) => {
            const { ativos, inativos } = item.mapa_pais[pais];
            const total = ativos + inativos;

            if (!contagemPaises[pais]) {
                contagemPaises[pais] = total;
            } else {
                contagemPaises[pais] += total;
            }

            totalEstudantes += total;
        });
    });

    // Calcular a proporção de estudantes por país
//     return Object.keys(contagemPaises)
//         .map((pais) => {
//             const totalPais = contagemPaises[pais];
//             const percentage = (totalPais / totalEstudantes) * 100;
//             return { countryName: pais, percentage };
//         })
//         .sort((a, b) => b.totalPais - a.totalPais); // Ordenar por proporção
// };

  return Object.keys(contagemPaises)
      .map((pais) => ({
        countryName: pais,
        totalDiscentes: contagemPaises[pais],
      }))
      .sort((a, b) => b.totalDiscentes - a.totalDiscentes); // Ordenando pelo número total de discentes
};

onMounted(() => {
    updateMap();
    filteredCountryList.value = calc(filteredData.value);
});

watch([filteredData, filtroStatus], () => {
    updateMap();
    filteredCountryList.value = calc(filteredData.value);
});

const updateMap = (data = filteredData.value) => {
    const totals = {};
    data.forEach((registro) => {
        for (const [pais, dados] of Object.entries(registro.mapa_pais)) {
            if (!totals[pais]) {
                totals[pais] = { countresidents: 0 };
            }

            if (filtroStatus.value === "Todos") {
                totals[pais].countresidents += dados.ativos + dados.inativos;
            } else if (filtroStatus.value === "Ativos") {
                totals[pais].countresidents += dados.ativos;
            } else if (filtroStatus.value === "Inativos") {
                totals[pais].countresidents += dados.inativos;
            }
        }
    });

    document.getElementById("svgMap").innerHTML = "";

    new svgMap({
        targetElementID: "svgMap",
        mouseWheelZoomEnabled: false,
        hideFlag: true,
        initialZoom: 1.23,
        data: {
            data: {
                countresidents: {
                    format: "{0}",
                    thousandSeparator: ",",
                    thresholdMin: 0,
                },
            },
            applyData: "countresidents",
            values: totals,
        },
        noDataText: "Nenhum discente encontrado",
        countryNames: mapCoutryNames,
    });
};
</script>

<style lang="scss">
.svgMap-map-wrapper {
    background: transparent;
    padding-top: 70%;
    top: -20px;
}
</style>
