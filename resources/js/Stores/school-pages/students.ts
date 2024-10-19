import { defineStore } from 'pinia';
// project imports
import {students} from "#/components/school-pages/students";

export const useStudentsStore = defineStore({
    id: 'Students',
    state: () => ({
        students: []
    }),
    getters: {},
    actions: {
        // Fetch followers from action
        async fetchStudents() {
            try {
                this.students = students
            } catch (error) {
                alert(error);
                console.log(error);
            }
        }
    }
});
