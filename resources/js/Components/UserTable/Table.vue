<script setup>
import { defineProps, defineEmits, ref, watch, computed } from "vue";
import user1 from "$/assets/images/profile/user-1.jpg";

const props = defineProps({
    users: Array,
    edit: Function,
    delete: Function,
    search: Object
});

const filtredUsers = ref([]);

watch(() => props.users, (newValue) => {
  if (!props.search || props.search.trim() === '') {
    filtredUsers.value = newValue;
  }
  // Retorna os usuários filtrados que correspondem à busca
  filtredUsers.value = newValue.filter(user =>
    user.name.toLowerCase().includes(props.search.toLowerCase())
  );
});

watch(() => props.search, (newValue) => {
  if (!newValue || newValue.trim() === '') {
    filtredUsers.value = props.users;
  }
  // Retorna os usuários filtrados que correspondem à busca
  filtredUsers.value = props.users.filter(user =>
    user.name.toLowerCase().includes(newValue.toLowerCase())
  );
});

const emits = defineEmits(["edit", "delete"]);
</script>

<template>
    <v-table class="mt-5">
        <thead>
            <tr>
                <th class="text-subtitle-1 font-weight-semibold">Nome</th>
                <th class="text-subtitle-1 font-weight-semibold">Email</th>
                <th class="text-subtitle-1 font-weight-semibold">Telefone</th>
                <th class="text-subtitle-1 font-weight-semibold">
                    Tipo de Usuário
                </th>
                <th class="text-subtitle-1 font-weight-semibold text-center">
                    Ações
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in filtredUsers" :key="item.id">
                <td>
                    <div class="d-flex align-center">
                        <div>
                            <v-img
                                :src="user1"
                                width="45px"
                                class="rounded-circle img-fluid"
                            ></v-img>
                        </div>

                        <div class="ml-5">
                            <h4
                                class="text-subtitle-1 font-weight-semibold text-no-wrap"
                            >
                                {{ item.name }}
                            </h4>
                        </div>
                    </div>
                </td>
                <td class="text-subtitle-1 textSecondary text-no-wrap mt-1">
                    {{ item.email }}
                </td>
                <td class="text-subtitle-1 textSecondary text-no-wrap mt-1">
                    {{ item.telephone }}
                </td>
                <td class="text-subtitle-1 textSecondary text-no-wrap mt-1">
                    {{ item.roles[0].name }}
                </td>
                <td>
                    <div class="d-flex align-center justify-center">
                        <v-tooltip text="Editar">
                            <template v-slot:activator="{ props }">
                                <v-btn
                                    icon
                                    flat
                                    @click="$emit('edit', item)"
                                    v-bind="props"
                                >
                                    <PencilIcon
                                        stroke-width="1.5"
                                        size="20"
                                        class="text-primary"
                                    />
                                </v-btn>
                            </template>
                        </v-tooltip>
                        <v-tooltip text="Deletar">
                            <template v-slot:activator="{ props }">
                                <v-btn
                                    icon
                                    flat
                                    @click="$emit('delete', item)"
                                    v-bind="props"
                                >
                                    <TrashIcon
                                        stroke-width="1.5"
                                        size="20"
                                        class="text-error"
                                    />
                                </v-btn>
                            </template>
                        </v-tooltip>
                    </div>
                </td>
            </tr>
        </tbody>
    </v-table>
</template>