<script setup >

import {TableCellsIcon, XCircleIcon} from "@heroicons/vue/24/outline/index.js";
import {Icon} from "@iconify/vue";

const props = defineProps({
    importing:Object
})

</script>

<template>
    <div class=" tw-w-full tw-border-borde tw-border-2 tw-rounded-lg py-2 px-4">
        <div class=" tw-flex tw-justify-between tw-items-center ">
            <div class="tw-flex tw-items-center gap-2 tw-text-default">

                <TableCellsIcon class="tw-w-10 tw-h-10 "/>
                <span>{{importing.name ?? 'Processando Planilha ' + importing.ano}}</span>

            </div>
            <v-chip :color="importing.status ? 'primary' : 'warning'">
                <div class="tw-flex tw-items-center tw-gap-3 ">
                    {{importing.status ? 'Processando' : 'Pendente'}}
                    <span v-if="importing.status" class="loader"></span>
                    <Icon v-else icon="solar:alarm-add-broken" height="20" width="20" class="text-primary-1" />
                </div>
            </v-chip>


<!--            <XCircleIcon @click="()=>{}" class="tw-w-6 tw-h-6"/>-->
        </div>
    </div>
</template>

<style scoped>
.loader {
    width: 20px;
    height: 20px;
    border: 2px solid #2b70e3;
    border-bottom-color: transparent;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
}

@keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
