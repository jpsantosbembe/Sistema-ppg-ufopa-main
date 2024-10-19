<script setup>
import Payments from "@/Components/dashboards/dashboard1/Payments.vue";
import VisitFromUsa from "@/Components/dashboards/dashboard1/VisitFromUsa.vue";
import ProjectsYear from "@/Components/dashboards/dashboard1/ProjectsYear.vue";
import GraduatesYear from "@/Components/dashboards/dashboard1/GraduatesYear.vue";
import FullLayout from "@/Layouts/full/FullLayout.vue";

const props = defineProps({
    data: Array,
});
</script>

<template>
    <FullLayout>
        <v-container fluid>
            <v-row>
                <!-- Grande coluna à esquerda -->
                <!-- Duas colunas pequenas empilhadas à direita -->
                <v-col cols="12" lg="8">
                    <v-row style="height: 103%;">
                        <v-col cols="12">
                            <Payments :data="data" />
                        </v-col>
                        <v-col cols="12">
                            <ProjectsYear :data="data" />
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="12" lg="4">
                    <VisitFromUsa :data="data" />
                </v-col>
                <v-col cols="12" lg="8">
                    <GraduatesYear :data="data" />
                </v-col>
            </v-row>
        </v-container>
    </FullLayout>
</template>

<style scoped>


.v-col {
  display: flex;
  flex-direction: column;
}

.v-col > .v-row {
  flex: 1;
}

.v-col > .v-row > .v-col {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

@media (max-width: 1280px) {
  .v-col > .v-row > .v-col {
    height: auto;
  }
}
</style>
