import { defineStore } from 'pinia';
// project imports
import {schedule} from "#/components/school-pages/exam_schedule";

export const useScheduleStore = defineStore({
    id: 'Schedule',
    state: () => ({
        schedule: []
    }),
    getters: {},
    actions: {
        // Fetch followers from action
        async fetchSchedule() {
            try {

                this.schedule = schedule;
            } catch (error) {
                alert(error);
                console.log(error);
            }
        }
    }
});
