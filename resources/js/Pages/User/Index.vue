<script setup>
import FullLayout from "@/Layouts/full/FullLayout.vue";
import UserTable from "@/Components/UserTable/index.vue";
import axios from "axios";
import {onMounted, ref, watch} from "vue";
import Pagination from "@/Components/Pagination.vue";


const users = ref(null);


const search = ref('');


async function getUser(url=route('api.users')) {
    const params = new URLSearchParams()
    params.append('search',search.value)
    await axios.get(url,{params})
        .then(response=>{
            users.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}

onMounted(()=>{
    getUser()
    watch(()=>search.value,()=>{
        getUser()
    })
})

</script>

<template>
    <FullLayout>
        <v-card elevation="10">
            <v-card-text>
                <UserTable :users="users" />
                <v-divider></v-divider>
                <Pagination v-if="users != null" :links="users?.links" @getPaginated="getUser"/>
            </v-card-text>
        </v-card>
    </FullLayout>
</template>
