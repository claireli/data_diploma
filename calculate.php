<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="http://maps.googleapis.com/maps/api/js"></script>

<script>
$( document ).ready(function() {
    $( ".chartbox" ).hide();
	
	$( "#select_native" ).click(function() {
		$( ".chartbox" ).fadeOut( "slow" );
		$( "#chartbox_native" ).fadeToggle( "slow", "linear" );
	});
	
	$( "#select_asian" ).click(function() {
		$( ".chartbox" ).fadeOut( "slow" );
		$( "#chartbox_asian" ).fadeToggle( "slow", "linear" );
	});
	
	$( "#select_black" ).click(function() {
		$( ".chartbox" ).fadeOut( "slow" );
		$( "#chartbox_black" ).fadeToggle( "slow", "linear" );
	});
	
		$( "#select_hispanic" ).click(function() {
		$( ".chartbox" ).fadeOut( "slow" );
		$( "#chartbox_hispanic" ).fadeToggle( "slow", "linear" );
	});
	
	$( "#select_esl" ).click(function() {
		$( ".chartbox" ).fadeOut( "slow" );
		$( "#chartbox_esl" ).fadeToggle( "slow", "linear" );
	});
	
	$( "#select_econ" ).click(function() {
		$( ".chartbox" ).fadeOut( "slow" );
		$( "#chartbox_econ" ).fadeToggle( "slow", "linear" );
	});
	
		$( "#select_white" ).click(function() {
		$( ".chartbox" ).fadeOut( "slow" );
		$( "#chartbox_white" ).fadeToggle( "slow", "linear" );
	});
	
});

</script>

<link href="//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css" rel="stylesheet" data-semver="3.0.1" data-require="normalize@*" />
    <style>
		body{
			
			overflow-x: hidden;
		}
      .legend {                                                   /* NEW */
        font-size: 12px;                                          /* NEW */
      }                                                           /* NEW */
      rect {                                                      /* NEW */
        stroke-width: 2;                                          /* NEW */
      }                                                           /* NEW */
    
		#chart{
			text-align: center;
			position: relative;

		}
		
		#content{
			text-align: center;
			position: relative;
			top: 10px;
			left: 0px;
		}
		
		.select_pie:hover{
			background-color: #ddffcc;
			font-weight: bold;
		}
		
		#proceed{
	
	border : solid 2px #ffffff;
	border-radius : 3px;
	moz-border-radius : 3px;
	font-size : 20px;
	color : #ffffff;
	padding : 1px 17px;
	background-color : #0a66c9;
	width: 400px;
	height: 50px;
	border-radius: 25px;

	
}

#proceed:hover{
	
	background-color: #85CBFF;
	box-shadow: 5px 5px 5px #f59c1e;
}

