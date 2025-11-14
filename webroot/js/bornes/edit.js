$(document).ready(function(){

    $(".select2").select2({
        allowClear: true
    });

    var srcUrl = $("#id_baseUrl").attr('value');

    var base_url = $('#id_baseUrl').val();

    $('.js-data-client-ajax').each(function() { 
        $(this).select2({
            dropdownParent: $(this).parent(),
            minimumInputLength: 2,
            language:{
                inputTooShort: function () {
                  return "Veuillez saisir 2 caractères ou plus";
                }
            },
            ajax: {
                url: srcUrl + "fr/ajax-clients/search-client",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                      nom: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
               }
            });
        });

        $('select#client-id').on('change', function(event) {
            event.preventDefault();
            client_id = $(this).val();
            
            urlGetClient = base_url+'/fr/ajax-ventes/getClient/'+client_id+'.json';

            $.get(urlGetClient, function(data) {
                $('#adresse_client').val(data.adresse);
                $('#txtLatitude').val(data.addr_lat);
                $('#txtLongitude').val(data.addr_lng);
                $('#searchTextField').val(data.adresse);
                $('#link_edit_client').html('<a href="'+base_url+'/fr/clients/edit/'+data.id+'" style="color:#000">Edit Client</a>');
                initialize();
            });
        });

        $('select#antenne-id').on('change', function(event) {
            event.preventDefault();
            antenne_id = $(this).val();
            
            urlGetClient = base_url+'/fr/bornes/getAntenne/'+antenne_id+'.json';

            $.get(urlGetClient, function(data) {
                $('#adresse_antenne').val(data.adresse);
                $('#txtLatitude').val(data.latitude);
                $('#txtLongitude').val(data.longitude);
                $('#searchTextField').val(data.adresse);
                $('#link_edit_antenne').html('<a href="'+base_url+'/fr/antennes/edit/'+data.id+'" style="color:#000">Edit Antenne</a>');
                initialize();
            });
        });

    $('#id_parc').on('change', function(){
        var parc_id = $(this).val();
        if (parc_id == 2){
            $('.antenne-id').removeClass('hide');
            $('.client-id').addClass('hide');
        }else if(parc_id == 1 || parc_id == 4 || parc_id == 9){
            $('.antenne-id').addClass('hide');
            $('.client-id').removeClass('hide');
        }else {
            $('.antenne-id').addClass('hide');
            $('.client-id').addClass('hide');
        }
        
        if(parc_id == 1 || parc_id == 4){
            $('.sous-loc').removeClass('hide');
        }else {
            $('.sous-loc').addClass('hide');
        }
    });
    
    $('#is-sous-louee').on('change', function(){
        var sousloc = $(this).val();
        if (sousloc == 1){
            $('.antenne-loc').removeClass('hide');
        }else{
            $('.antenne-loc').addClass('hide');
        }
    });
    
    // modelBornes
    $('#gamme').on('change', function(){
        var gamme = $(this).val();
        var liste_model_bornes = modelBornes[gamme];
        var value_model_bornes = $('#value_model_borne_id').val();
        var option = '<option value>Séléctionner</option>';
        $.each(liste_model_bornes, function(key, value){
            if(key == value_model_bornes){
                option += '<option value="'+key+'" selected = selected>'+value+'</option>';
            }else{
                option += '<option value="'+key+'">'+value+'</option>';
            }
        });
        $('#model_borne_id').html(option);
        
        $('#model_borne_id').html(option);
        var borne_id = $('#borne_id').val();
        $.get(srcUrl + 'fr/ajax-bornes/equipement-by-gamme/' + gamme + '/' + borne_id, function(data, xhr) {
            $("#div-equipement").html(data);
            var nombre = $('#nombre').val();
            equipementsBorne(nombre - 1);
        });
        
    });
    $('#gamme').trigger('change');
    
    $('#save-submit').on('click',function(){
            var numero = $('#numero').val();
            var model_borne_id = $('#model_borne_id').val();
            var couleurs_possible_id = $('#couleurs_possible_id').val();
            var statut = $('#statut').val();
            if(numero == '' || model_borne_id == '' || couleurs_possible_id == '' || statut == ''){
                    $("#t1").addClass('active');
                    $("#p1").addClass('active');
                    for( var i = 2; i<7 ;i++){
                        if($("#t"+i).hasClass('active')){
                            $("#t"+i).removeClass('active');
                            $("#p"+i).removeClass('active');
                        }
                    }
            }
            var new_num_pc = $('#new_numero_series_pc').val();
            var prop_new_num_pc = $('#new_numero_series_pc').prop('required');
            var new_num_ecran = $('#new_numero_series_ecran').val();
            var prop_new_num_ecran = $('#new_numero_series_ecran').prop('required');
            var new_num_aphoto = $('#new_numero_series_aphoto').val();
            var prop_new_num_aphoto = $('#new_numero_series_aphoto').prop('required');
            var new_num_print = $('#new_numero_series_print').val();
            var prop_new_num_print = $('#new_numero_series_print').prop('required');
            
            if(     (new_num_pc == '' && prop_new_num_pc == true) || 
                    (new_num_ecran == '' && prop_new_num_ecran == true) || 
                    (new_num_aphoto == '' && prop_new_num_aphoto == true) || 
                    (new_num_print == '' && prop_new_num_print == true)
            ){
                    for( var i = 1; i<7 ;i++){
                        if($("#t"+i).hasClass('active') && i != 4){
                            $("#t"+i).removeClass('active');
                            $("#p"+i).removeClass('active');
                        }if(i == 4){
                            $("#t4").addClass('active');
                            $("#p4").addClass('active');
                        }
                    }
            }
    });
    
});

