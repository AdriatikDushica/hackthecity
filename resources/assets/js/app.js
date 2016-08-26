window._ = require('lodash');

window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

var map = L.map('home-map').setView([46.7818348,8.2925331], 8);
var markers = L.markerClusterGroup();

L.tileLayer('http://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
    maxZoom: 18
}).addTo(map);

$.get('/api/locations', function (locations) {
    locations.forEach(function (location) {
        var marker = L.marker([location.lat, location.lng]);

        marker.bindPopup('location id: ' + location.id);

        markers.addLayer(marker);
    });
});

markers.on('click', function (event) {
    map.setView(event.latlng);
});

markers.on('clusterclick', function (event) {
    console.log('cluster click');
});

map.addLayer(markers);