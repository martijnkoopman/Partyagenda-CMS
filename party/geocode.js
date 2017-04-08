function fill()
{
    var venue = document.getElementsByName("venue")[0].value;
    var address = document.getElementsByName("address")[0].value;
    var postcode = document.getElementsByName("postcode")[0].value;
    var city = document.getElementsByName("city")[0].value;
	var completeAdress = venue+' '+address+' '+postcode+' '+city;
	
	var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': completeAdress}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {

		var latitude = results[0].geometry.location.lat()
		var longitude = results[0].geometry.location.lng()
		
		document.getElementsByName("latitude")[0].value=latitude;
		document.getElementsByName("longitude")[0].value=longitude;
		
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
}