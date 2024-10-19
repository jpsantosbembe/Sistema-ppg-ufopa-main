<script setup>
import { computed, ref, watch } from 'vue';
import { Icon } from "@iconify/vue";
import TurmasTable from "@/Components/TurmasTable.vue";

const props = defineProps({
    discipline: Object
});

const emit = defineEmits(['closeModal']);
const showModal = ref(false);

watch(() => props.discipline, (newValue) => {
    showModal.value = newValue !== null;
});

const turmas = computed(() => props.discipline?.turma || []);

// Função para fechar o modal
const closeDialog = () => {
    showModal.value = false;
    emit('closeModal');
};
</script>

<template>
    <v-dialog v-model="showModal" @update:modelValue="closeDialog" width="900">
        <v-card elevation="10" class="overflow-hidden ">
            <v-card-item class="mb-5">
                <v-row class="justify-space-between">
                    <v-col cols="12"  class="w-full">
                        <div class="d-sm-flex align-center justify-sm-start justify-center">
                            <div class="text-sm-left text-center">
                                <v-avatar size="100" class="userImage position-relative overflow-visible">
                                    <Icon icon="solar:clipboard-broken" height="50" width="50" class="text-primary-1" />
                                </v-avatar>
                            </div>
                            <div class="ml-sm-4 text-sm-left text-center">
                                <h5 class="text-h3 font-weight-semibold mb-1 my-sm-0 my-2">
                                    {{ discipline?.nome }}
                                    <v-chip color="primary" class="bg-lightprimary font-weight-semibold ml-2 mt-n1" variant="outlined" size="x-small">
                                        <span>Carga horária: {{ discipline?.ch }}</span>
                                    </v-chip>
                                </h5>
                            </div>
                        </div>
                    </v-col>
                </v-row>
                <TurmasTable :data="turmas" />
            </v-card-item>
        </v-card>
    </v-dialog>
</template>
