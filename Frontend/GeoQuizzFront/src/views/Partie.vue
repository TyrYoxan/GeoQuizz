<script setup>
import {onMounted, ref} from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { useRouter } from 'vue-router';
import router from "@/router/index.js";
//Predefined location

const getPhotos = () => {
  fetch(`http://localhost:40000/parties/{{router.params.id}}`,{
    method: 'GET',
  }).then(response => response.json())
   .then(data => {
        console.log(data)
   })
}
const predefinedLocation = [
  { lat: 48.698889, lng: 6.177778 }, // Porte de la Craffe
  { lat: 48.691389, lng: 6.186389 }, // Cathédrale Notre Dame de l'Annonciation
  { lat: 48.698056, lng: 6.174167 }, // Porte Désilles
  { lat: 48.695833, lng: 6.181667 }, // Place de la Carrière
  { lat: 48.693611, lng: 6.183333 }, // Place Stanislas
  { lat: 48.693889, lng: 6.186389 }, // Place d'Alliance
  { lat: 48.698056, lng: 6.185000 }, // Parc de la Pépinière
  { lat: 48.690000, lng: 6.179167 }, // Immeuble Génin-Louis
  { lat: 48.677778, lng: 6.165000 }, // La villa Les Clématites
  { lat: 48.680556, lng: 6.170833 }, // Parc Sainte-Marie

]
// Import the image to display
const imageUrls = [
  new URL('@/assets/uploads/0f009026-273a-45eb-8426-12f51e4e15ae.jpg', import.meta.url).href,
  new URL('@/assets/uploads/4c60f9e8-58cc-440d-ab8c-006940c75a26.jpg', import.meta.url).href,
  new URL('@/assets/uploads/6b40350c-e9a9-493f-84cb-f0e75fe51fe7.jpg', import.meta.url).href,
  new URL('@/assets/uploads/9c17d5bc-b714-42c8-ba55-d8955edb6251.jpg', import.meta.url).href,
  new URL('@/assets/uploads/51f75935-a14e-405c-a9c9-889eca48b5ac.jpg', import.meta.url).href,
  new URL('@/assets/uploads/3280bee1-5b75-477d-8408-8cff0f1cab50.jpg', import.meta.url).href,
  new URL('@/assets/uploads/07366ca4-feb8-478e-a098-8007af6a9753.jpg', import.meta.url).href,
  new URL('@/assets/uploads/2543587d-5198-482c-98a8-3fa89ac626cf.jpg', import.meta.url).href,
  new URL('@/assets/uploads/b931c2ca-4c4f-4250-970f-9a860e00b4bc.jpg', import.meta.url).href,
  new URL('@/assets/uploads/ca6a2d0c-9649-4b61-9dc8-da0bd8643a10.jpeg', import.meta.url).href,
];
const currentImageIndex = ref(0);
let numImages = 0;
const imageURL = ref(imageUrls[currentImageIndex.value]);
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
  score.value += Math.round(calculateDistance(lat, lng, predefinedLocation[currentImageIndex.value].lat, predefinedLocation[currentImageIndex.value].lng));
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
    router.push('/');
  }
  currentImageIndex.value = (currentImageIndex.value + 1) % imageUrls.length;
  imageURL.value = imageUrls[currentImageIndex.value];
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
  const location = predefinedLocation[currentImageIndex.value];
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
  <div v-if="timeLeft === 0"  class="score-display">Score: {{ score }}
    <button @click="changeImage" class="next-image-button">Next Image</button>
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
