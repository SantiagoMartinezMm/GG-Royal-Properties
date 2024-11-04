// property-map.js

document.addEventListener('DOMContentLoaded', function () {
  const mapContainer = document.getElementById('property-map');
  if (!mapContainer || !ggMapData.latitude || !ggMapData.longitude) return;

  // Create the map using Leaflet
  const map = L.map(mapContainer).setView([ggMapData.latitude, ggMapData.longitude], 15);

  // Add OpenStreetMap tiles to the map
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  // Add a marker to the map
  L.marker([ggMapData.latitude, ggMapData.longitude]).addTo(map)
      .bindPopup(ggMapData.location)
      .openPopup();
});
