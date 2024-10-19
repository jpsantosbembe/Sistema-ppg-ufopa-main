<script setup>
import { useUsersService } from "@/composables/useUsersService.js";
import { computed, ref, watch } from "vue";
import { passwordRules, emailRules, nameRules, phoneRules } from "./rules.js";

const {
    editedItem,
    updateUsers,
} = defineProps({
    ppgs:Array,
    editedItem: Object,
    updateUsers: Function
});

const emits = defineEmits(["updateUsers"]);

const { saveUser, editUser, deleteUser } = useUsersService();

const dialog = ref(false);
const formValid = ref(false);
const items = ["Administrador", "Gestor", "Coordenador"];

watch(()=>editedItem, (newValue) => {
    if(newValue.id)
        dialog.value = true;
});

function close() {
    dialog.value = false;
    editedItem.reset();
}

function afterForm(){
    close();
    emits('updateUsers');
}

async function save() {
    if (formValid.value) {
        if (editedItem.id) {
            editUser(editedItem, {onSuccess: afterForm});
        } else {
            saveUser(editedItem, {onSuccess: afterForm});
        }
    }
}

const formTitle = computed(() => {
    return editedItem.id ? "Editar Usuário" : "Novo Usuário";
});
</script>

<template>
    <v-dialog v-model="dialog" max-width="800">
        <template v-slot:activator="{ props }">
            <v-btn
                color="primary"
                v-bind="props"
                rounded="pill"
                class="ml-auto"
            >
                <v-icon class="mr-2">mdi-account-multiple-plus</v-icon>
                Novo Usuário
            </v-btn>
        </template>
        <v-card>
            <v-form
                ref="form"
                v-model="formValid"
                @submit.prevent="save"
                class="dialog_form"
                lazy-validation
            >
                <v-card-title
                    class="px-4 pt-6 justify-space-between d-flex align-center"
                >
                    <span class="text-h5">{{ formTitle }}</span>
                    <v-btn
                        @click="dialog = false"
                        :ripple="false"
                        density="compact"
                        icon="mdi-close"
                    ></v-btn>
                </v-card-title>
                <v-card-text class="px-4">
                    <v-row>
                        <v-col cols="12" sm="6">
                            <VTextField
                                variant="outlined"
                                hide-details="auto"
                                :rules="nameRules"
                                v-model="editedItem.name"
                                label="Nome"
                            ></VTextField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <VTextField
                                variant="outlined"
                                hide-details="auto"
                                type="email"
                                :rules="emailRules"
                                v-model="editedItem.email"
                                label="E-mail"
                            ></VTextField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <VTextField
                                variant="outlined"
                                hide-details="auto"
                                v-mask="'###.###.###-##'"
                                type="text"
                                :rules="phoneRules"
                                v-model="editedItem.telephone"
                                label="Telefone"
                            ></VTextField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <VTextField
                                :rules="editedItem.id ? [] : passwordRules"
                                variant="outlined"
                                type="password"
                                hide-details="auto"
                                v-model="editedItem.password"
                                label="Senha"
                            />
                        </v-col>
                        <v-col
                            cols="12"
                            :sm="editedItem.role !== 'Coordenador' ? 12 : 6"
                        >
                            <v-autocomplete
                                variant="outlined"
                                v-model="editedItem.role"
                                :items="items"
                                label="Tipo de Usuário"
                                hide-details="auto"
                            ></v-autocomplete>
                        </v-col>
                        <v-col
                            v-if="editedItem.role === 'Coordenador'"
                            cols="12"
                            sm="6"
                        >

                            <v-autocomplete
                                variant="outlined"
                                item-title="nome"
                                item-value="id"
                                v-model="editedItem.ppg"
                                :items="ppgs"
                                label="Programa"
                                hide-details="auto"
                            >
                            </v-autocomplete>
                        </v-col>
                    </v-row>
                </v-card-text>

                <div class="pa-4 d-flex justify-end gap-2">
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        class="px-3 rounded-pill"
                        @click="close"
                        >Fechar</v-btn
                    >
                    <v-btn
                        color="primary"
                        :disabled="
                            editedItem.userinfo === '' ||
                            editedItem.usermail === ''
                        "
                        class="px-3 rounded-pill"
                        type="submit"
                    >
                        Salvar
                    </v-btn>
                </div>
            </v-form>
        </v-card>
    </v-dialog>
</template>
