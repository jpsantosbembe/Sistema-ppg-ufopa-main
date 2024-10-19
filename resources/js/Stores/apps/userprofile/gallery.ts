import { defineStore } from 'pinia';
// project import

import {gallery} from "#/apps/userprofile/gallery";
export const useGalleryStore = defineStore({
    id: 'Gallery',
    state: () => ({
        gallery: []
    }),
    getters: {},
    actions: {
        // Fetch followers from action
         fetchGallery() {
            try {
                this.gallery = gallery
            } catch (error) {
                alert(error);
                console.log(error);
            }
        }
    }
});
