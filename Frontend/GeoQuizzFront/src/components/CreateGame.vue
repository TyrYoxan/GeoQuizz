<script setup>
import { ref } from 'vue';

const gameName = ref('');
const createGame = () => {

  console.log('Creating game with name', gameName.value);
};
</script>

<template>
  <div>
    <h1>Créer une partie</h1>
    <form @submit.prevent="createGame">
      <div>
        <label for="gameName">Nom de la partie:</label>
        <input id="gameName" v-model="gameName" type="text" required />
      </div>
      <button type="submit">Créer</button>
    </form>
  </div>
</template>

<style scoped>
</style>