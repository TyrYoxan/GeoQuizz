<script setup>
import {onMounted, ref} from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
//Predefined location
const predefinedLocation = { lat: 48.693766, lng: 6.18422 };
// Import the image to display
const imageURL = ref(new URL('@/assets/place.jpg', import.meta.url).href);
const timeLeft = ref(20); // 20 seconds
let timerInterval = null;
const score = ref(0); // Initialize score
// Store the current marker
let currentMarker = null;
let map = null;
const handleClick = (e) => {
  const { lat, lng } = e.latlng;

  if (currentMarker) {
    map.removeLayer(currentMarker);
  }

  currentMarker = L.marker([lat, lng]).addTo(map).openPopup();
  score.value = Math.round(calculateDistance(lat, lng, predefinedLocation.lat, predefinedLocation.lng));
};

onMounted(() => {
  map = L.map('map').setView([48.68935, 6.18281], 12);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);

  map.on('click', handleClick);
  startTimer();
});

function startTimer() {
  timerInterval = setInterval(() => {
    if (timeLeft.value > 0) {
      timeLeft.value--;
    } else {
      clearInterval(timerInterval);
      showExactPoint();
      map.off('click', handleClick);
    }
  }, 1000);
}

function calculateDistance(lat1, lng1, lat2, lng2) {
  const R = 6371;
  const dLat = (lat2 - lat1) * (Math.PI / 180);
  const dLng = (lng2 - lng1) * (Math.PI / 180);
  const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
      Math.sin(dLng / 2) * Math.sin(dLng / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  return 1000 - (R * c);
}

function showExactPoint() {
  map.setView([predefinedLocation.lat, predefinedLocation.lng], 15);
  L.marker([predefinedLocation.lat, predefinedLocation.lng]).addTo(map).bindPopup('Exact Point').openPopup();
}
</script>

<template>
  <!-- Display the image and the map -->
  <div class="image-container">
    <img :src="imageURL" alt="Centered Image" />
  </div>
  <div id="map" class="map-container"></div>
  <div v-if="timeLeft === 0"  class="score-display">Score: {{ score }}</div>
  <div class="timer">
    <div class="progress-bar" :style="{ width: (timeLeft / 20) * 100 + '%' }"></div>
  </div>
</template>

<style scoped>
.image-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 100%;
}

img {
  width: 100%;
  height: 100vh;
  object-fit: cover;
}

.map-container {
  position: fixed;
  bottom: 10px;
  right: 10px;
  width: 300px;
  height: 200px;
  z-index: 1000;
}

.timer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 10px;
  background: #ddd;
}

.progress-bar {
  height: 100%;
  background: #56baed;
  transition: width 1s linear;
}
.score-display {
  position: fixed;
  height: 50%;
  width: 50%;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: rgba(0, 0, 0, 0.8);
  color: white;
  padding: 20px;
  border-radius: 10px;
  font-size: 24px;
  text-align: center;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}
</style>