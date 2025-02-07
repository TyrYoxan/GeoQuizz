<script setup>
import {onMounted, ref} from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isAuthenticated = ref(!!localStorage.getItem('authToken'))
let publicSequences = ref([])

const logout = () => {
  localStorage.removeItem('authToken')
  isAuthenticated.value = false
  alert('Déconnexion réussie. À bientôt !')
  router.push('/Authentification')
}

const getPublicSequence = () => {
  fetch('http://docketu.iutnc.univ-lorraine.fr:40000/sequences')
      .then(res => res.json())
      .then(sequences => {
        for (let sequence of sequences.sequences) {
          if (sequence.status) {
            publicSequences.value.push(sequence)
          }
        }
      })
}
const viewProfile = () => {
  router.push('/profile')
}

onMounted(getPublicSequence)
</script>

<template>
  <header>
    <nav class="navbar">
      <ul>

        <li v-if="isAuthenticated" @click="logout" class="btn btn-primary">
          <img class="icon" src="../assets/porte.png" alt="logout" />
        </li>
        <li v-if="isAuthenticated" @click="viewProfile" class="btn btn-primary">
          <img class="icon" src="../assets/utilisateur.png" alt="profil" />
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

          <h2 class="connected">Le meilleur jeu de Géographie Nancéien !<br></h2>
            <p>Le principe est simple, avec l'image que vous aurez à disposition, vous devez trouver le lieu où elle a été prise.<br>
            Plus vous êtes proche et rapide, plus vous gagnez de points. Bonne chance !
            </p>
        </div>
      </div>
    </div>

    <div  class="AllRouter">
      <div  class="router">
          <router-link to="/createPartie" class="btn btn-primary">Nouvelle Partie</router-link>
      </div>
    </div>

    <div class="best">
      <div class="score">
      <h2>Parties public :</h2>
        <ul>
          <li v-for="sequence in publicSequences" :key="sequence.sequence_id">
            <p>{{ sequence.name }}</p>
          </li>
        </ul>
      </div>
    </div>
  </body>
</template>




<style scoped>
body{
  background-image: url("../assets/stan.jpg");
}


h1{
  font-size: 5.5em;
  font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
}

h2{
  font-size: 3em;
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}

p{
  font-size: 1.5em;
  font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
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
  opacity: 1;
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
  border: 3px solid black;
  border-top-left-radius: 20px;
  border-top-right-radius: 20px;
  background-color: rgba(142, 142, 142, 0.5);
  margin-top: 3%;
}

.score p{
  margin: auto;
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

}

.icon:hover {
  cursor: pointer;
  background-color: rgba(246, 133, 42, 0.71);
  border-radius: 10px;
}

.router {
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

.router:hover {
  background-color: #e26701;
}

.container {
  display: flex;
  justify-content: center;
  height: 30em;
  margin-bottom: 6%;
}

@media screen and ((min-width: 0em) and (max-width: 70em)) {
  .best{
  display: flex;
  flex-direction: column;
  justify-content: center;
}
  .score{
    margin-top: 3%;
  }

  .container h1{
    font-size: 3.5em;
  }

  .container h2{
    font-size: 2.5em;
  }

  .container p{
    font-size: 1.3em;
  }

  .container{
    height: 25em;
    margin-bottom: 2%;
  }

  .navbar {
    width: auto;
  }
}

@media screen and ((min-width: 0em) and (max-width: 63em)) {

  .container h1{
    font-size: 3em;
  }

  .container h2{
    font-size: 2em;
  }

  .container p{
    font-size: 1.1em;
  }

  .container{
    height: 25em;
    margin-bottom: 2%;
  }

  .navbar {
    width: 100%;
  }


}

@media screen and ((min-width: 0em) and (max-width: 55em)) {

.container h1{
  font-size: 3em;
}

.container h2{
  font-size: 2em;
}

.container p{
  font-size: 1em;
}

.container{
  height: 25em;
  margin-bottom: 2%;
}

.navbar {
    width: 100%;
}

}



</style>