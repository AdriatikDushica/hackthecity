window._ = require('lodash');

window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

var uri = window.location.pathname;
var detailLocationUriRegEx = /\/locations\/(\d+)/;

if(uri=='/') {
    var map = L.map('home-map').setView([46.7818348,8.2925331], 8);
    var markers = L.markerClusterGroup();

    L.tileLayer('http://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
        maxZoom: 18
    }).addTo(map);

    $.get('/api/locations', function (locations) {
        locations.forEach(function (location) {
            var marker = L.marker([location.lat, location.lng]);

            marker.bindPopup('<a href="/locations/'+ location.id +'"><img src="' + location.path + '" class="popup-img"></a>');

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
} else if(detailLocationUriRegEx.test(uri)) {
    var match = detailLocationUriRegEx.exec(uri);
    var locationId =  match[1];

    $.get('/api/locations/' + locationId, function (location) {
        var map = L.map('map-detail').setView([location.lat, location.lng], 15);

        L.tileLayer('http://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
            maxZoom: 18
        }).addTo(map);

        L.marker([location.lat, location.lng]).addTo(map);
    });
} else if(uri=='/home/create') {
    var map = L.map('map-create').setView([46.7818348,8.2925331], 7);
    var marker = null;

    L.tileLayer('http://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
        maxZoom: 18
    }).addTo(map);

    map.on('click', function (event) {
        if(!marker) {
            marker = L.marker(event.latlng).addTo(map);
        } else {
            marker.setLatLng(event.latlng);
            map.setView(event.latlng);
        }
        $('#lat').val(event.latlng.lat);
        $('#lng').val(event.latlng.lng);
    });
}