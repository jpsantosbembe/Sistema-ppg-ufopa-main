import { defineStore } from 'pinia';
// project imports
import type { ClassesType } from '@/Types/components/school-pages/classes';
import {ClassesTypeData} from "#/components/school-pages/ClassesData";

interface classesType {
    classinfo: ClassesType[];
}

export const useClassesStore = defineStore({
    id: 'Classes',

    state: (): classesType => ({
        classinfo: [],
    }),
    getters: {
        // Get Post from Getters
        getPosts(state) {
            return state.classinfo;
        }
    },
    actions: {
        // Fetch Blog from action
        async fetchPosts() {
            try {
                this.classinfo = ClassesTypeData
            } catch (error) {
                alert(error);
                console.log(error);
            }
        },
        async fetchPost(title: string) {
            try {
                const paramCase = (t: string) =>
                    t
                        .toLowerCase()
                        .replace(/ /g, '-')
                        .replace(/[^\w-]+/g, '');

                this.classinfo = ClassesTypeData.find((_post: ClassesType | string | any) => paramCase(_post.title) === title);
            } catch (error) {
                alert(error);
                console.log(error);
            }
        }
    }
});
