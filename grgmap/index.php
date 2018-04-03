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

#map_ov{
    width: 600px;
	height: 350px;
}

#map_zm{
    width: 600px;
	height: 350px;
}

#bar{
	height: 10px;
}

</style>

</head>
<body>

<div id="container">

	<div id="side">
	</div>
	<div id="main">
		<div id="map_ov"></div>
		<input id="pac-input" class="controls" type="text" placeholder="Search Box" />
		<div id="bar"></div>
		<div id="map_zm"></div>
	</div>

</div>

<script>
var map_ov;
var map_zm;
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

	map_ov = new google.maps.Map(document.getElementById('map_ov'), {
		center: {
			lat: 35.47131841901187,
			lng: 139.4283853703149
		},
		zoom: 17
	});
	behaviorSearchBox(map_ov);

/*
	// change a color to grayscale
	var mapStyle = [{
		"stylers": [
			{"saturation": -100}
		]
	}];
	var mapType = new google.maps.StyledMapType(mapStyle);
	map_ov.mapTypes.set('GrayScaleMap', mapType);
	map_ov.setMapTypeId('GrayScaleMap');
*/

	dServ = new google.maps.DirectionsService(); 
	dRend = new google.maps.DirectionsRenderer({
		map: map_ov,
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
		map: map_ov ,
		position: map_ov.getCenter() ,
		draggable: true ,
		label: {
			text: "宅",
			color: "#FFFFFF",
		}
	});

	var markerGrge = new google.maps.Marker( {
		map: map_ov ,
		position: map_ov.getCenter() ,
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

	//----------
	// 2nd map
	//----------
	map_zm = new google.maps.Map(document.getElementById('map_zm'), {
		center: {
			lat: 35.47131841901187,
			lng: 139.4283853703149
		},
		zoom: 17
	});

	var drawingManager = new google.maps.drawing.DrawingManager({
		drawingMode: google.maps.drawing.OverlayType.PAN,
		drawingControl: true,                            
		drawingControlOptions: {
			position: google.maps.ControlPosition.TOP_CENTER, 
			drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
//			drawingModes: ['circle']
		},
/*
		markerOptions: {
			icon: {
				url: '../common/img/ms/pin_02.png',
				scaledSize: new google.maps.Size(40, 40)
			}
		},
*/
		circleOptions: {
			clickable: false,
			editable: true,
			zIndex: 1
		},
		polygonOptions: {
//			fillColor: '#ff00ff',
//			fillOpacity: 1,
//			strokeWeight: 5,
			clickable: false,
			editable: true,
			zIndex: 1
		},
/*
	rectangleOptions: {
		fillColor: '#0000ff',
		fillOpacity: 1,
		strokeWeight: 5,
		clickable: true,
		editable: true,
		zIndex: 1
	},
	polylineOptions: {
		strokeColor: '#ff0000',
		strokeWeight: 5,
		clickable: false,
		editable: true,
		zIndex: 1
	}
*/
	});
	drawingManager.setMap(map_zm);




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

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap&key=<?php echo $gmapapikey1; ?>&libraries=drawing,places"></script>

</body>
</body>
</html>
