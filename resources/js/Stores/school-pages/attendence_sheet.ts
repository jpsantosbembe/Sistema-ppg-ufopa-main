import { defineStore } from 'pinia';
import contacts from "#/apps/contact";
// project imports


export const useAttendenceStore = defineStore({
    id: 'Attendence',
    state: () => ({
        attendence: []
    }),
    getters: {},
    actions: {
        // Fetch followers from action
        async fetchAttendence() {
            try {
                this.attendence = contacts
            } catch (error) {
                alert(error);
                console.log(error);
            }
        }
    }
});
