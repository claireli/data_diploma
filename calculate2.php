<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="style.css">

<style>
#map_wrapper {
    height: 400px;
}

#map_canvas {
    width: 100%;
    height: 100%;
}
</style>
<link href="//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css" rel="stylesheet" data-semver="3.0.1" data-require="normalize@*" />
<script>
jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
});

function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);
        
    // Multiple Markers
	
	var lat=51.503454;
    var lon=-0.119562;
	var markers = [
	['San Diego', lat, lon],
        ['San Francisco', 51.499633,-0.124755]
		//['London Eye, London', 51.503454,-0.119562],
        //['Palace of Westminster, London', 51.499633,-0.124755]
    ];
                        
    // Info Window Content
    var infoWindowContent = [
        ['<div class="info_content">' +
        '<h3>London Eye</h3>' +
        '<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' +        '</div>'],
        ['<div class="info_content">' +
        '<h3>Palace of Westminster</h3>' +
        '<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
        '</div>']
    ];
        
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(14);
        google.maps.event.removeListener(boundsListener);
    });
    
}

</script>
  </head>

  <body>
  <div id="header">
<h1><a href="index.php">High School Graduation Rate, Data Analysis Tool</a></h1>
</div>
<div id="navigation_bar">
<table><tr>
<td><a href="index.php">Home</a></td>
<td><a href="#">How To Use This Tool</a></td>
<td><a href="case.html">Our Case Study & Analysis</a></td>
<td><a href="about.html">About The Developers</a></td>
<td><a href="#">Input Controller</a></td>
</tr></table>
</div>
  <div id="content">
  <p>
<h2>Graduation Prediction Report</h2><p>


<?php

	//echo "test";
	
	$link = mysqli_connect("localhost", "root", "", "diploma");
	if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

//echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
//echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;


echo $_POST["geo_compare1"];
echo $_POST['geo_compare2'];


$sql = "SELECT * FROM locations WHERE city='".$city."' AND county='".$county."'";
$result = $link->query($sql);
$percent = 0;

$all_cohort =0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<p><i>" .$row["ALL_RATE"]. "% of a cohort size of " . $row["ALL_COHORT"]. " from the district of " . $city ." in " . $row["State"] ." graduated in 2014.</i><br>";
		$percent = $row["ALL_RATE"];
		$all_cohort = $row["ALL_COHORT"];
	}
} else {
    echo "0 results";
}

$remainder=100-$percent;

echo "<div id='googleMap' style='width:100%;height:600px;'></div>";

?>
<div id="map_wrapper">
    <div id="map_canvas" class="mapping" style='width:100%;height:600px;'></div>
</div>