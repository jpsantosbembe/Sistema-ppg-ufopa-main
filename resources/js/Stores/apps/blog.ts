import { defineStore } from 'pinia';
// project imports
import type { blogpostType } from '@/Types/apps/BlogTypes';

interface blogTypeDe {
    blogposts: blogpostType[];
    recentPosts: blogpostType[];
    blogSearch: string;
    sortBy: string;
    selectedPost: blogpostType[] | any;
}

export const useBlogStore = defineStore({
    id: 'blog',

    state: (): blogTypeDe => ({
        blogposts: [],
        recentPosts: [],
        blogSearch: '',
        sortBy: 'newest',
        selectedPost: []
    }),
    getters: {
        // Get Post from Getters
        getPosts(state) {
            return state.blogposts;
        }
    },
    actions: {
        // Fetch Blog from action
    }
});
