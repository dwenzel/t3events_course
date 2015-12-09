/**
 * Display a map for single view of courses
 * @file: map.js
 * @author: Dirk Wenzel
 */

$(document).ready(function () {
	initMap();
});
function initMap() {
	gm = google.maps;
	mapContainer = document.getElementById('map_canvas');
	geocoder = new gm.Geocoder();
	mapOptions = {
		zoom: settings.initialZoom,
		mapTypeId: gm.MapTypeId.ROADMAP
	};
	map = new gm.Map(mapContainer, mapOptions);
	loadMapData();
}

function loadMapData() {
	if (eventLocation.latitude && eventLocation.longitude) {
		marker = new google.maps.LatLng(parseFloat(eventLocation.latitude), parseFloat(eventLocation.longitude));
		addMarker(marker);
	}
}

function addMarker(position) {
	marker = new google.maps.Marker({
		position: position,
		map: map
	});
	map.setCenter(position);
	return marker;
}