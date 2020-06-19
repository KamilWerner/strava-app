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
	if (0 === $('#map-section').length) {
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
		layers: [cyclosm]
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

	L.easyButton(
		'fa-question',
		function(btn, map) {
			window.open('https://www.cyclosm.org/legend.html', '_blank');
		},
		'Legend'
	).addTo(map);
});
