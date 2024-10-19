import { ref } from "vue";

export const passwordRules = ref([
    (v) => !!v || 'Informe uma senha',
    (v) => (v && v.length <= 10) || 'A senha deve possuir menos de 10 caracteres'
]);

export const emailRules = ref([
    (v) => !!v || 'Informe um e-mail',
    (v) => /.+@.+\..+/.test(v) || 'Digite um e-mail válido'
]);

export const nameRules = ref([
    (v) => !!v || 'Informe um nome',
    (v) => (v && v.length >= 5) || 'O nome deve ter pelo menos 5 caracteres'
]);

export const phoneRules = ref([
    (v) => !!v || 'Informe um telefone'
]);