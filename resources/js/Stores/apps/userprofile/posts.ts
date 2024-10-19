import { defineStore } from 'pinia';
// project imports
import {posts} from "#/apps/userprofile/posts";
import type { Reply } from '@/Types/apps/PostType';

export const usePostsStore = defineStore({
    id: 'post',
    state: () => ({
        posts: []
    }),
    getters: {},
    actions: {
        // Fetch Posts from action
        async fetchPosts() {
            try {
                this.posts = posts;
            } catch (error) {
                alert(error);
                console.log(error);
            }
        },
        // like post
        async likePost(postId: string) {
            try {
                this.posts = posts;
            } catch (error) {
                alert(error);
                console.log(error);
            }
        },
        // add Comment
        async addComment(postId: string, comment: Reply) {
            try {
                this.posts = posts;
            } catch (error) {
                alert(error);
                console.log(error);
            }
        },
        // add Comment
        async addReply(postId: string, commentId: string, reply: Reply) {
            try {
                this.posts = posts;
            } catch (error) {
                alert(error);
                console.log(error);
            }
        }
    }
});
