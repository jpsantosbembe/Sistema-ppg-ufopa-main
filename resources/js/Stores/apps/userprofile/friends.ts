import { defineStore } from 'pinia';
import {friends} from "#/apps/userprofile/friends";
// project imports

export const useFrinedsStore = defineStore({
    id: 'Frineds',
    state: () => ({
        friends: []
    }),
    getters: {},
    actions: {
        // Fetch followers from action
         fetchFrineds() {
            try {
                this.friends = friends
            } catch (error) {
                alert(error);
                console.log(error);
            }
        }
    }
});
