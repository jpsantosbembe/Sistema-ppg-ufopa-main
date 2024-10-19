<script setup>
import { defineProps } from 'vue';
import { Icon } from '@iconify/vue';
import FinanciadorCard from '@/Pages/Projeto/FinanciadorCard.vue';
import {dateFormat} from "../../utils/DateFormat.js";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
  projeto: Object,
});
</script>

<template>
  <v-row>
    <v-col cols="5">
      <v-card elevation="10" class="bg-surface tw-mt-8">
        <v-card-item class="flex w-full">
          <h4 class="text-h5 mb-4">Sobre</h4>
          <div class="d-flex align-center mb-5">
            <v-avatar size="40" class="bg-lighterror">
              <Icon icon="solar:inbox-archive-outline" height="20" width="20" class="text-error" />
            </v-avatar>
            <div class="ml-3">
                <Link :href="route('programa.show', projeto.ppg.id)">
                    <h5 class="text-subtitle-1 font-weight-semibold text-grey200 mb-1">Programa</h5>
                    <p class="text-subtitle-1 font-weight-medium text-grey100">{{ projeto.ppg.nome }}</p>
                </Link>
            </div>
          </div>
          <div class="d-flex align-center mb-5">
            <v-avatar size="40" class="bg-lightsuccess">
              <SchoolIcon size="20" stroke-width="1.5" class="text-success" />
            </v-avatar>
            <div class="ml-3">
              <h5 class="text-subtitle-1 font-weight-semibold text-grey200 mb-1">Área de Concentração</h5>
              <p class="text-subtitle-1 font-weight-medium text-grey100">{{ projeto.area_concentracao?.nome }}</p>
            </div>
          </div>
          <div class="d-flex align-center mb-5">
            <v-avatar size="40" class="bg-lightprimary">
              <Icon icon="solar:magnifer-broken" class="text-primary" />
            </v-avatar>
            <div class="ml-3">
              <h5 class="text-subtitle-1 font-weight-semibold text-grey200 mb-1">Linha de Pesquisa</h5>
              <p class="text-subtitle-1 font-weight-medium text-grey100">{{ projeto.linha_pesquisa[0]?.nome ?? 'Nenhuma' }}</p>
            </div>
          </div>
          <v-divider class="mb-4"></v-divider>
          <h4 class="text-h5 mb-2">Informações</h4>
          <div>
            <div class="py-2 align-items-center" style="display: flex; justify-content: space-between;">
              <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
                <p>Data de Início</p>
              </div>
              <span class="text-subtitle-1 font-weight-semibold ">{{ dateFormat(projeto.data_inicio) ?? '---' }}</span>
            </div>
            <div class="align-items-center mb-3" style="display: flex; justify-content: space-between;">
              <div class="text-subtitle-1 text-grey100" style="display: flex; align-items: center;">
                <p>Data de Conclusão</p>
              </div>
              <span class="text-subtitle-1 font-weight-semibold">{{ dateFormat(projeto.data_fim) ?? '---' }}</span>
            </div>
          </div>
        </v-card-item>
      </v-card>
    </v-col>
    <v-col>
      <v-row>
        <v-col cols="12">
          <v-card elevation="10" class="bg-surface tw-mt-8">
            <div class="tw-ml-6 tw-my-5 d-flex align-center mb-5 text-grey100">
              <Icon icon="solar:dollar-minimalistic-broken" width="30" height="30" class="mr-2" />
              <h4 class="text-h4 text-grey100">Financiadores</h4>
              <v-chip size="x-small" class="ml-2 elevation-0" variant="elevated" color="primary">
                {{ projeto.financiadores.length }}
              </v-chip>
            </div>
          </v-card>
        </v-col>
        <v-col v-for="financiador in projeto.financiadores" :key="financiador.id" cols="12" lg="6" md="12" sm="12">
          <FinanciadorCard :financiador="financiador" />
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>

<style scoped>
</style>
