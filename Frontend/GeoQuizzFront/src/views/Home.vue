<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isAuthenticated = ref(!!localStorage.getItem('authToken'))

const logout = () => {
  localStorage.removeItem('authToken')
  isAuthenticated.value = false
  alert('Déconnexion réussie. À bientôt !')
  router.push('/Authentification')
}
</script>

<template>
  <header>
    <nav class="navbar">
      <ul>
        <li v-if="isAuthenticated" @click="logout" class="btn btn-primary">
          <img class="icon" src="../assets/porte.png" alt="logout" />
        </li>
        <router-link v-else to="/Authentification" class="btn btn-primary">
          <img class="icon" src="../assets/compte.png" alt="login" />
        </router-link>
      </ul>
    </nav>
  </header>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1>Bienvenue sur GeoQuizz !</h1>

          <h2 v-if="isAuthenticated">Le meilleur jeu de Géographie Nancéien !<br></h2>
            <p v-if="isAuthenticated">Le principe est simple, avec l'image que vous aurez à disposition, vous devez trouver le lieu où elle a été prise.<br>
            Plus vous êtes proche et rapide, plus vous gagnez de points. <br>Bonne chance !
            </p>
          <h2 v-if="!isAuthenticated">Vous devez vous connecter pour jouer,<br> cliquez sur l'icon de profile en haut à droite !</h2>

          <div v-if="isAuthenticated" class="router">
            <router-link to="/partie" class="btn btn-primary">Nouvelle Partie</router-link>
          </div> 
        </div>
      </div>
    </div>
    <div v-if="isAuthenticated" class="best">
      <div class="score">
      <h2>Meilleurs scores :</h2>
      <p>1. Michelle : 1000 points</p>
      <p>2. Miguel : 999 points</p>
      <p>3. Mirabelle : 998 points</p>
      </div>
      <div class="score">
      <h2>Parties en cours :</h2>
      <p>1. Michelle</p>
      <p>2. Miguel</p>
      <p>3. Mirabelle</p>
      </div>
    </div>
  </body>
</template>




<style scoped>

h1{
  font-size: 5em;
}

h2{
  font-size: 3em;
}
p{
  font-size: 1.5em;
}

.btn{
  color: white;
}

ul{
  list-style: none;
}

.best{
  display: flex;
  flex-direction: row;
  justify-content: center;
}

.score{
  display: flex;
  flex-direction: column;
  justify-content: center;
  margin: auto;
}

.score p{
  margin: auto;
}

.navbar {
  background-color: #1459b0;
  overflow: hidden;
  position: fixed;
  top: 0;
  width: 100%;
  height: 5%;
}



.icon {
  width: 30px;
  height: 30px;
  float: right;
  margin-right: 20px;
}

.icon:hover {
  cursor: pointer;
  background-color: rgb(250, 251, 252);
}

.router {
  background-color: rgb(31, 124, 246);
  display: flex;
  justify-content: center;
  align-items: center;
  width: 20em; 
  height: 4em; 
  border-radius: 10px; 
  color: white;
  font-size: 1.2em;
  text-align: center;
  cursor: pointer; 
  transition: background-color 0.3s ease; 
  text-decoration: none;
  margin: auto;
  margin-top: 3em;
}

.router:hover {
  background-color: rgb(18, 86, 186);
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 50em;
  margin: 0;
}



</style>