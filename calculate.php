<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="http://maps.googleapis.com/maps/api/js"></script>

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
			top: 10px;
			left: 10px;
		}
		
		#content{
			text-align: center;
			position: relative;
			top: 10px;
			left: 0px;
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


$city = $_POST["geo_selection"];

$county = $_POST["geo_selection2"];

echo "<table id='sample_profile'><tr><td colspan='2'><h3>Sample Student Profile</h3></td></tr>
<tr><td>Gender</td><td>".$_POST["gender"]."</td></tr>
<tr><td>Ethnicity</td><td>".$_POST["ethnicity"]."</td></tr>
<tr><td>Economic Status</td><td>".$_POST["income_range"]."</td></tr>
<tr><td>District</td><td>".$_POST["geo_selection"]."</td></tr>
<tr><td>County</td><td>".$_POST["geo_selection2"]."</td></tr>
<tr><td>State</td><td>".$_POST["esl"]."</td></tr>
<tr><td>ESL</td><td>".$_POST["esl"]."</td></tr>
</table>";

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



?>

 <div id="chart"></div>
 <script>
 $( document ).ready(function() {
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
 
 <table class='three_chart'>
 <tr>
 <td><h3>2014 Graduation Rates of Student's Ethnic Group</h3></td>
 <td><h3>2014 Graduation Rates of Student's Gender Group</h3></td>
 <td><h3>2014 Graduation Rates of Student's Economic Group</h3></td>
 </tr>
 <tr><td>
 
 </td>
 
 <td>
 <table border='1'>
<tr><td><b>Average Graduation Rate</b></td><td></td></tr>
<tr><td><b>Variance</b></td><td></td></tr>
<tr><td><b>1 Standard Deviation</b></td><td></td></tr>
</table>
 </td>
 
 <td></td></tr></table>
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
 
 <i>Explanation for at risk ranking blah blah stuff asldkfjas;lkdfjsldkjf </i><p>
 

<p>
<br><br>

<hr>
<p>

<iframe src="http://192.241.201.165:3838/data/app1/" style="border: 1px solid #AAA; width: 790px; height: 460px"></iframe>


<p>
<hr>
<p>
<table class="data_table"><tr><td>
<i>For the above student profile, if they did not graduate, these are the most likely causes: </i><p>

<ul><li>Economically disadvantaged versus majority of graduation cohort</li>
<li>blah blah some other reason</li>
</ul>
</td>
<td>

<table class="results_table">
<tr><td>ECD</td><td>0.637473569</td></tr>
<tr><td>MWH</td><td>0.412402041</td></tr>
<tr><td>MBL</td><td>0.285610028</td></tr>
<tr><td>MHI</td><td>0.278868885</td></tr>
<tr><td>CWD</td><td>0.264849141</td></tr>
<tr><td>LEP</td><td>0.133160609</td></tr>
<tr><td>MAS</td><td>0.049108753</td></tr>
<tr><td>MTR</td><td>0.027108294</td></tr>
<tr><td>MAM</td><td>0.025975846</td></tr>
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

        var color = d3.scale.category20b();

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
    </script>