import './bootstrap';
import '../css/app.css';


import { createPinia } from 'pinia';
import vuetify from '@/Plugins/vuetify';
import './../scss/style.scss';
import PerfectScrollbar from 'vue3-perfect-scrollbar';
import VueApexCharts from 'vue3-apexcharts';
import VueTablerIcons from 'vue-tabler-icons';
import 'vue3-carousel/dist/carousel.css';

//Mock Api data

import VCalendar from 'v-calendar';
import VueRecaptcha from 'vue3-recaptcha-v2';
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';

//i18
import { createI18n } from 'vue-i18n';
import messages from '@/utils/locales/messages';
//ScrollTop
import VueScrollTo from 'vue-scrollto';
const i18n = createI18n({
    locale: 'en',
    messages: messages,
    silentTranslationWarn: true,
    silentFallbackWarn: true
});

import { createApp, h } from 'vue';
import Toast, { POSITION } from "vue-toastification";
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import "vue-toastification/dist/index.css";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const optionsToast = {
    position: POSITION.TOP_RIGHT,
    timeout: 2000
};

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .component('EasyDataTable', Vue3EasyDataTable)
            .use(PerfectScrollbar)
            .use(createPinia())
            .use(VCalendar, {})
            .use(VueTablerIcons)
            .use(VueRecaptcha, {
                siteKey: '6LdzqbcaAAAAALrGEZWQHIHUhzJZc8O-KSTdTTh_',
                alterDomain: false // default: false
            })
            .use(VueScrollTo, {
                duration: 1000,
                easing: "ease",
                offset: -50,
            })
            .use(vuetify)
            .use(i18n)
            .use(VueApexCharts)
            .use(plugin)
            .use(ZiggyVue)
            .use(Toast, optionsToast)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