.data_table{
	
	font-size: 12px;
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
<td><a href="howto.html">How To Use This Tool</a></td>
<td><a href="case.html">Our Case Study & Analysis</a></td>
<td><a href="about.html">About The Developers</a></td>
</tr></table>
</div>
  <div id="content">
  <p>
<h2>Historic Graduation Report 2014</h2><p>


<?php
	
	//echo "test";
	
	$link = mysqli_connect("localhost", "root", "claire", "diploma");
	if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$city = $_POST["geo_selection"];

$county = $_POST["geo_selection2"];

$state = $_POST["geo_selection3"];

echo "<h4>";
echo $city.", in ".$county.", ".$state;
echo "</h4>";
//var_dump($state);
//var_dump($city);
//var_dump($county);


$sql = "SELECT * FROM locations WHERE city='".$city."' AND county='".$county."'";
$sql2 = "SELECT * FROM grad WHERE leanm11='".$city."' AND STNAM='".$state."'";
$retrieve_posterior="SELECT
 sum( ifnull( ((1-MAM_RATE_1112/100)*MAM_COHORT_1112), 0) )/sum( ifnull( ((1-ALL_RATE_1112/100)*ALL_COHORT_1112), 0) ) MAM,
 sum( ifnull( ((1-MAS_RATE_1112/100)*MAS_COHORT_1112), 0) )/sum( ifnull( ((1-ALL_RATE_1112/100)*ALL_COHORT_1112), 0) ) MAS,
sum( ifnull( ((1-MBL_RATE_1112/100)*MBL_COHORT_1112), 0) )/sum( ifnull( ((1-ALL_RATE_1112/100)*ALL_COHORT_1112), 0) ) MBL,
sum( ifnull( ((1-MHI_RATE_1112/100)*MHI_COHORT_1112), 0) )/sum( ifnull( ((1-ALL_RATE_1112/100)*ALL_COHORT_1112), 0) ) MHI,
sum( ifnull( ((1-MTR_RATE_1112/100)*MTR_COHORT_1112), 0) )/sum( ifnull( ((1-ALL_RATE_1112/100)*ALL_COHORT_1112), 0) ) MTR,
sum( ifnull( ((1-MWH_RATE_1112/100)*MWH_COHORT_1112), 0) )/sum( ifnull( ((1-ALL_RATE_1112/100)*ALL_COHORT_1112), 0) ) MWH,
sum( ifnull( ((1-CWD_RATE_1112/100)*CWD_COHORT_1112), 0) )/sum( ifnull( ((1-ALL_RATE_1112/100)*ALL_COHORT_1112), 0) ) CWD,
sum( ifnull( ((1-ECD_RATE_1112/100)*ECD_COHORT_1112), 0) )/sum( ifnull( ((1-ALL_RATE_1112/100)*ALL_COHORT_1112), 0) ) ECD,
sum( ifnull( ((1-LEP_RATE_1112/100)*LEP_COHORT_1112), 0) )/sum( ifnull( ((1-ALL_RATE_1112/100)*ALL_COHORT_1112), 0) ) LEP
 FROM grad where STNAM ='".$state."' AND leanm11='".$city."'";

$result = $link->query($sql);
$result2 = $link->query($sql2);
$result3 = $link->query($retrieve_posterior);

$percent = 0;

$all_cohort =0;

/*if($native==NULL){
	$native="Data Unavailable";
}
if($hispanic==NULL){
	$hispanic="Data Unavailable";
}
if($asian==NULL){
	$asian="Data Unavailable";
}
if($black==NULL){
	$black="Data Unavailable";
}
if($white==NULL){
	$white="Data Unavailable";
}
if($econ_dis==NULL){
	$econ_dis="Data Unavailable";
}
if($esl==NULL){
	$esl="Data Unavailable";
}*/

if ($result2->num_rows > 0) {
    // output data of each row
    while($row = $result2->fetch_assoc()) {

$a=array();

$native=$row["MAM_RATE_1112"];
$hispanic=$row["MHI_RATE_1112"];
$asian=$row["MAS_RATE_1112"];
$black=$row["MBL_RATE_1112"];
$white=$row["MWH_RATE_1112"];
$econ_dis=$row["ECD_RATE_1112"];
$esl=$row["LEP_RATE_1112"];


function doublemax($mylist){ 
  $maxvalue=max($mylist); 
  while(list($key,$value)=each($mylist)){ 
    if($value==$maxvalue)$maxindex=$key; 
  } 
  return array("m"=>$maxvalue,"i"=>$maxindex); 
} 

array_push($a, $native, $hispanic, $asian, $black, $white, $econ_dis, $esl);
//print_r($b);	
//echo max($a);

$new_arr=doublemax($a);

//print_r($new_arr);
//echo $new_arr["i"];

$highest_cohort_index=$new_arr["i"];

//echo $highest_cohort_index;
$max_cohort_label="";
if($highest_cohort_index==0){
	$max_cohort_label="MAM_RATE_1112";
}
else if($highest_cohort_index==1){
	$max_cohort_label="MAS_RATE_1112";
}
else if($highest_cohort_index==2){
	$max_cohort_label="MBL_RATE_1112";
}
else if($highest_cohort_index==3){
	$max_cohort_label="MHI_RATE_1112";
}
else if($highest_cohort_index==4){
	$max_cohort_label="MTR_RATE_1112";
}
else if($highest_cohort_index==5){
	$max_cohort_label="MWH_RATE_1112";
}
else if($highest_cohort_index==6){
	$max_cohort_label="CWD_RATE_1112";
}
else if($highest_cohort_index==7){
	$max_cohort_label="ECD_RATE_1112";
}
else if($highest_cohort_index==8){
	$max_cohort_label="LEP_RATE_1112";
}

//echo $max_cohort_label;
echo "<i>Select any of the options in the table below.</i><br>";
echo "<table id='sample_profile'><tr><td colspan='2'><h3>District Breakdown in 2014</h3></td></tr>";
if($native!=NULL){
	echo "<tr><td  class='select_pie' id='select_native'>Percentage of Native Americans students graduated within 4 years</td><td>". $native."%</td></tr>";
}

if($hispanic!=NULL){
	echo "<tr><td class='select_pie' id='select_hispanic'>Percentage of Hispanic students graduated within 4 years</td><td>". $hispanic."%</td></tr>";
}

if($asian!=NULL){
	echo "<tr><td class='select_pie' id='select_asian'>Percentage of Asian & Pacific Islander students graduated within 4 years</td><td>".$asian."%</td></tr>";
}
if($black!=NULL){
	echo "<tr><td class='select_pie' id='select_black'>Percentage of Black students graduated within 4 years</td><td>". $black."%</td></tr>";
}
if($white!=NULL){
	echo "<tr><td class='select_pie' id='select_white'>Percentage of White students graduated within 4 years</td><td>". $white."%</td></tr>";
}
if($econ_dis!=NULL){
	echo "<tr><td class='select_pie' id='select_econ'>Percentage of economically disadvantaged students graduated within 4 years</td><td>". $econ_dis."%</td></tr>";
}
if($esl!=NULL){
	echo "<tr><td class='select_pie' id='select_esl'>Percentage of limited English proficiency students graduated within 4 years</td><td>". $esl."%</td></tr>";
}

echo "</table>";
	}
}
/*
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
		echo "<p><h3><i>" .$row["ALL_RATE"]. "% of a cohort size of " . $row["ALL_COHORT"]. " from the district of " . $city ." in " . $row["State"] ." graduated in 2014.</h3></i><br>";
		$percent = $row["ALL_RATE"];
		$all_cohort = $row["ALL_COHORT"];
	}
} else {
    echo "0 results";
}*/

$remainder=100-$percent;

?>

 
 <script>
	  //2 = native
	  //3 = hispanic
	  //4 = asian
	  //5 = black
	  //6 = white
	  //7 = economically disadvantaged
	  //8 = limited english
function open_pie(selected_pie){
	console.log(selected_pie);
	//$( "#show_pie" ).html( "<div id='chart3' class='cohort_pie'></div>" );
	//$(".cohort_pie").hide();
	if(selected_pie=="select_hispanic"){
	$(".cohort_pie").empty();
	$("#chart3").show();
	}
	if(selected_pie=="select_asian"){
		$("#chart4").show();
	}
	if(selected_pie=="select_black"){
	$("#chart5").show();
	}
	if(selected_pie=="select_white"){
		$("#chart6").show();
	}
	if(selected_pie=="select_econ"){
	$("#chart7").show();
	}
	if(selected_pie=="select_esl"){
		$("#chart8").show();
	}
}
 
 $( document ).ready(function() {
    $(".select_pie").click(function(event) {
        
		var selected_pie=event.target.id;
		//console.log(selected_pie);	
		//open_pie(selected_pie);
		$("chart_box1").toggle();
    });
 $('.fraction').each(function(key, value) {
    $this = $(this)
	console.log($this);
    var split = $this.html().split("/")
    if( split.length == 2 ){
        $this.html('<span class="top">'+split[0]+'</span><span class="bottom">'+split[1]+'</span>')
    }    
});

 });
</script>
 <p><br>
 <h2>
 <br>
 <p>
 
 <table id="chart_container" align="center"><tr>
 <td>
 <?php
 
 if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
		echo "<p><h3><i>" .$row["ALL_RATE"]. "% of a cohort size of " . $row["ALL_COHORT"]. " from the district of " . $city ." in " . $row["State"] ." graduated in 2014.</h3></i><br>";
		$percent = $row["ALL_RATE"];
		$all_cohort = $row["ALL_COHORT"];
	}
} else {
    echo "0 results";
}
 
 ?>
 </td><td><i>Select any cohort above</i></td></tr>
 <tr>
 <td><div id="chart"></div></td>
 
 <!--<td>
 <table border='1'>
