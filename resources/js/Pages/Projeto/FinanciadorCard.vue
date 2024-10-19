<script setup lang="ts">


const props = defineProps({
  financiador:Object,
})

</script>
<template>
  <v-row>
    <v-col cols="12">
      <v-card elevation="10" class="card-hover">
        <v-card-item class="!tw-h-24">
          <div class="d-flex align-center mb-0">
            <v-avatar size="40" class="bg-lightinfo">
              <CoinsIcon size="20" stroke-width="1.5" class="text-primary"/>
            </v-avatar>
            <div class=" ml-3">
              <h5 class="text-subtitle-1 font-weight-medium text-grey200 mb-1">{{ props.financiador?.nome }}</h5>
              <p class="text-subtitle-1 font-weight-thin text-grey100">DOC {{props.financiador?.doc}}</p>
            </div>
          </div>
        </v-card-item>
        <div class="tw-px-4 tw-flex gap-2 tw-justify-end t tw-border-t-2 py-3 tw-items-center">
          <div v-if="financiador?.estrangeiro === 'Sim'">
            <v-chip color="info" class="font-weight-semibold ml-2" variant="outlined" size="x-small">
              Financiador Estrangeiro
            </v-chip>
          </div>
          <div v-else>
            <v-chip color="info" class="font-weight-semibold ml-2" variant="outlined" size="x-small">
              Financiador Local
            </v-chip>
          </div>
        </div>
      </v-card>
    </v-col>
  </v-row>
</template>
