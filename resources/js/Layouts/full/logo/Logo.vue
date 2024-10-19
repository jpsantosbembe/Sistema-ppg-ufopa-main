<script setup>
import { computed } from "vue";

import {Link} from "@inertiajs/vue3";
import { useCustomizerStore } from "@/Stores/customizer";
import LogoLightRtl from "./LogoLightRtl.vue";
import LogoDarkRtl from "./LogoDarkRtl.vue";
import LogoLight from "./LogoLight.vue";
import LogoDark from "./LogoDark.vue";

const customizer = useCustomizerStore();

//const dark = ref(false);
const dark = computed(() => {
  if (
    customizer.actTheme === "DARK_BLUE_THEME" ||
    customizer.actTheme === "DARK_AQUA_THEME" ||
    customizer.actTheme === "DARK_ORANGE_THEME" ||
    customizer.actTheme === "DARK_PURPLE_THEME" ||
    customizer.actTheme === "DARK_GREEN_THEME" ||
    customizer.actTheme === "DARK_CYAN_THEME"
  ) {
    return true;
  } else {
    return false;
  }
});
</script>
<template>
    <Link :href="route('home')" >
        <div v-if="customizer.setRTLLayout" rtl>
            <LogoLightRtl v-if="dark" />
            <LogoDarkRtl v-else />
        </div>
        <div v-else>
            <LogoLight v-if="dark" />
            <LogoDark v-else />
        </div>
    </Link>
</template>