<tr><td><b>Average Graduation Rate</b></td><td></td></tr>
<tr><td><b>Variance</b></td><td></td></tr>
<tr><td><b>1 Standard Deviation</b></td><td></td></tr>
</table>
 </td>-->
 
 <td id="show_pie">
 
 <!--
 	  //2 = native
	  //3 = hispanic
	  //4 = asian
	  //5 = black
	  //6 = white
	  //7 = economically disadvantaged
	  //8 = limited english
 
 -->
 <div id="chartbox_native" class="chartbox"><div id="chart2" class="cohort_pie"></div></div>
 <div id="chartbox_hispanic" class="chartbox"><div id="chart3" class="cohort_pie"></div></div>
 <div id="chartbox_asian" class="chartbox"><div id="chart4" class="cohort_pie"></div></div>
<div id="chartbox_black" class="chartbox"> <div id="chart5" class="cohort_pie"></div></div>
<div id="chartbox_white" class="chartbox"> <div id="chart6" class="cohort_pie"></div></div>
 <div id="chartbox_econ" class="chartbox"><div id="chart7" class="cohort_pie"></div></div>
 <div id="chartbox_esl" class="chartbox"><div id="chart8" class="cohort_pie"></div></div>
 </div>
 </td></tr></table><p>
 
 <p>
 <h2>At Risk Rankings</h2>
 <p><i>This is the prediction for the cohort fail rate for 2015, based off census data collected from the previous year regarding the district of <?php echo $_POST["geo_selection"] ?></i><p>
 <span class="fraction">cohort*(1-cohort_rate)/ALL*(1-all_rate)</span> =
 
 <span class="fraction">
 <?php 
	$cohort=$all_cohort*($percent*0.01);
	$fail_rate=$cohort * (1- ($percent * 0.01));
	$fail_rate=$fail_rate/ 	($all_cohort*(1- ($percent * 0.01)));
 echo $cohort."*(1 - 0.". $percent . ") "?>/
 <?php echo $all_cohort."*(1 - 0.". $percent . ")" ?></span> = <span class="calc_result"><?php echo $fail_rate ?></span><p>
 
 <!--<i>Explanation for at risk ranking blah blah stuff asldkfjas;lkdfjsldkjf </i>--><p>
 

