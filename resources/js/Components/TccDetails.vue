<script setup >
import {Link} from "@inertiajs/vue3";

defineProps({
    data:Object
})



</script>

<template>
    <div class=" border-bottom ">
        <h5 class="text-h5 font-weight-semibold">{{data?.nome}}</h5>
        <v-row class="tw-px-5 tw-w-full flex-column">
            <div class="tw-mt-12 tw-mb-2 border-bottom tw-pb-3 ">
                <h6 class="text-subtitle-1 font-weight-semibold">Detalhes</h6>
            </div>
            <div class=" tw-flex-1">
                <div>
                    <div class="py-3">
                        <Link :href="route('programa.show', data.ppg.id)">
                            <p class="text-subtitle-1 font-weight-semibold mb-0">
                                Programa:
                                <span class="text-subtitle-1 text-grey100 ms-1">{{data?.ppg.nome}}</span>
                            </p>
                        </Link>
                    </div>
                    <div class="py-3" v-if="data?.linha_pesquisa">
                        <p class="text-subtitle-1 font-weight-semibold mb-0">
                            Linha de Pesquisa:
                            <span class="text-subtitle-1 text-grey100 ms-1">{{data?.linha_pesquisa?.nome}}</span>
                        </p>
                    </div>
                    <div class="tw-py-3">
                        <Link :href="route('pessoas.show', data?.orientador.id)">
                            <p class="text-subtitle-1 font-weight-semibold mb-0">
                                Orientador:
                                <span class="text-subtitle-1 text-grey100 ms-1">{{data?.orientador.nome}}</span>
                            </p>
                        </Link>
                    </div>

                    <div class="py-3">
                        <p class="text-subtitle-1 font-weight-semibold mb-0">
                            Data de Início:
                            <span class="text-subtitle-1 text-grey100 ms-1">{{data?.data_inicio}}</span>
                        </p>
                    </div>
                    <div class="py-3">
                        <p class="text-subtitle-1 font-weight-semibold mb-0">
                            Data de Defesa:
                            <span class="text-subtitle-1 text-grey100 ms-1">{{data?.data_defesa}}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class=" mb-4 tw-flex-1">
                <div>
                    <div class="py-3" v-if="data?.projeto">
                        <Link :href="route('projeto.show', data?.projeto?.id)">
                            <p class="text-subtitle-1 font-weight-semibold mb-0">
                                Projeto:
                                <span class="text-subtitle-1 text-grey100 ms-1">{{data.projeto.nome}}</span>
                            </p>
                        </Link>
                    </div>
                </div>
            </div>
        </v-row>
    </div>
</template>


