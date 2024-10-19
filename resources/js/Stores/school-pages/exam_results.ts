import { defineStore } from 'pinia';
import contacts from "#/apps/contact";
// project imports

export const useResultsStore = defineStore({
    id: 'Results',
    state: () => ({
        results: []
    }),
    getters: {},
    actions: {
        // Fetch followers from action
         fetchResults() {
            try {
                this.results = contacts
            } catch (error) {
                alert(error);
                console.log(error);
            }
        }
    }
});
