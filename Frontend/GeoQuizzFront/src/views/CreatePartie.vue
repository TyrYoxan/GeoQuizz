<script setup>
import {onMounted, ref} from "vue";
import router from "@/router/index.js";
import { usePhotosStore} from "@/stores/photos.js";

let themes = ref([])
let selectedTheme = ref(null)
const getTheme = () => {
  fetch('http://localhost:40000/sequences/themes',
      {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        }
      })
   .then(response => response.json())
   .then(theme => {
      themes.value = theme;
    });
}

const storePhoto = usePhotosStore()
const createPartie = () => {
      fetch('http://localhost:40000/parties/create', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          nom: selectedTheme.value,
        }),
      })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        localStorage.setItem('tokenPartie', data.token);
        storePhoto.setPhotos(data.photo)
        router.push({name: 'partie', params: { id: data.id }});
      })
      .catch((error) => {
        console.error('Error:', error);
      });
};

onMounted(getTheme)

</script>

<template>
  <div class="create-partie-container">
    <div class="form-container">
      <h1>Créer une Nouvelle Partie</h1>
      <form @submit.prevent="createPartie">
        <div class="form-group">
          <label for="theme">Thème de la Partie</label>
          <select id="theme" v-model="selectedTheme" required>
            <option disabled value="">Sélectionnez un thème</option>
            <option v-for="theme in themes" :key="theme.id" :value="theme">{{ theme }}</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Créer la Partie</button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.create-partie-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: rgba(25, 24, 24, 0.62);  padding: 20px;
}

.form-container {
  max-width: 600px;
  width: 100%;
  padding: 20px;
  background-color: rgba(255, 255, 255, 0.91);
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="text"],
input[type="number"],
textarea,
select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-sizing: border-box;
}

textarea {
  resize: vertical;
  min-height: 100px;
}

button {
  display: block;
  width: 100%;
  padding: 10px;
  background-color: rgb(246, 133, 42);
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
}

button:hover {
  background-color: #e87619;
}
</style>