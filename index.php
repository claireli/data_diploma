<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="http://maps.googleapis.com/maps/api/js"></script>

<script>

var geocoder;
var map;
var address = "San Dieguito Union High";

function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);
  var myOptions = {
    zoom: 14,
    center: latlng,
    mapTypeControl: true,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
    },
    navigationControl: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById("googleMap"), myOptions);
  if (geocoder) {
    geocoder.geocode({
      'address': address
    }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
          map.setCenter(results[0].geometry.location);

          var infowindow = new google.maps.InfoWindow({
            content: '<b>' + address + '</b>',
            size: new google.maps.Size(150, 50)
          });

          var marker = new google.maps.Marker({
            position: results[0].geometry.location,
            map: map,
            title: address
          });
          google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
          });

        } else {
          alert("No results found");
        }
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
}
google.maps.event.addDomListener(window, 'load', initialize);
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
<table id='container' width="100%" height='600px'><tr>

<td>
<div id="googleMap" style="width:100%;height:600px;"></div>
</td>

<td width='200px'><div class='frame'>
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

$sql = "SELECT state FROM locations";
$result = $link->query($sql);

$states = array();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "STATE: " . $row["state"]. "<br>";
		
		array_push($states, $row["state"]);
    }
} else {
    echo "0 results";
}

$result = array_unique($states);

//print_r($result);

//var_dump($result);
$size = count($result);

echo "<table id='location_nav'>";

foreach ($result as &$value) {
    echo "<tr><td id='". $value ."' onClick='reply_click(this)'>". $value . "</td></tr>";
}

echo "</table></div>";

//RETRIEVE ALL STATES

$sql_states = "SELECT state, city, county FROM locations";
$result = $link->query($sql_states);

$newdata =  array (

    );

$x=0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "STATE: " . $row["state"]. " - LOCATION: " . $row["city"]. "<br>";
		$newdata[$x]['state'] = $row['state'];
		$newdata[$x]['city'] = $row['city'];
		$newdata[$x]['county'] = $row['county'];
		
		$x++;
    }
} else {
    echo "0 results";
}

//var_dump($newdata);

//echo $jsonformat=json_encode($newdata);

mysqli_close($link);

?>
</td><td id="city_container" width='200px'></td></tr></table>
<script>

var php_arr = <?php echo json_encode($newdata); ?>;

function retrieve_cities(retrieved_state){
	$( "#city_container" ).empty();
	
	var full_append="<div class='frame'><table id='city_nav'>";
	
	console.log(php_arr);
	var result="";
	//var fill_in_state="California";
	var fill_in_state=retrieved_state;
	
	for (var state in php_arr) {
		
		if( php_arr.hasOwnProperty(state) ) {
			
			if(JSON.stringify(php_arr[state]["state"])=='"'+ fill_in_state +'"'){
			//console.log(JSON.stringify(php_arr[state]["state"]) + " - " + JSON.stringify(php_arr[state]["city"]));
			console.log(JSON.stringify(php_arr[state]["city"]));
			
			var cleanup = (JSON.stringify(php_arr[state]["city"]).replace("\"", "" )).replace("\"", "" );
				var format = "<tr><td onClick='grab_address(this)' id='" + cleanup + "'>" + cleanup + "</td></tr>"
				full_append+=format;
				
				console.log(JSON.stringify(php_arr[state]["county"]));
				 
			}
		} 
	  }
	  full_append+="</table></div>";
	  $("#city_container").append(full_append);

	console.log(result);  
}


document.getElementById("location_nav").onclick = function(e) {
    e = e || event
var target = e.target || e.srcElement
// variable target has your clicked element
    innerId = target.id;
    //  do your stuff here. 
	content = document.getElementById("location_nav").innerHTML;
    //alert(content);

}

function reply_click(obj)
{
var id = obj.id;
//alert(id);

retrieve_cities(id);

}

function grab_address(obj)
{
var id = obj.id;
//alert(id);
//console.log(id);


		for (var state in php_arr) {
		
		if( php_arr.hasOwnProperty(state) ) {
			
			if(JSON.stringify(php_arr[state]["city"])=='"'+ id +'"'){
				
				var map_input = (JSON.stringify(php_arr[state]["county"]).replace("\"", "" )).replace("\"", "" );
				console.log(map_input);
				 alert("GEOCODING: " + map_input);	
				 
				 $( "#geo_selection" ).html( php_arr[state]["city"] + " in " + map_input + 
				 "<input type='hidden' name='geo_selection' value='" + php_arr[state]["city"] + "'> " 
				 + "<input type='hidden' name='geo_selection2' value='" +map_input+ "'>");
			}
		} 
	  }

}
</script>
<div id="input_controller">


<form action="calculate.php" method="post">
<h1>Sample High School Student</h1>
<p>
<u>Geographic Selection</u>
<p id="geo_selection">
hello world</p>
<table id="control_content"><tr><td>
Income Range</td><td>

<select name="income_range">
  <option value="income1">Below $50,000</option>
  <option value="income2">$50,000 to $80,000</option>
  <option value="income3">$80,000 to $150,000</option>
  <option value="income4">Above $200,000</option>
</select></td></tr>

<tr>
<td>Gender</td><td>
<select name="gender">
  <option value="Female" name="female">Female</option>
  <option value="Male" name="male">Male</option>
  </select>
</td>
</tr>

<tr><td>Ethnicity</td>

<td>
<select name="ethnicity">
  <option value="White">White</option>
  <option value="Black or African American">Black or African American</option>
  <option value="American Indian or Alaskan Native">American Indian or Alaskan Native</option>
  <option value="Asian">Asian</option>
  <option value="Hawaiian Native or Pacific Islander">Hawaiian Native or Pacific Islander</option>
  <option value="Hispanic or Latino">Hispanic or Latino</option>
</select>
</td></tr>

<tr>
<td>English</td><td><select name="esl">
  <option value="English as primary language">English as primary language</option>
  <option value="English as secondary language">English as secondary language</option>
</select></td>
</tr>
</table>
<p>

<input type="submit" value="Calculate Statistics & Graduation Likelihood">
</form>
</div>
</body>
</html>