<template>
    <v-text-field v-mask v-bind="$attrs" ref="input" />
</template>

<script>
import MaskDirective from "@/directives/MaskDirective.js";

export default {
    name: "PhoneMask",
    directives: {
        mask: MaskDirective,
    },
    inheritAttrs: false,
    emits: ["update:modelValue"],
    setup(props, { emit, attrs }) {
        // O setup pode ser usado para lógicas adicionais se necessário.
        return {};
    },
};
</script>
