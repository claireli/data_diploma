<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="http://maps.googleapis.com/maps/api/js"></script>

<script src="claire.js"></script>


<style>
.mode_choice{
	
	border-radius: 25px;
	box-shadow: 5px 5px 5px #888888;
	width: 300px;
	height: 150px;
	padding: 10px;
	text-align: center;
	font-family: "Source Sans Pro";
	font-weight: 200;
	color: #3878c7;
	margin: 20px;
	align: center;
}

.mode_choice:hover{
	box-shadow: 5px 5px 5px #f59c1e;
}

#choice1{
	
	background-color: #b3d1ff;
}

#choice2{
	
	background-color: #e5efd4
}

#choice3{
	
	background-color: #c1d5a3;
}

#option_bar{
	
	margin: 0 auto;
}

.toggler{
	width: 100%;
	height: 55px;
	background-color: #cadfaa;
	padding: 10px;
	font-family: "Source Sans Pro";
	font-weight: bold;	
}

.toggler img{
	height: 45px;
	width: auto;
}
</style>
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
<td>Input Controller</td>
</tr></table>
</div>

<table id="option_bar">
<tr>
<td>
<a href="#step1"><div class="mode_choice" id="choice1">Mode One<p>Generate standard report on single location</div></a></td>
<td>
<a href="#step1"><div class="mode_choice" id="choice2">Mode Two<p>Generate cross comparison report on two locations</div></a></td>
<td>
<a href="#step1"><div class="mode_choice" id="choice3">Mode Three<p>Generate standard student profile<p>
<i>We'll retrieve the standard statistics for a student of your input type, along with generating a report of our analysis on the student's graduation probability.</i>
</div></a></td>
</tr>
</table>

<p id="step1">
<div id="mode1_message" class="toggler">Mode 1 selected. Please select location [Kent County selected]. Click here to continue.</div>
<div id="mode2_message" class="toggler">
<table><tr>
<td width="600px">Mode 2 selected. 
<p class="geo_selection">Please select location below.</p> 
</td><td><img src="clairrow.png" id="click_input">Click here to continue.</td></tr></table>
</div>

<div id="mode3_message" class="toggler">
<table><tr>
<td width="600px">Mode 3 selected. 
<p class="geo_selection">Please select location below.</p> 
</td><td><img src="clairrow.png" id="click_input3">Click here to continue.</td></tr></table>
</div>

<table id='container' width="100%" height='600px'><tr>

<td>
<div id="googleMap" style="width:100%;height:600px;"></div>
</td>

<td width='200px'><div class='frame'>
<?php
error_reporting(E_ALL);

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
$result_select = array_unique($states);

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
var chosen_location1=false;
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
				 chosen_location1=true;
				 console.log(chosen_location1);
				 // THIS IS WHERE YOU CHANGE THE MAP! !*!*!*!**!!*!*!*!*!// !*!*!*!! !*!*!*!**!!*!*!*!*!// !*!*!*!! !*!*!*!**!!*!*!*!*!// !*!*!*!! !*!*!*!**!!*!*!*!*!// !*!*!*!! !*!*!*!**!!*!*!*!*!// !*!*!*!! !*!*!*!**!!*!*!*!*!// !*!*!*!! !*!*!*!**!!*!*!*!*!// !*!*!*!
				   
				   var address = map_input;
				   
				   geocoder.geocode( { 'address': address}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							map.setCenter(results[0].geometry.location);
							var marker = new google.maps.Marker({
								map: map,
								position: results[0].geometry.location
							});
						}	 
						else {
							alert("Geocode was not successful for the following reason: " + status);
						}
	  
				   });
				   
				   var lato = new google.maps.LatLng(33.081224, -117.225205);
				 
				 
				 var marker = new google.maps.Marker({
					position: lato,
					map: map,
					title:"Hello World!"
				 });

				// To add the marker to the map, call setMap();
				marker.setMap(map);
				map.setCenter(marker.getPosition());
				 
				 $("#follow").remove();
				 
				 $( ".geo_selection" ).html( php_arr[state]["city"] + " in " + map_input + 
				 "<input type='hidden' name='geo_selection' value='" + php_arr[state]["city"] + "'> " 
				 + "<input type='hidden' name='geo_selection2' value='" +map_input+ "'>");
			}
		} 
	  }

}
</script>

<div id="remote_controller">
Input Controller Options<p>
Student Profile Graduation Predictability Report<br>
Geographic Comparison Mode<p>
<form method="POST" action="calculate2.php">
<table border='1' id="geo_option">
<tr>
<td>Geographic Location 1</td>
<td>Geographic Location 2</td></tr>

<tr>
<td>
<select name="state1">
<?php

foreach ($result_select as &$value) {
    echo "<option>";
	echo $value;
	echo "</option>";
	}

?>
</select>
 <p>

<select name="geo_compare1">
  <option value="volvo">Random city</option>
  <option value="saab">San Diego</option>
  <option value="mercedes">Austin</option>
  <option value="audi">Chicago</option>
</select>
</td>
<td>
<select name="state2">
 <?php

foreach ($result_select as &$value) {
    echo "<option>";
	echo $value;
	echo "</option>";
	}

?>
</select><p>

<select name="geo_compare2">
  <option value="volvo">Random city</option>
  <option value="saab">San Diego</option>
  <option value="mercedes">San Francisco</option>
  <option value="audi">Chicago</option>
</select>
</td></tr>

</table>
<p>
<input type="submit" value="Calculate Geographic Comparison"><p>
</form>
<a class='close_window'>(Close Window)</a>
</div>

<div id="overlay">

</div>

<div id="input_controller">


<form action="calculate.php" method="post">
<h1>Sample High School Student</h1>
<p>
<u>Geographic Selection</u>
<p class="geo_selection">
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
<p>
<a class='close_window'>(Close Window)</a>
</div>
</body>
</html>