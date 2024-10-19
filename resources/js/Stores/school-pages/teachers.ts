import { defineStore } from 'pinia';
// project imports
import {teachers} from "#/components/school-pages/teachers";

export const useTeachersStore = defineStore({
    id: 'Teachers',
    state: () => ({
        teachers: []
    }),

    getters: {},
    actions: {
        // Fetch followers from action
         fetchTeachers() {
            try {

                this.teachers = teachers;
            } catch (error) {
                alert(error);
                console.log(error);
            }
        }
    }
});
