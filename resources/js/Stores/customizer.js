import {defineStore} from "pinia";
import config from '@/config'


export const useCustomizerStore = defineStore({
    id: "customizer",
    state: () => ({
        Sidebar_drawer: config.Sidebar_drawer,
        Customizer_drawer: config.Customizer_drawer,
        mini_sidebar: config.mini_sidebar,
        setHorizontalLayout: config.setHorizontalLayout, // Horizontal layout
        setRTLLayout: config.setRTLLayout, // RTL layout
        actTheme: config.actTheme,
        boxed: config.boxed,
        setBorderCard: config.setBorderCard,
        sidebarScroll:0,
    }),

    getters: {},
    actions: {
        SET_SCROLL_SIDEBAR(position) {
            this.sidebarScroll = position;
        },
        SET_SIDEBAR_DRAWER() {
            this.Sidebar_drawer = !this.Sidebar_drawer;
        },
        SET_MINI_SIDEBAR(payload) {
            this.mini_sidebar = payload;
        },
        SET_CUSTOMIZER_DRAWER(payload) {
            this.Customizer_drawer = payload;
        },

        SET_LAYOUT(payload) {
            this.setHorizontalLayout = payload;
        },
        SET_THEME(payload) {
            this.actTheme = payload;
        },
        SET_CARD_BORDER(payload) {
            this.setBorderCard = payload
        }
    },
});
