<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isAuthenticated = ref(!!localStorage.getItem('authToken'))

const logout = () => {
  localStorage.removeItem('authToken')
  isAuthenticated.value = false
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
          <h1>GeoQuizz</h1>
          <h2>Partie</h2>
          <router-link to="/partie" class="btn btn-primary">Nouvelle Partie</router-link>
        </div>
      </div>
    </div>
  </body>
</template>




<style scoped>
.navbar {
  background-color: #1459b0;
  overflow: hidden;
  position: fixed;
  top: 0;
  width: 100%;
}
.container {
  margin-top: 60px; /* Ajustez cette valeur en fonction de la hauteur de votre barre de navigation */
}

.icon {
  width: 30px;
  height: 30px;
  float: right;
  margin-right: 20px;
}
</style>