<p>
<br><br>

<hr>
<p>
<!--
<iframe src="http://104.236.169.169:3838/app3/" style="border: 1px solid #AAA; width: 100%; height: 1060px"></iframe>
-->


<p>


<table class="data_table"><tr><td>
We have determined the ranking of cohorts that we consider at greatest risk of failure for the location of <b><?php echo $city.", in ".$county.", ".$state; ?></b>.<p>
  <p>
 
Using our analysis tool, you can discover <b>which variables have the most predictive power</b> in determining
a given cohort's future graduation rate. Our application will assist you in determining the yearly improvement required by the cohort to reach an overall 90% graduation rate by 2020, by 
figuring out which actionable variables can improve that cohort's graduation rate.
 <p>
We advise to seek actionable variables for the cohort of:<br>  
<b><?php 
echo $max_cohort_label;
?></b>

and to begin with the following inputs:
<div align="center">
<table border="1" width="60%">
<tr><td>Rate</td>
<td>State</td></tr>

<tr><td><?php 
echo $max_cohort_label;
?></td>
<td><?php echo $state ?></td></tr>

</table>
</div>
<p>
<form action="http://104.236.169.169:3838/app3/">
<input type="submit" value="Proceed to Graduation Cohort Analysis" id="proceed" target="_blank">
</form>
</td>
<td>

<table class="results_table">
<?php

$results_arr = array();

