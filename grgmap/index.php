<?php

	$gmapapikey1 = "AIzaSyBCYBPbwRyLV_urAoagNVlNn2T3BHspQW4";
	$gmapapikey2 = "AIzaSyA4HVXvKb46fRnUJw4ncwzJlE4VjDULQ2k";
?>
<html>
<head>
<link href="../css/grgmap.css" rel="stylesheet"></link>
<link href="../css/searchbox.css" rel="stylesheet"></link>
<script type="text/javascript" src="../js/searchbox.js"></script>

<style>

#container{
    display: flex;
}
#side{
    width: 300px;
	height: 100%;
	overflow: auto;
}
#main{
	flex: 1;
	height: 100%;
}

#map{
    width: 100%;
	height: 100%;
}

</style>

</head>
<body>

<div id="container">

	<div id="side">
	</div>
	<div id="main">
		<div id="map"></div>
		<input id="pac-input" class="controls" type="text" placeholder="Search Box" />
	</div>

</div>

<script>
var map;
var markerHome;
var markerGrge;
var dServ; 
var dRend;
function initMap() {

/*
if (navigator.geolocation) {
	navigator.geolocation.getCurrentPosition(
		function(position) {
			var mapLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		}
	)
}
*/


	map = new google.maps.Map(document.getElementById('map'), {
/*
		center: {
			lat: 35.47131841901187,
			lng: 139.4283853703149
		},
*/
		zoom: 17
	});
	behaviorSearchBox(map);

/*
	// change a color to grayscale
	var mapStyle = [{
		"stylers": [
			{"saturation": -100}
		]
	}];
	var mapType = new google.maps.StyledMapType(mapStyle);
	map.mapTypes.set('GrayScaleMap', mapType);
	map.setMapTypeId('GrayScaleMap');
*/

	dServ = new google.maps.DirectionsService(); 
	dRend = new google.maps.DirectionsRenderer({
		map: map,
		preserveViewport: true,
		draggable: true,
		suppressMarkers: true,
		polylineOptions: {
			strokeWeight: 7,
			strokeColor: "black",
			strokeOpacity: 0.6,
		}
	});

	var markerHome = new google.maps.Marker( {
		map: map ,
		position: map.getCenter() ,
		draggable: true ,
		label: {
			text: "宅",
			color: "#FFFFFF",
		}
	});

	var markerGrge = new google.maps.Marker( {
		map: map ,
		position: map.getCenter() ,
		draggable: true ,
		label: {
			text: "駐",
			color: "#FFFFFF",
		}
//		icon: 'https://maps.google.com/mapfiles/kml/shapes/cabs.png',
//		icon: 'https://maps.google.com/mapfiles/kml/shapes/parking_lot.png',
//		icon: 'http://maps.google.com/mapfiles/kml/pal4/icon15.png',
	});

	markerHome.addListener("dragend", function(arg) {
		consoleMarkerPos(arg);
		render(markerHome, markerGrge);
	});
	markerGrge.addListener("dragend", function(arg) {
		consoleMarkerPos(arg);
		render(markerHome, markerGrge);
	});

}

function consoleMarkerPos(argument) {
	try{
		argument = typeof argument == "object" ? JSON.stringify( argument ) : argument;
	}catch(e){}
	console.log(argument) ;
}

function render(markerHome, markerGrge) {
	var request = {
		origin: markerHome.getPosition(),
		destination: markerGrge.getPosition(),
		travelMode: google.maps.DirectionsTravelMode.WALKING,
	};
	
	dServ.route(request, function(result, status){
		if (status == google.maps.DirectionsStatus.OK) {
			dRend.setDirections(result);
		}
	});
}

</script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap&key=<?php echo $gmapapikey1; ?>"></script>

</body>
</body>
</html>
