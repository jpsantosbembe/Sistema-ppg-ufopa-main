<script setup>
import UserTable from './Table.vue';
import UserAction from './UserForm.vue';
import user1 from "$/assets/images/profile/user-1.jpg";
import { useUsersService } from "@/composables/useUsersService.js";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { computed, watch, onMounted, ref } from "vue";
import { useToast } from "vue-toastification";

const {
  searchPpgs: searchPpgsService,
  deleteUser
} = useUsersService();
const toast = useToast();

const props = defineProps({
  users: Array,
});

const search = ref('');

const ppgs = ref([]);

const editedItem = useForm({
  id: null,
  avatar: user1,
  name: "",
  email: "",
  telephone: "",
  password: "",
  role: null,
  ppg: null,
});

function editItem(item) {
  editedItem.id = item.id;
  editedItem.name = item.name;
  editedItem.email = item.email;
  editedItem.telephone = item.telephone;
  editedItem.role = item.roles[0].name;
  editedItem.ppg = item.coordinator?.ppg_id;
}

function deleteItem(item) {
  const users = props.users?.data || [];
  const index = users.findIndex(i => i.email === item.email);
  const confirmed = true; //confirm("Você quer realmente deletar esse usuário?");

  if(index > -1 && confirmed){
    deleteUser(editedItem, item.id, {
      onSuccess: () => {
        users.splice(index, 1);
      }
    });
  }
}


async function searchPpgs(search = "") {
  searchPpgsService()
    .then((response) => {
      ppgs.value = response
    })
    .catch((error) => {
      console.error(error)
      toast.error('Erro ao buscar PPGs');
    });
}

function updateUsers() {
  editedItem.get(route('user.index'), {
    onSuccess: (response) => {
      props.users.data = response.props?.users || [];
    }
  })
}

onMounted(() => {
  searchPpgs();
});

</script>
<template>
  <v-row>
    <v-col cols="12" lg="4" md="6">
      <v-text-field
        density="compact"
        v-model="search"
        label="Buscar Usuário"
        hide-details
        variant="outlined"
      ></v-text-field>
    </v-col>
    <v-col cols="12" lg="8" md="6" class="text-right">
    <user-action
      :editedItem="editedItem"
      :ppgs="ppgs.data"
      @updateUsers="updateUsers"
    />
    </v-col>
  </v-row>
  <div class="border-table">
    <user-table
      :users="users?.data"
      :userImage="user1"
      :search="search"
      @edit="editItem"
      @delete="deleteItem"
    />
  </div>
</template>

