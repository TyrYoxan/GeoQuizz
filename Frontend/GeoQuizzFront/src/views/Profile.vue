<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const pseudo = ref(localStorage.getItem('pseudo') || '')
const gameHistory = ref([])
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
          <p>{{ pseudo }} a {{ game.result }} avec le code {{ game.code }} et la dernière tentative était {{ game.lastAttempt }}</p>
        </li>
      </ul>
    </div>
  </header>
</template>

<style scoped>

</style>