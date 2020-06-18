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

	var lon = 18.64542;
	var lat = 54.34766;
	var zoom = 10;

	new ol.Map({
		target: 'map-section',
		layers: [
			new ol.layer.Tile({
				source: new ol.source.OSM({
					url: "https://tile.thunderforest.com/cycle/{z}/{x}/{y}.png?apikey=09c24ee614e44efaa63ca9b4bee54a99"
				})
			})
		],
		view: new ol.View({
			center: ol.proj.fromLonLat([lon, lat]),
			zoom: zoom
		})
	});
});
