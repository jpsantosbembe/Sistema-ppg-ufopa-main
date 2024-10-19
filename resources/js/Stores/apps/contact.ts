import { defineStore } from 'pinia';
import contacts from "#/apps/contact";
// project imports


export const useContactStore = defineStore({
    id: 'Contact',
    state: () => ({
        contacts: []
    }),
    getters: {},
    actions: {
        // Fetch followers from action
         fetchContacts() {
            try {
                this.contacts = contacts
            } catch (error) {
                alert(error);
                console.log(error);
            }
        }
    }
});
