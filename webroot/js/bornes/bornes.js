 $(document).ready(function() {
        //alert('je passe par ici');
     //var a = setInterval(update, 2000);

    $('#type-pc').on('change', function(){
        var type_pc = $(this).val();
        console.log(type_pc);
        var liste_pc = equipements[type_pc];

        // var type_equipement = $(this).val();     equipement_id => numero_series; type_equipement_id => type_pc
        // var liste_equipements = equipements[type_equipement];
        
        var option = '';
        $.each(liste_pc, function(key, value){
            option += '<option value="'+key+'">'+value+'</option>';
        });
        $('#numero-series').html(option);
    });
    $('#type-pc').trigger('change');


        $('.textarea_editor').wysihtml5({"image": false});
        $(".select2").select2();
        
        $("#id_parc").change(function(){
            var val = $(this).val();
            
            if(val == 1){ //Vente
                $("#id_forLocation").addClass("hide");
                $("#id_forVente").removeClass('hide');
            }else if(val == 2){ //Location
                $("#id_forLocation").removeClass("hide");
                $("#id_forVente").addClass('hide');
            }
        });

     $("#is-prette-0").click(function(){
         $("#id_forprete").removeClass("hide");
     });
     $("#is-prette-1").click(function(){
         $("#id_forprete").addClass("hide");

     });

     if($('#is-prette-0').attr('checked')){
         $("#id_forprete").removeClass("hide");
     }




     //=========== SELECTION CLIENT
     $('.selectpicker').selectpicker();

     var BASE_URL = $('#id_baseUrl').val();
     $("#type_client_id").change(function() {
         var type_client_id = $("#type_client_id").val();
         $('#clients_id').empty();
         $('#clients_id').empty();

         $.ajax({
             url: BASE_URL + 'fr/evenements/getListeClient',
             data: {
                 type_client_id: type_client_id
             },
             dataType: 'json',
             type: 'post',
             success: function (data) {
                 $('.bloc-client').remove();
                 var selectNouv = '<div class="col-md-4 bloc-client">\n' +
                     '                        <div class="form-group">\n' +
                     '                            <label class="control-label">Client *</label><br>\n' +
                     '                            <select name="client_id" id="clients_id" class="selectpicker" data-live-search="true">\n' +
                     '                            </select>\n' +
                     '                        </div>\n' +
                     '             </div>';
                 $(selectNouv).insertAfter(".bloc-type-client");
                 $("#clients_id").append('<option value="0">Sélectionner</option>');
                 $.each(data, function (clef, valeur) {
                     $("#clients_id").append('<option value="' + clef + '">' + valeur + '</option>');
                 });
                 $('.selectpicker').selectpicker();
             }
         })
     });

     //==== GESTION LIST CLIENT
     /*var clientSelect = $('#clients_id');
     $("#type_client_id").change(function() {
         var type_client_id = $("#type_client_id").val();
         $('#clients_id').empty();
         $.ajax({
             url: BASE_URL + 'fr/evenements/getListeClient',
             data: {
                 type_client_id: type_client_id
             },
             dataType: 'json',
             type: 'post',
             success: function (data) {
                 var option = new Option( 'Séléctionner un client', "", true, true);
                 clientSelect.append(option);

                 $.each(data, function (clef, valeur) {
                     var option = new Option(valeur, clef, false, false);
                     clientSelect.append(option);
                 });
                 clientSelect.prop('disabled', false);

             }
         })
         clientSelect.trigger('change');
     });*/

     $(".commentaire_sous_louee").hide();
     if($("#is_sous_louee").prop('checked')){
         $(".commentaire_sous_louee").show();

     } else {
         $(".commentaire_sous_louee").hide();
     }

     $("#is_sous_louee").click(function () {
         if ($(this).prop('checked')) {
             $(".commentaire_sous_louee").show();
         } else {
             $(".commentaire_sous_louee").hide();
         }
     });

});
 function aucun_pc_check() {
    alert ("hi");
}
 function update() {
     alert('Up');
     /*var BASE_URL = $('#id_baseUrl').val();
     $.ajax({
         url: BASE_URL + "bornes/updateEtatDevices",
         type: "GET",
         success: function (data) {
             //var rep = $.parseJSON(data);
             console.log(data);
             $("#body_borne").load(window.location + "#body_borne");
             //window.location.href = BASE_URL + "categories";
         }
     });*/
 }
 

function selectColor(){
    var BASE_URL = $('#id_baseUrl').val();
    var id_modelBorne = $("#model_borne_id").val();
    $('#couleurs_possible_id').empty();

    $.ajax({
        url: BASE_URL + 'fr/bornes/liste',
        data: {
            id_ModelBorne: id_modelBorne
        },
        dataType: 'json',
        type: 'post',
        success: function (json) {
            $("#couleurs_possible_id").empty();
            $("#couleurs_possible_id").append('<option value="0"><?=__("Choice")?></option>');
            $.each(json, function (clef, valeur) {
                $("#couleurs_possible_id").append('<option value="' + clef + '">' + valeur + '</option>');
            });
        }
    })

}

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
     });

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
                 document.getElementById('ville-excate').value = "";



                 for(i in elt){
                     //console.log("==> "+elt[i].types[0]);
                     //console.log("==> "+elt[i].long_name);
                     if(elt[i].types[0] == 'postal_code'){
                         document.getElementById('cp').value = elt[i].long_name;
                         //alert(elt[i].long_name);
                     }

                     if(elt[i].types[0] == 'locality'){
                         document.getElementById('ville-excate').value = elt[i].long_name;
                     }

                     /*if(elt[i].types[0] == 'administrative_area_level_2')
                      document.getElementById('dpt').value = elt[i].long_name;
                      if(elt[i].types[0] == 'country')
                      document.getElementById('pays').value = elt[i].long_name;*/
                 }

             }
         });

     });
 }

 // Onload handler to fire off the app.
 google.maps.event.addDomListener(window, 'load', initialize);