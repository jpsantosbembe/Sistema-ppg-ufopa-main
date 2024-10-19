<script setup>
import { Icon } from '@iconify/vue';
import {Link} from "@inertiajs/vue3";
const props = defineProps({ item: Object, level: Number });

</script>

<template>
    <!---Single Item-->
    <div class="mb-1">
        <Link :href="item.to">
            <v-list-item rounded :active="item?.route ? route().current(item.route) : false"
                :class="'  bg-hover-' + item.BgColor" :color="item.BgColor" :ripple="false" :disabled="item.disabled">
                <!---If icon-->
                <template v-slot:prepend>
                    <div :class="'navbox  bg-hover-' + item.BgColor" :color="item.BgColor">
                        <span class="icon-box">
                            <Icon :icon="'solar:' + item.icon" height="24" width="24" :level="level" class="'position-relative z-index-2 " />
                        </span>
                    </div>
                </template>
                <div class="text-decoration-none color-inherit">
                    <v-list-item-title class="text-subtitle-1 font-weight-medium" :color="item.BgColor">{{ $t(item.title) }}</v-list-item-title>
                </div>
                <!---If Caption-->
                <v-list-item-subtitle v-if="item.subCaption" class="text-caption mt-n1 hide-menu">
                    {{ item.subCaption }}
                </v-list-item-subtitle>
                <!---If any chip or label-->
                <template v-slot:append v-if="item.chip">
                    <v-chip :color="item.chipColor" class="sidebarchip hide-menu"
                        :size="item.chipIcon ? 'x-small' : 'x-small'" :variant="item.chipVariant" :prepend-icon="item.chipIcon">
                        {{ item.chip }}
                    </v-chip>
                </template>
            </v-list-item>
        </Link>
    </div>
</template>
