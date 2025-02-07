<script setup>
import {computed, onMounted, ref} from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import router from "@/router/index.js";
import {useRoute} from "vue-router";
import { usePhotosStore } from "@/stores/photos.js";

const route = useRoute()
let sequence = [];


const photosStore = usePhotosStore();
const photos = photosStore.getPhotos;
let predefinedLocation = [];
let imageUrls = [];
let currentImageIndex = 0;
let imageURL = ref([]);
let points = 0;
const getPhotos = () => {
  fetch(`http://docketu.iutnc.univ-lorraine.fr:40000/parties/${route.params.id}`,{
    method: 'GET',
  }).then(response => response.json())
   .then(data => {
      sequence = data.partie.sequence.sequence;
      sequence = sequence.split('[')[1];
      sequence = sequence.split(']')[0];
      sequence = sequence.split(',').map(Number);
      for (let i = 0; i < sequence.length; i++) {
        predefinedLocation.push({lat: photos[sequence[i]-1].lat, lng: photos[sequence[i]-1].long});
        imageUrls.push(photos[sequence[i]-1].image);
      }
      imageURL = ref(imageUrls[currentImageIndex]);
   })
    .catch(error => console.error('Error:', error));
}

let numImages = 0;
const timeLeft = ref(20);
let timerInterval = null;
const score = ref(0);
// Store the current marker
let currentMarker = null;
let map = null;
const handleClick = (e) => {
  const { lat, lng } = e.latlng;

  if (currentMarker) {
    map.removeLayer(currentMarker);
  }

  currentMarker = L.marker([lat, lng]).addTo(map).openPopup();
  points = Math.round(calculateDistance(lat, lng, predefinedLocation[currentImageIndex].lat, predefinedLocation[currentImageIndex].lng));
  score.value += points;
};
computed(() => {
  imageURL.value = imageUrls[currentImageIndex];
});
onMounted(() => {
    getPhotos();
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
function changeImage() {
  numImages++;
  // Clear the exact point marker if it exists
  if (currentMarker) {
    map.removeLayer(currentMarker);
    currentMarker = null;
  }

  const exactPointMarker = map._layers[Object.keys(map._layers).find(key => map._layers[key]._popup && map._layers[key]._popup._content === 'Exact Point')];
  if (exactPointMarker) {
    map.removeLayer(exactPointMarker);
  }

  // Change the image and reset the timer
  if(numImages === imageUrls.length){
    timeLeft.value = 0;
    fetch('http://docketu.iutnc.univ-lorraine.fr:40000/parties/update', {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('tokenPartie')}`,
        'Acces-Control-Allow-Origin': '*'
        },
      body: JSON.stringify({
        id: route.params.id,
        score: score.value
      })
    }).then(router.push('/'))
      .catch(error => console.error('Error:', error));
    router.push('/');
  }
  currentImageIndex = (currentImageIndex + 1) % imageUrls.length;
  imageURL.value = imageUrls[currentImageIndex];
  map.setView([48.68935, 6.18281], 12)
  timeLeft.value = 20;

  // Reactivate the map click event
  map.on('click', handleClick);

  startTimer();
}

function handleGuess() {
  if (currentMarker) {
    timeLeft.value = 0;
  }
}

function calculateDistance(lat1, lng1, lat2, lng2) {
  const R = 6371;
  const dLat = (lat2 - lat1) * (Math.PI / 180);
  const dLng = (lng2 - lng1) * (Math.PI / 180);
  const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
      Math.sin(dLng / 2) * Math.sin(dLng / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)/200);
  return 1000 - (R * c) > 0 ? 1000 - (R * c) : 0;
}

function showExactPoint() {
  const location = predefinedLocation[currentImageIndex];
  map.setView([location.lat, location.lng], 15);
  L.marker([location.lat, location.lng]).addTo(map).bindPopup('Exact Point').openPopup();
}
</script>

<template>
  <!-- Display the image and the map -->
  <div class="image-container">
    <img :src="imageURL" alt="Centered Image" />
  </div>
  <div id="map" class="map-container"></div>
  <button @click="handleGuess" class="guess-button">Guess</button>
  <div v-if="timeLeft === 0"  class="score-display">
    <p>{{ currentImageIndex +1 }} / {{ imageUrls.length }}</p>
    <p>Score: {{ score }}</p>
    <p>Points: {{ points }}</p>
    <button @click="changeImage" class="next-image-button">
      {{ currentImageIndex + 1 < imageUrls.length ? 'Next Image' : 'Home' }}
    </button>
  </div>
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
  height: auto;
}

.map-container {
  position: fixed;
  bottom: 60px; /* Adjusted to make space for the Guess button */
  right: 10px;
  width: 300px;
  height: 200px;
  z-index: 1000;
}

.guess-button {
  position: fixed;
  bottom: 20px;
  right: 10px;
  padding: 10px 125px;
  background-color: red;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 18px;
  cursor: pointer;
  opacity: 0.8;

}

.guess-button:hover {
  background-color: darkred;
}

.timer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 20px;
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

.next-image-button {
  display: block;
  margin: 20px auto 0;
  padding: 10px 20px;
  background-color: #05768a;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 18px;
  cursor: pointer;
  opacity: 0.8;
}

.next-image-button:hover {
  background-color: #03515c;
}

</style>
