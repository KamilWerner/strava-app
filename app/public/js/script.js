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

	const map = L.map('map-section', {
		zoomControl: true,
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
		'CyclOSM Lite': cyclosmLite
	};

	L.control.layers(baseMaps, overlayMaps).addTo(map);
});
