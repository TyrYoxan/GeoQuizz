import { defineStore } from "pinia";

export const usePhotosStore = defineStore('photo', {
    state: () => ({
        photos: []
    }),
    actions: {
        setPhotos(data){
            this.photos = data
        }
    }
})