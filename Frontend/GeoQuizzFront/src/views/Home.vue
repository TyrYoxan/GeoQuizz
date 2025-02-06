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

          <h2 v-if="isAuthenticated" class="connected">Le meilleur jeu de Géographie Nancéien !<br></h2>
            <p v-if="isAuthenticated">Le principe est simple, avec l'image que vous aurez à disposition, vous devez trouver le lieu où elle a été prise.<br>
            Plus vous êtes proche et rapide, plus vous gagnez de points. Bonne chance !
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
body{
  background-image: url("../assets/stan.jpg");
}


h1{
  font-size: 5em;
  font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}

h2{
  font-size: 3em;
  font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}
p{
  font-size: 1.5em;
  font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
}


.btn{
  color: white;
  font-size: 2em;
  font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
  
}

ul{
  list-style: none;
}

.best{
  display: flex;
  flex-direction: row;
  justify-content: center;
}


.best h2{
  padding: 0.3em;
  color: white;
  border-bottom: 3px solid black;

}

.score h2{
  background-color:#e87619;
  opacity: 0.8;
  margin-top: 0%;
  margin-bottom: 5%;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
}

.container h1{
  border: 3px solid black;
  color: rgb(253, 235, 220);
  border-radius: 20px;
}

.connected{
  border-bottom: 2px solid black;
  border-radius: 20px;
}

.score{
  display: flex;
  flex-direction: column;
  justify-content: center;
  margin: auto;
  border: 3px solid black;
  border-top-left-radius: 20px;
  border-top-right-radius: 20px;
  background-color: rgba(255, 255, 255, 0.5);
}

.score p{
  margin: auto;
}

.navbar {
  background-color: #e87619;
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
  background-color: #e87619;
  opacity: 0.9;
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
  margin-top: 15%;
  margin-bottom: 5%;
}

.router:hover {
  background-color: #e26701;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 48em;
  margin: 0;
}



</style>