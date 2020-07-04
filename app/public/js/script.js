$(function () {
	const $flashMessagesContainer = $('.flash-messages-container');
	const $flashMessages = $flashMessagesContainer.find('.flash-message');

	if (0 === $flashMessages.length) {
		return;
	}

	$flashMessagesContainer.on('click', '.flash-message-exit', function (e) {
		e.preventDefault();

		$(this)
			.parents('.flash-message')
			.fadeOut(500, function () {
				$(this).remove();
			});
	});

	setTimeout(
		function () {
			$flashMessages.fadeOut(500, function () {
				$(this).remove();
			});
		},
		15000
	);
});

$(function () {
	const $mapSection = $('#map-section');
	const $mapRoutes = $mapSection.find('.map-route');

	if (0 === $mapSection.length) {
		return;
	}

	const cyclosm = L.tileLayer('https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
		minZoom: 0,
		maxZoom: 20,
	});

	const ocm = L.tileLayer('https://tile.thunderforest.com/cycle/{z}/{x}/{y}.png?apikey=09c24ee614e44efaa63ca9b4bee54a99', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
		minZoom: 0,
		maxZoom: 18,
	});

	const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
		minZoom: 0,
		maxZoom: 19,
	});

	const googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
		maxZoom: 20,
		subdomains:['mt0','mt1','mt2','mt3']
	});

	const googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
		maxZoom: 20,
		subdomains:['mt0','mt1','mt2','mt3']
	});

	const googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
		maxZoom: 20,
		subdomains:['mt0','mt1','mt2','mt3']
	});

	const waymarkedTrails = L.tileLayer('https://tile.waymarkedtrails.org/cycling/{z}/{x}/{y}.png', {
		attribution: '<a href="https://cycling.waymarkedtrails.org/">https://cycling.waymarkedtrails.org/</a>',
		minZoom: 0,
		maxZoom: 18,
	});

	const cyclosmLite = L.tileLayer('https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm-lite/{z}/{x}/{y}.png', {
		attribution: 'CyclOSM Lite',
		minZoom: 11,
		maxZoom: 20,
	});

	const openWeatherClouds = L.tileLayer('https://tile.openweathermap.org/map/clouds_new/{z}/{x}/{y}.png?appid=86cae98d04a38167cbd69a31d0581d53', {
		attribution: '<a href="https://openweathermap.org">Open Weather Map</a>',
		maxZoom: 20,
	});

	const openWeatherPrecipitation = L.tileLayer('https://tile.openweathermap.org/map/wind_new/{z}/{x}/{y}.png?appid=86cae98d04a38167cbd69a31d0581d53', {
		attribution: '<a href="https://openweathermap.org">Open Weather Map</a>',
		maxZoom: 20,
	});

	const openWeatherWindSpeed = L.tileLayer('https://tile.openweathermap.org/map/precipitation_new/{z}/{x}/{y}.png?appid=86cae98d04a38167cbd69a31d0581d53', {
		attribution: '<a href="https://openweathermap.org">Open Weather Map</a>',
		maxZoom: 20,
	});

	const openWeatherTemperature = L.tileLayer('https://tile.openweathermap.org/map/temp_new/{z}/{x}/{y}.png?appid=86cae98d04a38167cbd69a31d0581d53', {
		attribution: '<a href="https://openweathermap.org">Open Weather Map</a>',
		maxZoom: 20,
	});

	const map = L.map('map-section', {
		center: [54.34766, 18.64542],
		zoom: 10,
		layers: [$mapRoutes.length > 0 ? googleSat : cyclosm]
	});

	const baseMaps = {
		'CyclOSM': cyclosm,
		'OpenCycleMap': ocm,
		'OpenStreetMap': osm,
		'Google Streets': googleStreets,
		'Google Hybrid': googleHybrid,
		'Google Satelite': googleSat
	};

	const overlayMaps = {
		'Waymarked Trails': waymarkedTrails,
		'CyclOSM Lite': cyclosmLite,
		'Open Weather Clouds': openWeatherClouds,
		'Open Weather Precipitation': openWeatherPrecipitation,
		'Open Weather Wind Speed': openWeatherWindSpeed,
		'Open Weather Temperature': openWeatherTemperature
	};

	L.control.layers(baseMaps, overlayMaps).addTo(map);

	const geocoder = L.Control.geocoder({
		defaultMarkGeocode: false,
		position: 'topleft'
	}).addTo(map);

	geocoder.on('markgeocode', function(e) {
		map.fitBounds(e.geocode.bbox);
	});

	geocoder.addTo(map);

	L.control.locate().addTo(map);
	L.control.scale().addTo(map);

	const startIcon = L.icon({
		iconUrl: '/img/marker-start.png',
		iconSize: [20, 20]
	});

	const endIcon = L.icon({
		iconUrl: '/img/marker-end.png',
		iconSize: [20, 20]
	});

	$mapRoutes.each(function () {
		const polylinePoints = $(this).data('polyline');

		L.marker(polylinePoints[0], { icon: startIcon }).addTo(map);
		L.marker(polylinePoints[polylinePoints.length - 1], { icon: endIcon }).addTo(map);

		const polyline = L.polyline(polylinePoints, { color: 'red' }).addTo(map);

		map.fitBounds(polyline.getBounds());

		$('#route-start-navigate-button').click(function (e) {
			e.preventDefault();

			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function (position) {
					L.Routing.control({
						waypoints: [
							L.latLng(position.coords.latitude, position.coords.longitude),
							L.latLng(polylinePoints[0][0], polylinePoints[0][1])
						]
					}).addTo(map);
				});

				$(this).fadeOut(function () {
					$(this).remove();
				});
			}
		});
	});
});

$(function () {
	$('.show-hide-button').click(function (e) {
		e.preventDefault();

		$(this)
			.parents('.show-hide-section')
			.toggleClass('hidden-section');
	});
});
