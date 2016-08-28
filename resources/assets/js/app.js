window._ = require('lodash');

window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

var uri = window.location.pathname;
var detailLocationUriRegEx = /\/locations\/(\d+)/;
var createNextUriRegEx = /\/create\/(\d+)\/next/;

var provider = 'https://api.mapbox.com/styles/v1/mapbox/streets-v9/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWRyaWF0aWsiLCJhIjoiY2lzYWc2Mng5MDAybTJ1cDVwZGM3ZXJoNSJ9.vmdtEOIgkBcOea1aUCb3Xg';
// var provider = 'http://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png';

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

if(uri=='/') {
    var map = L.map('home-map').setView([46.7818348,8.2925331], 8);
    var markers = L.markerClusterGroup();

    L.tileLayer(provider, {
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

        L.tileLayer(provider, {
            maxZoom: 18
        }).addTo(map);

        L.marker([location.lat, location.lng]).addTo(map);
    });

    $('#notifications-tab').click(function () {
        $.get('/notifications/read', function (result) {
            $('#badge').html('0');
        });
    });
} else if(createNextUriRegEx.test(uri)) {
    var coordinates = null;
    var coordinatesOk = $('#lat').val().length && $('#lng').val().length;
    var zoom = 7;

    var marker = null;

    if(coordinatesOk) {
        coordinates = [$('#lat').val(), $('#lng').val()];
        marker = L.marker(coordinates, {draggable: true});
        zoom = 12;
    } else {
        coordinates = [46.7818348, 8.2925331];
    }

    var map = L.map('map-create').setView(coordinates, zoom);

    if(marker)
        marker.addTo(map);

    L.tileLayer(provider, {
        maxZoom: 18
    }).addTo(map);

    map.on('click', function (event) {
        if(!marker) {
            marker = L.marker(event.latlng, {draggable: true}).addTo(map);
        } else {
            marker.setLatLng(event.latlng);
            map.setView(event.latlng);
        }
        $('#lat').val(event.latlng.lat);
        $('#lng').val(event.latlng.lng);
    });
}