if ($result3->num_rows > 0) {
    // output data of each row
    while($row3 = $result3->fetch_assoc()) {
		//var_dump($row3);
		$results_arr[] = $row3;
		
		if($row3["MAM"]!=0){
			echo "<tr><td>MAM</td><td>".$row3["MAM"]."</td></tr>";
		}
		else{
			echo "<tr><td>MAM</td><td><i>Data not available</i></td></tr>";
		}
		
		if($row3["MAS"]!=0){
			echo "<tr><td>MAS</td><td>".$row3["MAS"]."</td></tr>";
		}
				else{
			echo "<tr><td>MAS</td><td><i>Data not available</i></td></tr>";
		}
		
		if($row3["MBL"]!=0){
			echo "<tr><td>MBL</td><td>".$row3["MBL"]."</td></tr>";
		}
				else{
			echo "<tr><td>MBL</td><td><i>Data not available</i></td></tr>";
		}
		
				if($row3["MHI"]!=0){
			echo "<tr><td>MHI</td><td>".$row3["MHI"]."</td></tr>";
		}
		else{
			echo "<tr><td>MHI</td><td><i>Data not available</i></td></tr>";
		}
		
		if($row3["MTR"]!=0){
			echo "<tr><td>MTR</td><td>".$row3["MTR"]."</td></tr>";
		}
				else{
			echo "<tr><td>MTR</td><td><i>Data not available</i></td></tr>";
		}
		
		if($row3["MWH"]!=0){
			echo "<tr><td>MWH</td><td>".$row3["MWH"]."</td></tr>";
		}
				else{
			echo "<tr><td>MWH</td><td><i>Data not available</i></td></tr>";
		}
		
				if($row3["CWD"]!=0){
			echo "<tr><td>CWD</td><td>".$row3["CWD"]."</td></tr>";
		}
		else{
			echo "<tr><td>CWD</td><td><i>Data not available</i></td></tr>";
		}
		
		if($row3["ECD"]!=0){
			echo "<tr><td>ECD</td><td>".$row3["ECD"]."</td></tr>";
		}
				else{
			echo "<tr><td>ECD</td><td><i>Data not available</i></td></tr>";
		}
		
		if($row3["LEP"]!=0){
			echo "<tr><td>LEP</td><td>".$row3["LEP"]."</td></tr>";
		}
				else{
			echo "<tr><td>LEP</td><td><i>Data not available</i></td></tr>";
		}
		
		
		/*echo $row3["MAM"]."<br>";
		echo $row3["MAS"]."<br>";
		echo $row3["MBL"]."<br>";
		echo $row3["MHI"]."<br>";
		echo $row3["MTR"]."<br>";
		echo $row3["MWH"]."<br>";
		echo $row3["CWD"]."<br>";
		echo $row3["ECD"]."<br>";
		echo $row3["LEP"]."<br>";
		*/
		echo "<br>";
	}
		
}

?>

</table>


