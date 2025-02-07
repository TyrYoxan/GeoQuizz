<script setup>
import { ref, onMounted } from 'vue';

const publicSequences = ref([]);

onMounted(() => {
  publicSequences.value = [
    { id: 1, name: 'Sequence 1' },
    { id: 2, name: 'Sequence 2' },
  ];
});
</script>

<template>
  <div>
    <h1>Séquence publique</h1>
    <ul>
      <li v-for="sequence in publicSequences" :key="sequence.id">
        {{ sequence.name }}
      </li>
    </ul>
  </div>
</template>

<style scoped>
</style>