<script setup>
import { Icon } from '@iconify/vue';
import {usePage, Link} from "@inertiajs/vue3";
const user = usePage().props.auth.user

</script>

<template>
    <v-sheet rounded="md" color="lightprimary" class="pa-4  ExtraBox hide-menu">
        <div class="d-flex align-center justify-space-between">
            <v-avatar size="50">
                <img src="/assets/images/profile/user6.jpg" width="50" alt="Mike Nielsen" />
            </v-avatar>
            <div>
                <h6 class="text-h6 d-flex align-center font-weight-semibold">{{user.name}}</h6>
            </div>
            <div>
                <v-btn icon class="bg-lightprimary" flat  size="small">
                    <Link :href="route('logout')" method="post">
                        <Icon icon="solar:logout-linear" class="text-primary" stroke-width="3" height="24" width="24" />
                    </Link>
                </v-btn>
            </div>
        </div>
    </v-sheet>
</template>
<style lang="scss">
.ExtraBox {
    position: relative;
}

.line-height-none {
    line-height: normal;
}
</style>
