// composables/useUsersService.js
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { useToast } from "vue-toastification";

const toast = useToast();

export function useUsersService() {
    const saveUser = (form, { onSuccess, onError } = {}) => {
        const toastId = toast("Carregando", { timeout: false });
        form.post(route("user.store"), {
            onSuccess: (e) => {
                toast.dismiss(toastId);
                toast.success("Cadastrado com Sucesso!");
                form.reset();
                typeof onSuccess === 'function' && onSuccess(e);
            },
            onError: (e) => {
                toast.dismiss(toastId);
                toast.error(e.message);
                typeof onError === 'function' && onError(e);
            },
        });
    };

    const editUser = (form, { onSuccess, onError } = {}) => {
        const toastId = toast("Atualizando", { timeout: false });
        form
            .transform((data) => ({
                ...data,
                password: data.password || null,
            }))
            .put(route("user.update", form.id), {
                onSuccess: (e) => {
                    toast.dismiss(toastId);
                    toast.success("Usuário atualizado com sucesso !");
                    form.reset();
                    typeof onSuccess === 'function' && onSuccess(e);
                },
                onError: (e) => {
                    toast.dismiss(toastId);
                    toast.error(e.message);
                    typeof onError === 'function' && onError(e);
                },
            });
    };

    const deleteUser = (form, id, { onSuccess, onError } = {}) => {
        const toastId = toast("Atualizando", { timeout: false });

        form
            .delete(route("user.destroy", id), {
                onSuccess: (e) => {
                    toast.dismiss(toastId);
                    toast.success("Usuário deletado com sucesso!");
                    typeof onSuccess === 'function' && onSuccess(e);
                },
                onError: (e) => {
                    toast.dismiss(toastId);
                    toast.error(e.message);
                    typeof onError === 'function' && onError(e);
                },
            });
    };

    const searchPpgs = () => {
        return axios.get(route("programa.search"));
    };

    return { saveUser, deleteUser, searchPpgs, editUser };
}
