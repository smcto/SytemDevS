function initialize() {
    
    // var input = document.getElementById('adresse');
    var input = $('#adresse , .adresse').get(0);
    var autocomplete = new google.maps.places.Autocomplete(input);

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        // input.className = 'form-control';
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        if (!place.geometry) {
            // Inform the user that the place was not found and return.
            input.className = 'notfound form-control controls';
            return;
        }

        var latlng = new google.maps.LatLng(lat, lng);
        var geocoder = geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'latLng': latlng }, function (responses, status) {
            if (responses && responses.length > 0) {
                var elt = responses[0].address_components;

                $("#cp , .cp").val("");
                $("#ville , .ville").val("");
                if(! $('#is-ville-manuel').is(':checked')) {
                    $('#is-ville-manuel').click();
                }
                
                var address = $('#adresse , .adresse').val();
                var address_array = address.split(', ');
                
                for(i in elt){
                    // console.log(elt[i].types[0]);
                    // console.log(elt[i].long_name);
                    // console.log(address_array);
                    if(elt[i].types[0] == 'postal_code'){
                        $("#cp, .cp").val(elt[i].long_name);
                        address_array = address_array.filter(e => e !== elt[i].long_name);
                    }

                    if(elt[i].types[0] == 'locality'){
                        $("#ville, .ville").val(elt[i].long_name);
                        address_array = address_array.filter(e => e !== elt[i].long_name);
                    }
                    
                    if(elt[i].types[0] == 'country'){
                        if($("#country , .country").length > 0) {
                            majClientPays($('#country, .country'), elt[i].short_name);
                        }
                        address_array = address_array.filter(e => e !== elt[i].long_name);
                    }
                }
                $('#adresse , .adresse').val(address_array[0]);

            }
        });

    });
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);