function equipementsBorne(nombre) {
    
    if(nombre != 'undefined' && nombre >= 0) {
        
        var j = nombre;
        var type = $('#equipement-bornes-' + j + '-type-equipement-id').val();
        var old_type = $('#equipement-bornes-' + j + '-old-equipement-id').val();
        var equipement = equipements[type];

        var option = '<option value>Séléctionner</option>';
        $.each(equipement, function(key, value){
            if(old_type == key) {
                option += '<option value="'+key+'" selected = selected>'+value+'</option>';
            }else {
                option += '<option value="'+key+'">'+value+'</option>';
            }
        });
        $('#equipement-bornes-' + j + '-equipement-id').html(option);
        
        $('#equipement-bornes-' + j + '-equipement-id').on('change', function(){
            var equip = $(this).val();
            var old_equip = $('#equipement-bornes-' + j + '-old-numero-serie-id').val();
            var numeroSeries = numeroSeriesEquip[equip];

            var option = '<option value>Séléctionner</option>';
            $.each(numeroSeries, function(key, value){
                if(old_equip == key) {
                    option += '<option value="'+key+'" selected = selected>'+value+'</option>';
                }else {
                    option += '<option value="'+key+'">'+value+'</option>';
                }
            });
            $('#equipement-bornes-' + j + '-numero-serie-id').html(option);
        });
        $('#equipement-bornes-' + j + '-equipement-id').trigger('change');
        
        $('#equipement-bornes-' + j + '-aucun').on('change', function(){
            if($(this).prop('checked')){
                $('.' + j + '-aucun').removeClass('hide');
                $('.' + j + '-exist').addClass('hide');
            }else{
                $('.' + j + '-aucun').addClass('hide');
                $('.' + j + '-exist').removeClass('hide');
            }
        });
        
        
        $('#equipement-bornes-' + j + '-new-stock').on('change', function(){
            if($(this).prop('checked')){
                $('.' + j + '-stock').removeClass('hide');
                $('.' + j + '-hide-stock').addClass('hide');
                $('.' + j + '-exist').removeClass('col-md-6').addClass('col-md-4');
            }else{
                $('.' + j + '-stock').addClass('hide');
                $('.' + j + '-hide-stock').removeClass('hide');
                $('.' + j + '-exist').removeClass('col-md-4').addClass('col-md-6');
            }
        });
        equipementsBorne(nombre - 1);
    }
    
    // ----- checkbox tr collapse AJAX ----------
    $('.tr-container-checkbox input[type="checkbox"]').click(function(event) {
        self = $(this);
        dataTarget  = self.attr('data-target');

        if (self.is(':checked')) {
            $('tr#'+dataTarget).removeClass('d-none');
        } else {
            $('tr#'+dataTarget).addClass('d-none');
            $('tr#'+dataTarget).find('input[type="number"]').val(0);
        }
    });
    
    $('.tr-container-checkbox input[type="checkbox"]').each(function(index, el) {
        var self = $(this);
        var dataTarget  = self.attr('data-target');

        if (self.is(':checked')) {
            $('tr#'+dataTarget).removeClass('d-none');
        } else {
            $('tr#'+dataTarget).addClass('d-none');
        }
    });
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
    
    var map = new google.maps.Map(document.getElementById('mapCanvas'), {
        zoom: 10,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl: false,
        mapTypeControl: false

    });
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
    });
    
    var map2 = new google.maps.Map(document.getElementById('mapCanvas2'), {
        zoom: 10,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl: false,
        mapTypeControl: false

    });
    var marker2 = new google.maps.Marker({
        position: latLng,
        map: map2,
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
                });
                
                var map2 = new google.maps.Map(document.getElementById('mapCanvas2'), {
                    zoom: 10,
                    center: results[0].geometry.location,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    streetViewControl: false,
                    mapTypeControl: false

                });
                var marker2 = new google.maps.Marker({
                    map: map2,
                    position: results[0].geometry.location,
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
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize());
