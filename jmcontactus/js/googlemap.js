var geocoder;
var map;

function codeAddress() {
	
	geocoder = new google.maps.Geocoder();
	
	geocoder.geocode({
		'address': googlemap_address
	}, function (results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			var mapOptions = {
				zoom: googlemap_zoom,
				center: (results[0].geometry.location)
			}
			map = new google.maps.Map(document.getElementById('google-map'), mapOptions);
			var marker = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location
			});
		} else {
			alert('Geocode was not successful for the following reason: ' + status);
		}
	});
	
}

if (document.getElementById("google-map")) {
	google.maps.event.addDomListener(window, 'load', codeAddress);
	
	google.maps.event.addDomListener(window, "resize", function () {
		var center = map.getCenter();
		google.maps.event.trigger(map, "resize");
		map.setCenter(center);
	});
}

 