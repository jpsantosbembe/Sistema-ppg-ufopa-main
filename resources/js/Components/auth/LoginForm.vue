<script setup>
import { ref } from "vue";
import { Form } from "vee-validate";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

const valid = ref(false);

const emailRules = ref([
    (v) => !!v || "Digite um e-mail",
    (v) => /.+@.+\..+/.test(v) || "E-mail inválido",
]);

const toast = useToast();

const formValid = ref(false);

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    if (formValid.value) {
        form.post(route("login"), {
            onError: (err) => {
                toast.error(err.message);
            },
            onFinish: () => form.reset("password"),
        });
    }
};
</script>

<template>
    <VForm
        @submit.prevent="submit"
        v-model="formValid"
        v-slot="{ errors, isSubmitting }"
        class="mt-5"
    >
        <v-label class="text-subtitle-1 font-weight-semibold pb-2 text-grey200">
            E-mail
        </v-label>
        <VTextField
            v-model="form.email"
            :rules="emailRules"
            class="mb-8"
            required
            type="email"
            hide-details="auto"
        ></VTextField>
        <v-label class="text-subtitle-1 font-weight-semibold pb-2 text-grey200"
            >Senha
        </v-label>
        <VTextField
            v-model="form.password"
            required
            hide-details="auto"
            type="password"
            class="pwdInput"
        ></VTextField>
        <div class="d-flex flex-wrap align-center my-3 ml-n2">
            <v-checkbox v-model="form.remember" hide-details color="primary">
                <template v-slot:label>Lembrar deste dispositivo</template>
            </v-checkbox>
            <div class="ml-sm-auto">
                <a
                    :href="route('password.request')"
                    class="text-primary text-decoration-none text-body-1 opacity-1 font-weight-medium"
                    >Esqueceu a senha?</a
                >
            </div>
        </div>
        <v-btn
            size="large"
            rounded="pill"
            :loading="isSubmitting"
            color="primary"
            :disabled="valid"
            block
            type="submit"
            flat
        >
            Entrar
        </v-btn>
        <div v-if="errors.apiError" class="mt-2">
            <v-alert color="error">{{ errors.apiError }}</v-alert>
        </div>
    </VForm>
</template>
