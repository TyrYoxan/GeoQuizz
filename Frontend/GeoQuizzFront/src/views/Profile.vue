<script setup>
import {onMounted, ref} from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
let pseudo = ref(localStorage.getItem('pseudo') || '')
const gameHistory = ref([])
const isAuthenticated = ref(!!localStorage.getItem('authToken'))
let id = ref([])
const changePseudo = () => {
  const newPseudo = prompt('Entrez votre nouveau pseudo')
  if (newPseudo) {
    localStorage.setItem('pseudo', newPseudo)
    pseudo.value = newPseudo
  }
}
const logout = () => {
  localStorage.removeItem('authToken')
  isAuthenticated.value = false
  alert('Déconnexion réussie. À bientôt !')
  router.push('/Authentification')
}
const backToHome = () => {
  router.push('/')
}
const viewStats = () => {
  router.push('/stats')
}

const historique = () => {
  const token = localStorage.getItem('authToken');
  fetch('http://docketu.iutnc.univ-lorraine.fr:40000/profil', {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    }
  }).then(response => response.json())
   .then(data => {
      gameHistory.value = data.parties
      pseudo = data.pseudo
      id = data.id
    })
}

onMounted(historique)
</script>

<template>
  <header>
    <nav class="navbar">
      <ul>
        <li @click="logout" class="btn btn-primary">
          <img class="icon" src="../assets/porte.png" alt="logout" />
        </li>
        <li @click="backToHome" class="btn btn-primary">
          <img class="icon" src="../assets/home.png" alt="backToHome" />
        </li>
      </ul>
    </nav>
  </header>
  <body>
    <div class="container">
      <h1>Bienvenue {{ pseudo }}</h1>
      <div class="boutton">
        <button @click="viewStats">Voir les statistiques</button>
        <button @click="changePseudo">Changer de pseudo</button>
      </div>
      <div v-if="gameHistory.length > 0" class="game-history">
        <h2>Historique des parties :</h2>
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
    </div>
  </body>
</template>

<style scoped>
body {
  font-family: Arial, sans-serif;
  color: #e87619;
  background-color: white;
  margin: 0;
  padding: 0;
  align-items: center;
  justify-content: center;
  background-image: url("../assets/nuit.jpg");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
.game-info {
  background-color: white;
  border: 2px solid #ccc;
  margin-bottom: 5%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding-top: 0%;
  padding: 2%;
}

.navbar {
  background-color: #e87619;
  overflow: hidden;
}

.icon {
  width: 2%;
  height: 2%;
  float: right;
  margin-right: 2%;
  transition: background-color 0.3s ease;
  cursor: pointer;  
}

ul{
  list-style: none;
  margin: 0;
  padding: 0;
}

.boutton{
  display: flex;
  flex-direction: row;
}

button {
  background-color: #e87619;
  opacity: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 40%;
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

.game-history>h2 {
  margin-top: 15%;
}

h1{
  font-size: 5.5em;
  font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
  border: 3px solid black;
  border-radius: 20px;
  width: 80%;
  background-color: white;
}

.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.game-history>h2{
  background-color: white;
  border: 2px solid black;
}

</style>