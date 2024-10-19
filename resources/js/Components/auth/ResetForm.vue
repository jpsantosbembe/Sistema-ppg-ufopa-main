<script setup lang="ts">
import { ref } from 'vue';
import {useForm} from "@inertiajs/vue3";
const valid = ref(true);
const show1 = ref(false);
const emailRules = ref([(v: string) => !!v || 'E-mail is required', (v: string) => /.+@.+\..+/.test(v) || 'E-mail must be valid']);

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>
<template>
    <v-form ref="form" v-model="valid" lazy-validation action="/dashboards/analytical" class="mt-sm-13 mt-8">
        <v-label class="text-subtitle-1 font-weight-medium pb-2 text-lightText">Email Address</v-label>
        <VTextField v-model="form.email" :rules="emailRules" required ></VTextField>
        <v-btn size="large" color="primary" @click="submit" block  submit rounded="pill">Forgot Password</v-btn>
    </v-form>
</template>
