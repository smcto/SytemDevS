
/*map*/
var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
    geocoder.geocode({
        latLng: pos
    }, function(responses) {
        if (responses && responses.length > 0) {
            //updateMarkerAddress(responses[0].formatted_address.replace(", Allemagne","").split(", ").splice(-1,1));

        } else {
            //updateMarkerAddress('Aucune coordonnÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â©e trouvÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â©e!');
        }
    });
}


function updateMarkerPosition(latLng) {
    document.getElementById('info').value = [
        latLng.lat(),
        latLng.lng()
    ].join(', ');
}

function updateMarkerAddress(str) {
    document.getElementById('searchTextField').value = str;
}

function initialize() {
    var lat = document.getElementById('txtLatitude').value;
    var lng = document.getElementById('txtLongitude').value;
    var latLng = new google.maps.LatLng(lat, lng);
    //var latLng = new google.maps.LatLng(48.51418, -2.7658350000000382);
    var map = new google.maps.Map(document.getElementById('mapCanvas'), {
        zoom: 7,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl: false,
        mapTypeControl: false

    });
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        draggable: true,
        title:"Vous pouvez glisser-déposer pour la destination souhaitée. Ou dans le champ de recherche, saisissez l'emplacement et sélectionnez."
    });

    if(lat == 0 && lng == 0){
        var address = document.getElementById('searchTextField').value;
        geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == 'OK') {

            var map = new google.maps.Map(document.getElementById('mapCanvas'), {
                zoom: 10,
                center: results[0].geometry.location,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false,
                mapTypeControl: false
            });
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location,
                draggable: true,
                title:"Vous pouvez glisser-déposer pour la destination souhaitée. Ou dans le champ de recherche, saisissez l'emplacement et sélectionnez."
            });
          } 
        });
    }
    var input = document.getElementById('searchTextField');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.bindTo('bounds', map);

    // Update current position info.
    updateMarkerPosition(latLng);
    //geocodePosition(latLng);

    // Add dragging event listeners.
    google.maps.event.addListener(marker, 'dragstart', function() {
        //updateMarkerAddress('Dragging...');
    });

    google.maps.event.addListener(marker, 'drag', function() {
        updateMarkerPosition(marker.getPosition());
    });

    google.maps.event.addListener(marker, 'dragend', function() {
        document.getElementById("searchTextField").focus();
        document.getElementById("searchTextField").blur();
        geocodePosition(marker.getPosition());
        document.getElementById("txtLatitude").value = this.getPosition().lat();
        document.getElementById("txtLongitude").value = this.getPosition().lng();
        var lat = parseFloat(document.getElementById("txtLatitude").value);
        var lng = parseFloat(document.getElementById("txtLongitude").value);
        /* var latlng = new google.maps.LatLng(lat, lng);
         var geocoder = geocoder = new google.maps.Geocoder();
         geocoder.geocode({ 'latLng': latlng }, function (results, status) {
         if (status == google.maps.GeocoderStatus.OK) {
         if (results[1]) {
         //alert("Location: " + results[1].formatted_address);
         document.getElementById("searchTextField").value = results[1].formatted_address;
         }
         }
         });*/
    });

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        input.className = 'form-control';
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        if (!place.geometry) {
            // Inform the user that the place was not found and return.
            input.className = 'notfound form-control controls';
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
            document.getElementById("txtLatitude").value = lat;
            document.getElementById("txtLongitude").value = lng;
            //console.log(lat);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
        }
        marker.setPosition(place.geometry.location);
        updateMarkerPosition(marker.getPosition());
        geocodePosition(marker.getPosition());

        var latlng = new google.maps.LatLng(lat, lng);
        var geocoder = geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'latLng': latlng }, function (responses, status) {
            if (responses && responses.length > 0) {
                //updateMarkerAddress(responses[0].formatted_address.replace(", Allemagne","").split(", ").splice(-1,1));
                var elt = responses[0].address_components;

                var lt= responses[0].geometry.location.lat();
                var ln= responses[0].geometry.location.lng();
                //alert("responses[0].address_components "+responses[0].address_components);
                document.getElementById('cp').value = "";
                document.getElementById('ville').value = "";



                for(i in elt){
                    //console.log("==> "+elt[i].types[0]);
                    //console.log("==> "+elt[i].long_name);
                    if(elt[i].types[0] == 'postal_code'){
                        document.getElementById('cp').value = elt[i].long_name;
                    }

                    if(elt[i].types[0] == 'locality'){
                        document.getElementById('ville').value = elt[i].long_name;
                    }
                }

            }
        });

    });
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);

