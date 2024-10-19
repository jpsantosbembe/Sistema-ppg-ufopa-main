<script setup>
import { ref } from 'vue';
import {useForm} from "@inertiajs/vue3";



const valid = ref(true);
const passwordRules = ref([
    (v) => !!v || 'Password is required',
    (v) => (v && v.length <= 10) || 'Password must be less than 10 characters'
]);
const emailRules = ref([(v) => !!v || 'E-mail is required', (v) => /.+@.+\..+/.test(v) || 'E-mail must be valid']);
const fnameRules = ref([
    (v) => !!v || 'Name is required',
    (v) => (v && v.length <= 10) || 'Name must be less than 10 characters'
]);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
<template>
    <v-row class="d-flex mb-3">
        <v-col cols="6" sm="6">
            <v-btn variant="outlined" size="large" class="border text-subtitle-1 text-gray200 font-weight-semibold" block>
                <img src="/assets/images/svgs/google-icon.svg" height="16" class="mr-2" alt="google" />
                <span class="d-sm-flex d-none mr-1">Sign in with</span>Google
            </v-btn>
        </v-col>
        <v-col cols="6" sm="6">
            <v-btn variant="outlined" size="large" class="border text-subtitle-1 text-gray200 font-weight-semibold" block>
                <img src="/assets/images/svgs/icon-facebook.svg" width="25" height="25" class="mr-1" alt="facebook" />
                <span class="d-sm-flex d-none mr-1">Sign in with</span>FB
            </v-btn>
        </v-col>
    </v-row>
    <div class="d-flex align-center text-center mb-6">
        <div class="text-h6 w-100 px-5 font-weight-regular auth-divider position-relative">
            <span class="bg-surface px-5 py-3 position-relative text-subtitle-1 text-grey100">or sign in with</span>
        </div>
    </div>
    <v-form id="form" v-model="valid" lazy-validation  class="mt-5">
        <v-label class="text-subtitle-1 font-weight-medium pb-2">Nome</v-label>
        <VTextField v-model="form.name" :rules="fnameRules" required ></VTextField>
        <v-label class="text-subtitle-1 font-weight-medium pb-2">E-mail</v-label>
        <VTextField v-model="form.email" :rules="emailRules" required ></VTextField>
        <v-label class="text-subtitle-1 font-weight-medium pb-2">Senha</v-label>
        <VTextField
            v-model="form.password"
            :counter="8"
            :rules="passwordRules"
            required
            variant="outlined"
            type="password"
            color="primary"
        ></VTextField>
        <v-label class="text-subtitle-1 font-weight-medium pb-2">Confirmar senha</v-label>
        <VTextField
            v-model="form.password_confirmation"
            :counter="8"
            :rules="passwordRules"
            required
            variant="outlined"
            type="password"
            color="primary"
        ></VTextField>
        <v-btn form="form" size="large" class="mt-2" color="primary" @click="submit" block submit rounded="pill">Cadastrar</v-btn>
    </v-form>
</template>
