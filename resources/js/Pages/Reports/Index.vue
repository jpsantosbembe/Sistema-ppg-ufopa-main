<script setup >

import FullLayout from "@/Layouts/full/FullLayout.vue";
import BaseBreadcrumb from "@/Components/shared/BaseBreadcrumb.vue";
</script>

<template>
    <FullLayout>
        <BaseBreadcrumb title="Relatórios" ></BaseBreadcrumb>
        <v-row>
            <v-col cols="12" lg="4">
                <v-card class="border" elevation="0">
                    <v-card-title>Relatorios de Qualis</v-card-title>
                    <v-img src="/assets/images/logos/Logo-qualis.png" width="200"/>
                </v-card>
            </v-col>
        </v-row>
    </FullLayout>
</template>

<style scoped >
.v-input--density-comfortable {
    --v-input-control-height: 51px !important;
    --v-input-padding-top: 14px !important;
}
</style>
