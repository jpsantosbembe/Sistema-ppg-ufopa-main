import { defineStore } from 'pinia';
// project imports

import {followers} from "#/apps/userprofile/followers";

export const useFollowersStore = defineStore({
    id: 'followers',
    state: () => ({
        followers: []
    }),
    getters: {},
    actions: {
        // Fetch followers from action
        async fetchFollowers() {
            try {
                this.followers = followers;
            } catch (error) {
                alert(error);
                console.log(error);
            }
        }
    }
});
