export default {
    beforeMount(el) {
        el.oninput = function (e) {
            if (!e.isTrusted) return;

            // Limpa tudo que não é dígito
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            // Monta o valor com a máscara
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            el.dispatchEvent(new Event('input'));  // Dispara o evento input para garantir a reatividade
        }
    }
};