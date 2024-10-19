import { defineStore } from 'pinia';
// project imports

import {photos} from "#/apps/userprofile/photos";

export const usePhotosStore = defineStore({
    id: 'Photos',
    state: () => ({
        photos: []
    }),
    getters: {},
    actions: {
        // Fetch followers from action
        async fetchPhotos() {
            try {

                this.photos =photos
            } catch (error) {
                alert(error);
                console.log(error);
            }
        }
    }
});
