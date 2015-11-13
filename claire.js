var k=0;

$(document).ready(function(){
    k=$(document).height();
	console.log(k);
	$("#overlay").css("height", k+"px");
});

$(document).ready(function(){
    $(".toggler").hide();
	$("#input_controller").hide();
});


$(document).ready(function(){
    $("#choice3").click(function(){
		$(".toggler").hide();
        $("#mode3_message").slideToggle("slow");
    });
});

$(document).ready(function(){
    $("#choice2").click(function(){
		$(".toggler").hide();
        $("#mode2_message").slideToggle("slow");
    });
});

$(document).ready(function(){
    $("#choice1").click(function(){
		$(".toggler").hide();
        $("#mode1_message").slideToggle("slow");
    });
});

var geocoder;
var map;
var address = "San Gabriel Unified";

function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);
  var myOptions = {
    zoom: 8,
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

$(function(){
    $("#remote_controller").hide();
	 $("#overlay").hide();
    $("#click_input").on("click", function(){
        $("#remote_controller, #overlay").toggle();
    });
	
	   $(".close_window").on("click", function(){
        $("#remote_controller, #overlay").hide();
    });
});


$(function(){
	 $("#overlay").hide();
    $("#click_input3").on("click", function(){
        $("#input_controller, #overlay").toggle();
    });

	   $(".close_window").on("click", function(){
        $("#input_controller, #overlay").hide();
    });
});

