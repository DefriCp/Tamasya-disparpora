document.addEventListener('DOMContentLoaded', () => {
    initMap();
});

function initMap() {
    const mapEl = document.getElementById('map');
    if (!mapEl || !window.wisataData) return;

    // Center Tasikmalaya (contoh)
    const map = L.map('map').setView([-7.3274, 108.2207], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
    }).addTo(map);

    window.wisataData.forEach(w => {
        if (!w.latitude || !w.longitude) return;

        L.marker([w.latitude, w.longitude])
            .addTo(map)
            .bindPopup(`<strong>${w.nama}</strong>`);
    });
}
