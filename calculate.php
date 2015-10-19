<div id="content">

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

$sql = "SELECT * FROM locations WHERE city='".$city."' AND county='".$county."'";
$result = $link->query($sql);
$percent = 0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["ALL_RATE"]. "% of a cohort size of " . $row["ALL_COHORT"]. " from the district of " . $city ." in " . $row["State"] ." graduated in 2014.<br>";
		$percent = $row["ALL_RATE"];
	}
} else {
    echo "0 results";
}

$remainder=100-$percent;

echo "Calculating statistics <p>";
echo $_POST["geo_selection"]."<br>";
echo $_POST["geo_selection2"]."<br>";
echo $_POST["income_range"]."<br>";
echo $_POST["gender"]."<br>";

echo $_POST["ethnicity"]."<br>";
echo $_POST["esl"]."<br>";

?>
</div>
<link href="//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css" rel="stylesheet" data-semver="3.0.1" data-require="normalize@*" />
    <style>
      .legend {                                                   /* NEW */
        font-size: 12px;                                          /* NEW */
      }                                                           /* NEW */
      rect {                                                      /* NEW */
        stroke-width: 2;                                          /* NEW */
      }                                                           /* NEW */
    
		#chart{
			
			position: absolute;
			top: 200px;
			left: 200px;
		}
		
		#content{
			position: absolute;
			top: 10px;
			left: 200px;
		}
	</style>
  </head>

  <body>
    <div id="chart"></div>
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
        var donutWidth = 75;
        var legendRectSize = 18;                                  // NEW
        var legendSpacing = 4;                                    // NEW

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
            var horz = -2 * legendRectSize;                       // NEW
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