import { defineStore } from "pinia";

export const usePhotosStore = defineStore('photo', {
    state: () => ({
        photos: null
    }),
    actions: {
        setPhotos(data){
            this.photos = data
        }
    },
    getters: {
        getPhotos(state){
            return state.photos
        }
    }
})