<script setup>
import {onMounted, ref} from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
// Import the image to display
const imageURL = ref(new URL('@/assets/place.jpg', import.meta.url).href);
// Store the current marker
let currentMarker = null;
onMounted(() => {
  // Initialize the map
  const map = L.map('map').setView([48.68935,6.18281], 12);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  }).addTo(map);
  // Add a click event listener to the map
  map.on('click', function(e) {
    const { lat, lng } = e.latlng;

    if (currentMarker) {
      map.removeLayer(currentMarker);
    }
    // Add a new marker and store its reference
    currentMarker = L.marker([lat, lng]).addTo(map)
        .openPopup();
  });
});
</script>

<template>
  <!-- Display the image and the map -->
  <div class="image-container">
    <img :src="imageURL" alt="Centered Image" />
  </div>
  <div id="map" class="map-container"></div>
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
</style>