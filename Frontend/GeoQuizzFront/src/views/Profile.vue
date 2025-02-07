<script setup>
import {onMounted, ref} from 'vue'
import { useRouter } from 'vue-router'
import {API_URL_BASE} from "@/conf/conf.js";

const router = useRouter()
let pseudo = ref(localStorage.getItem('pseudo') || '')
const gameHistory = ref([])
let id = ref([])
const changePseudo = () => {
  const newPseudo = prompt('Entrez votre nouveau pseudo')
  if (newPseudo) {
    localStorage.setItem('pseudo', newPseudo)
    pseudo.value = newPseudo
  }
}
const backToHome = () => {
  router.push('/')
}
const viewStats = () => {
  router.push('/stats')
}

const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGkuZ2VvcXVpenouZnIiLCJhdWQiOiJhcGkuZ2VvcXVpenouZnIiLCJpYXQiOjE3Mzg4OTI5NjIsImV4cCI6MTczODg5OTAyMiwic3ViIjoiMGQxZDBlYjYtMjYxMS00MTk2LWIxMDktMjQ4ZDRhNDE5OWEzIiwiZGF0YSI6eyJpZCI6IjBkMWQwZWI2LTI2MTEtNDE5Ni1iMTA5LTI0OGQ0YTQxOTlhMyIsImVtYWlsIjoiY2xlbUBnbWFpbC5jb20iLCJwc2V1ZG8iOiJCZXR0ZXIgQnV0dGVyZmx5Iiwicm9sZSI6MX19.B-_trbPrx_8S5o-6vr-0-zXRVezpUkn4J7ulzfBbaGJIs5f6BolBpV3FZfqHmVFHgJ9GbdpG8NufzD4oEESOeQ'
const historique = () => {
  fetch(API_URL_BASE+'profil', {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    }
  }).then(response => response.json())
   .then(data => {
     console.log(data)
      gameHistory.value = data.parties
      pseudo = data.pseudo
      id = data.id
    })
}

onMounted(historique)
</script>

<template>
<!-- Ajout du profile changement de pseudo et affichage historique partie -->
  <header>
    <h1>Bienvenue {{ pseudo }}</h1>
    <button @click="backToHome">Retour à l'accueil</button>
    <button @click="viewStats">Voir les statistiques</button>
    <button @click="changePseudo">Changer de pseudo</button>
    <div v-if="gameHistory.length > 0">
      <h2>Historique des parties</h2>
      <ul>
        <li v-for="game in gameHistory">
          <div>
            <div class="game-info">
              <h2>{{game.id}}</h2>
              <p>Sequence: {{id}}</p>
              <p>Score: {{game.score}}</p>
              <p>Status: {{ game.status ? 'Publique' : 'Privée' }}</p>
              <button v-if="game.status === false" @click="viewGame(game.id)">Publique</button>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </header>
</template>

<style scoped>
header {
  font-family: Arial, sans-serif;
  color: orange;
  background-color: white;
  margin: 0;
  padding: 0;
}
.game-info {
  background-color: white;
  padding: 10px;
  border: 1px solid #ccc;
  margin-bottom: 10px;
}

button {
  background-color: #e87619;
  opacity: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 20%;
  height: 10%;
  border-radius: 10px;
  color: white;
  font-size: 1.2em;
  text-align: center;
  cursor: pointer;
  transition: background-color 0.3s ease;
  text-decoration: none;
  margin: auto;
  margin-top: 2%;


}

button:hover {
  background-color: #e26701;
}
</style>