</td>
</tr></table>
</div>




    <script data-require="d3@*" data-semver="3.4.6" src="//cdnjs.cloudflare.com/ajax/libs/d3/3.4.6/d3.min.js"></script>
    <script>
      (function(d3) {
        'use strict';

        var dataset = [
          { label: 'Successfully Graduated', count: <?php echo $percent ?> }, 
          { label: 'Did Not Graduate', count: <?php echo $remainder ?> },
        ];

        var width = 360;
        var height = 360;
        var radius = Math.min(width, height) / 2;
        var donutWidth = 45;
        var legendRectSize = 18;                                  // NEW
        var legendSpacing = 3;                                    // NEW

        var color = d3.scale.category20c();

        var svg = d3.select('#chart')
          .append('svg')
          .attr('width', width)
          .attr('height', height)
          .append('g')
          .attr('transform', 'translate(' + (width / 2) + 
            ',' + (height / 2) + ')');

        var arc = d3.svg.arc()
          .innerRadius(radius - donutWidth)
          .outerRadius(radius);

        var pie = d3.layout.pie()
          .value(function(d) { return d.count; })
          .sort(null);

        var path = svg.selectAll('path')
          .data(pie(dataset))
          .enter()
          .append('path')
          .attr('d', arc)
          .attr('fill', function(d, i) { 
            return color(d.data.label);
          });

        var legend = svg.selectAll('.legend')                     // NEW
          .data(color.domain())                                   // NEW
          .enter()                                                // NEW
          .append('g')                                            // NEW
          .attr('class', 'legend')                                // NEW
          .attr('transform', function(d, i) {                     // NEW
            var height = legendRectSize + legendSpacing;          // NEW
            var offset =  height * color.domain().length / 2;     // NEW
            var horz = -4 * legendRectSize;                       // NEW
            var vert = i * height - offset;                       // NEW
            return 'translate(' + horz + ',' + vert + ')';        // NEW
          });                                                     // NEW

        legend.append('rect')                                     // NEW
          .attr('width', legendRectSize)                          // NEW
          .attr('height', legendRectSize)                         // NEW
          .style('fill', color)                                   // NEW
          .style('stroke', color);                                // NEW
          
        legend.append('text')                                     // NEW
          .attr('x', legendRectSize + legendSpacing)              // NEW
          .attr('y', legendRectSize - legendSpacing)              // NEW
          .text(function(d) { return d; });                       // NEW

      })(window.d3);
	  
	  
	function create_chart(rate, total, chart_id){
				  
				  (function(d3) {
					'use strict';

					var dataset = [
					  { label: 'Successfully Graduated', count: rate }, 
					  { label: 'Did Not Graduate', count: total },
					];

					var width = 360;
					var height = 360;
					var radius = Math.min(width, height) / 2;
					var donutWidth = 45;
					var legendRectSize = 18;                                  // NEW
					var legendSpacing = 3;                                    // NEW

					var color = d3.scale.category20b();
					//var color = d3.rgb(12, 67, 199);
					
					var svg = d3.select("#"+chart_id)
					  .append('svg')
					  .attr('width', width)
					  .attr('height', height)
					  .append('g')
					  .attr('transform', 'translate(' + (width / 2) + 
						',' + (height / 2) + ')');

					var arc = d3.svg.arc()
					  .innerRadius(radius - donutWidth)
					  .outerRadius(radius);

					var pie = d3.layout.pie()
					  .value(function(d) { return d.count; })
					  .sort(null);

					var path = svg.selectAll('path')
					  .data(pie(dataset))
					  .enter()
					  .append('path')
					  .attr('d', arc)
					  .attr('fill', function(d, i) { 
						return color(d.data.label);
					  });

					var legend = svg.selectAll('.legend')                     // NEW
					  .data(color.domain())                                   // NEW
					  .enter()                                                // NEW
					  .append('g')                                            // NEW
					  .attr('class', 'legend')                                // NEW
					  .attr('transform', function(d, i) {                     // NEW
						var height = legendRectSize + legendSpacing;          // NEW
						var offset =  height * color.domain().length / 2;     // NEW
						var horz = -4 * legendRectSize;                       // NEW
						var vert = i * height - offset;                       // NEW
						return 'translate(' + horz + ',' + vert + ')';        // NEW
					  });                                                     // NEW

					legend.append('rect')                                     // NEW
					  .attr('width', legendRectSize)                          // NEW
					  .attr('height', legendRectSize)                         // NEW
					  .style('fill', color)                                   // NEW
					  .style('stroke', color);                                // NEW
					  
					legend.append('text')                                     // NEW
					  .attr('x', legendRectSize + legendSpacing)              // NEW
					  .attr('y', legendRectSize - legendSpacing)              // NEW
					  .text(function(d) { return d; });                       // NEW

				  })(window.d3);
	  
	  };
	  
	  //2 = native
	  //3 = hispanic
	  //4 = asian
	  //5 = black
	  //6 = white
	  //7 = economically disadvantaged
	  //8 = limited english
	  var native = "<?php echo $native; ?>";
	  var hispanic = "<?php echo $hispanic; ?>";
	  var asian = "<?php echo $asian; ?>";
	  var black = "<?php echo $black; ?>";
	  var white = "<?php echo $white; ?>";
	  var econ = "<?php echo $econ_dis; ?>";
	  var esl = "<?php echo $esl; ?>";
	  console.log(native);
	  console.log(hispanic);
	  console.log(asian);
	  console.log(black);
	  console.log(white);
	  console.log(econ);
	  console.log(esl);
	  
	  if(native!="Data Unavailable"){
	  create_chart("<?php echo $native; ?>", <?php echo 100-$native; ?>, "chart2");
	  }
	  
	  if(hispanic!="Data Unavailable"){
	  create_chart("<?php echo $hispanic; ?>", <?php echo 100-$hispanic; ?>, "chart3");
	  }
	  
	  if(asian!="Data Unavailable"){
		  create_chart("<?php echo $asian; ?>", <?php echo 100-$asian; ?>, "chart4");
	  }
	  
	  if(black!="Data Unavailable"){
	  create_chart("<?php echo $black; ?>", <?php echo 100-$black; ?>, "chart5");
	  }
	  
	  if(white!="Data Unavailable"){
	  create_chart("<?php echo $white; ?>", <?php echo 100-$white; ?>, "chart6");
	  }
	  
	  if(econ!="Data Unavailable"){
	  create_chart("<?php echo $econ_dis; ?>", <?php echo 100-$econ_dis; ?>, "chart7");
	  }
	  
	  if(esl!="Data Unavailable"){
	  create_chart("<?php echo $esl; ?>", <?php echo 100-$esl; ?>, "chart8");
	  }
    </script>