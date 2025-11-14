var URL_BASE;

$(document).ready(function () {

    $(".select2").select2();
    $('.selectpicker').selectpicker();
    var options = { now: "00:00", //hh:mm 24 hour format only, defaults to current time 
                                   twentyFour: true, //Display 24 hour format, defaults to false 
                                   upArrow: 'wickedpicker__controls__control-up', //The up arrow class selector to use, for custom CSS 
                                   downArrow: 'wickedpicker__controls__control-down', //The down arrow class selector to use, for custom CSS 
                                   close: 'wickedpicker__close', //The close class selector to use, for custom CSS 
                                   hoverState: 'hover-state', //The hover state class to use, for custom CSS 
                                   title: 'Heur', //The Wickedpicker's title, 
                                   showSeconds: false, //Whether or not to show seconds, 
                                   secondsInterval: 1, //Change interval for seconds, defaults to 1 , 
                                   minutesInterval: 1, //Change interval for minutes, defaults to 1 
                                   beforeShow: null, //A function to be called before the Wickedpicker is shown 
                                   show: null, //A function to be called when the Wickedpicker is shown 
                                   clearable: true, //Make the picker's input clearable (has clickable "x") 
                                  };
        //$('.timepicker').wickedpicker(options);
       
        var j = ['lun','mar', 'mer', 'jeu', 'ven', 'sam','dim'];
        for(k in j){
            var temps = "";
            if($('#debut-1-' + j[k]).val()){
                temps = $('#debut-1-' + j[k]).val();
                options['now'] = temps;
            }
            $('#debut-1-' + j[k]).wickedpicker(options);
            $('#debut-1-' + j[k]).val(temps);
            
            temps = "";
            if($('#fin-1-' + j[k]).val()){
                temps = $('#fin-1-' + j[k]).val();
                options['now'] = temps;
            }
            $('#fin-1-' + j[k]).wickedpicker(options);
            $('#fin-1-' + j[k]).val(temps);
            
            temps = "";
            if($('#debut-2-' + j[k]).val()){
                temps = $('#debut-2-' + j[k]).val();
                options['now'] = temps;
            }
            $('#debut-2-' + j[k]).wickedpicker(options);
            $('#debut-2-' + j[k]).val(temps);
            
            temps = "";
            if($('#fin-2-' + j[k]).val()){
                temps = $('#fin-2-' + j[k]).val();
                options['now'] = temps;
            }
            
            options['title'] = "Horaire fin";
            $('#fin-2-' + j[k]).wickedpicker(options);
            $('#fin-2-' + j[k]).val(temps);
            
        }
        
        temps = "";
        if($('#fin').val()){
            temps = $('#fin').val();
            options['now'] = temps;
        }
        $('#fin').wickedpicker(options);
        $('#fin').val(temps);
        temps = "";
        if($('#debut').val()){
            temps = $('#debut').val();
            options['now'] = temps;
        }
        $('#debut').wickedpicker(options);
        $('#debut').val(temps);


       
    var BASE_URL = $('#base_url').val();

    //======== Duplication form contact
    $('.kl_trash:first').hide();
    $('.btnSupprEdit:first').show();

    var nb = 1;

    $('#btnAjoutContact').on('click', function (e) {

        nb = nb + 1;

        e.preventDefault();
        //console.log(getAllValues());
        var cloneForm = $("[id ^='contactForm']:last").clone();
        //===== gestion titre du form
        var titreContent = $("[id ^='contactForm']:last h3").text(); //TITRE:Contact 1 id:contactForm0
        titresContent = titreContent.split(" ");
        var nouvNum = parseInt(titresContent[1]) + 1;
        $(cloneForm).find('h3').text(titresContent[0] + " " + nouvNum);
        // $(cloneForm).removeAttr('class');
        // $(cloneForm).attr('class', "bloc_form contactForm nouvForm");
        $(cloneForm).attr('id', "contactForm-" + (nouvNum - 1));
        $(cloneForm).find('button').attr('id', '');
        $(cloneForm).find('button').attr('id', "btnSupprContactForm-" + (nouvNum - 1));
        cloneForm.find('.kl_trash').show();//=== affichage btntrash
        //==== gestion des form pr vehiculé
        var div = cloneForm.find("[id ^='choix_modele_vehicule-']");
        div.attr('id', 'choix_modele_vehicule-' + (nouvNum - 1));
        div.addClass('hide');
        var div = cloneForm.find("[id ^='choix_nbr_transportable_vehicule-']");
        div.attr('id', 'choix_nbr_transportable_vehicule-' + (nouvNum - 1));
        div.addClass('hide');
        var div = cloneForm.find("[id ^='choix_comnt_vehicule-']");
        div.attr('id', 'choix_comnt_vehicule-' + (nouvNum - 1));
        div.addClass('hide');

        //==== gestion des inputs du nouv form
        var inputs = cloneForm.find('input');
        var selects = cloneForm.find('select');
        var labels = cloneForm.find('label');
        var dates = cloneForm.find('date');
        //var files = cloneForm.find('file');
        var checkboxs = cloneForm.find('checkbox');
        var textareas = cloneForm.find('textarea');

        $.each(labels, function (index, elem) {
            var label = $(elem);
            var labelFor = label.attr('for'); // ex:
            if (typeof labelFor != 'undefined') {
                fors = labelFor.split('-');
                var num = parseInt(fors[2]);
                var nouvLabel = fors[0] + "-" + fors[1] + "-" + (num + 1);
                label.attr('for', nouvLabel);
            }
        });

        $.each(inputs, function (index, elem) {
            var input = $(elem);
            console.log(input);
            var id = input.attr('id'); // ex: users-nom-0
            ids = id.split('-');
            var num = parseInt(ids[2]);
            var nouvName = ids[0] + "[" + (nouvNum - 1) + "][" + ids[1] + "]";
            var nouvId = ids[0] + "-" + ids[1] + "-" + (nouvNum - 1);
            input.attr('id', nouvId);
            input.attr('name', nouvName);
            var est_file = input.attr('type');

            if (nouvId === "contacts-id-" + (num + 1)) {
                input.remove();
            }
            if (input.attr('type') == 'radio') {
                var nouvId = ids[0] + "-" + ids[1] + "-" + (nouvNum - 1) + "-" + ids[3];
                input.attr('id', nouvId);
            } else {
                //input.val("");
            }
            if (input.attr('type') == 'checkbox' || input.attr('type') == 'radio') {
                input.attr('checked', false);
            }
            if (est_file == 'file') {
                input.dropify({
                    tpl: {
                        wrap: '',
                        message: ''
                    }
                });
            }
        });

        $.each(selects, function (index, elem) {
            var input = $(elem);
            var id = input.attr('id'); // ex: users-nom-0
            ids = id.split('-');
            var num = parseInt(ids[2]);
            var nouvName = ids[0] + "[" + (nouvNum - 1) + "][" + ids[1] + "]";
            var nouvId = ids[0] + "-" + ids[1] + "-" + (nouvNum - 1);
            input.attr('id', nouvId);
            input.attr('name', nouvName);
            input.val("");
        });

        $.each(dates, function (index, elem) {
            var input = $(elem);
            var id = input.attr('id'); // ex: users-nom-0
            ids = id.split('-');
            var num = parseInt(ids[2]);
            var nouvName = ids[0] + "[" + (nouvNum - 1) + "][" + ids[1] + "]";
            var nouvId = ids[0] + "-" + ids[1] + "-" + (nouvNum - 1);
            input.attr('id', nouvId);
            input.attr('name', nouvName);
            input.val("");
        });

        $(cloneForm).find('input:checkbox').attr('checked', false);
        $.each(checkboxs, function (index, elem) {
            var input = $(elem);
            var id = input.attr('id'); // ex: users-nom-0
            ids = id.split('-');
            var num = parseInt(ids[2]);
            var nouvName = ids[0] + "[" + (nouvNum - 1) + "][" + ids[1] + "]";
            var nouvId = ids[0] + "-" + ids[1] + "-" + (nouvNum - 1);
            input.attr('id', nouvId);
            input.attr('name', nouvName);
            input.removeAttr('checked');
        });

        $.each(textareas, function (index, elem) {
            var input = $(elem);
            var id = input.attr('id'); // ex: users-nom-0
            ids = id.split('-');
            var num = parseInt(ids[2]);
            var nouvName = ids[0] + "[" + (nouvNum - 1) + "][" + ids[1] + "]";
            var nouvId = ids[0] + "-" + ids[1] + "-" + (nouvNum - 1);
            input.attr('id', nouvId);
            input.attr('name', nouvName);
            input.val("");
        });

        cloneForm.insertAfter('.contactForm:last');
        var eltClone = cloneForm.insertAfter('.contactForm:last');
        $('html,body').animate({scrollTop: $(eltClone).offset().top}, 1000);//==== animation scroll
        //==== animation scroll
        $('html,body').animate({scrollTop: $('.contactForm:last').offset().top}, 1000);
    });

    //==== suppression du form dans edit
    $(document).on('click', '.btn_suppr', function () {
        var id = $(this).attr('id');
        var numContact = id.split('-')['1'];
        //alert(id+" "+numContact+" "+id.split('-')['2']);
        if (confirm("Etes vous sÃ»r de vouloir supprimer ce contact ?")) {
            if (typeof id.split('-')['2'] !== 'undefined') {
                var idUser = id.split('-')['2'];
                $("#asuppr-" + numContact).val(idUser);
            }
            $("#contactForm-" + numContact).hide("blind");
            $("#contactForm-" + numContact).remove();
        }
    });

    $(document).on('click', '.checkbox', function () {
        var id = $(this).attr('id');
        var cle = id.split('-')['2'];
        if ($(this).is(":checked")) {
            $(this).attr('value', '1');
            //$('.is_vehicule-'+cle).removeClass('hide');
            $('#choix_modele_vehicule-' + cle).removeClass('hide');
            $('#choix_nbr_transportable_vehicule-' + cle).removeClass('hide');
            $('#choix_comnt_vehicule-' + cle).removeClass('hide');
        } else {
            $(this).attr('value', '0');
            $('.is_vehicule-' + cle).addClass('hide');
            $('#choix_modele_vehicule-' + cle).addClass('hide');
            $('#choix_nbr_transportable_vehicule-' + cle).addClass('hide');
            $('#choix_comnt_vehicule-' + cle).addClass('hide');
        }

    });

    $('#sous_antenne').on('change', function () {
        if ($('#sous_antenne').prop('checked')) {
            $('.principal').removeClass('hide');
        } else {
            $('.principal').addClass('hide');
        }
    });

    $('#tous-jours').on('change', function () {
        if ($('#tous-jours').prop('checked')) {
            $('.tous-jours').removeClass('hide');
            $('.jours-specifique').addClass('hide');
            document.getElementById("jours-specifique").checked = false;
        } else {
            $('.tous-jours').addClass('hide');
            $('.jours-specifique').removeClass('hide');
            document.getElementById("jours-specifique").checked = true;
        }
    });

    $('#jours-specifique').on('change', function () {
        if ($('#jours-specifique').prop('checked')) {
            $('.jours-specifique').removeClass('hide');
            $('.tous-jours').addClass('hide');
            document.getElementById("tous-jours").checked = false;
        } else {
            $('.jours-specifique').addClass('hide');
            $('.tous-jours').removeClass('hide');
            document.getElementById("tous-jours").checked = true;
        }
    });
   

//$('#debut-1-lun').timepicki({show_meridian:false});
    
    $('#save_heurs').on('click',function(){
        var id = $('#antenne_id').val();
        var dt = {};
        dt["tous_jours"] = 0;
        if($('#tous-jours').prop('checked')){
            dt["tous_jours"] = 1;
        }
        dt["jours_specifique"] = 0;
        if($('#jours-specifique').prop('checked')){
            dt["jours_specifique"] = 1;
        }
        dt["debut"] = $('#debut').val();
        dt["fin"] = $('#fin').val();
        var j = ['lun','mar', 'mer', 'jeu', 'ven', 'sam','dim'];
        for(k in j){
            dt[j[k]] = 0;
            if($('#' + j[k]).prop('checked')){
                dt[j[k]] = 1;
            }
            dt["debut-1-" + j[k]] = $('#debut-1-' + j[k]).val();
            dt["fin-1-" + j[k]] = $('#fin-1-' + j[k]).val();
            dt["debut-2-" + j[k]] = $('#debut-2-' + j[k]).val();
            dt["fin-2-" + j[k]] = $('#fin-2-' + j[k]).val();
        }
        
        $.ajax({
            url: $('#id_baseUrl').val() + "fr/antennes/saveHeurs/" + id,
            type: "POST",
            data: {"data":dt},
            beforeSend: function(){
                    $('#save_heurs').addClass('disabled').append('<img src="/img/loading.svg" class="em-load m-l-5" style="width:20px;">');
            },
            success: function (data) {
                var array = JSON.parse(data);
                var html = "";
                if(array!=null && array['jours']=='tous_jours'){
                     html = '<div class="row">'+
                                        '<div class="col-md-4 align-self-center">'+
                                             '<label class="control-label">Tous les jours</label>'+
                                        '</div>'+
                                        '<div class="col-md-4 align-self-center">'+
                                             '<label class="control-label">Horaire début :  '+array['heurs']['debut']+'</label>'+
                                        '</div>'+
                                        '<div class="col-md-4 align-self-center">'+
                                             '<label class="control-label">Horaire fin : ' + array['heurs']['fin'] + '</label>'+
                                        '</div>' +
                                '</div>';
                } else{
                    html = '<div class="form-group row" style="padding: 0px 20px 0px 20px; width: 90%;" >'+
                                '<table class="table table-bordered min-t">'+
                                    '<thead>'+
                                        '<tr>'+
                                            '<th width="25%" class="p-0">Jour</th>'+
                                            '<th width="30%" class="p-0">Horaire début</th>'+
                                            '<th width="35%" class="p-0">Horaire fin</th>'+
                                        '</tr>'+
                                    '</thead>'+
                                    '<tbody>';

                                var jours = {'lun': 'Lundi','mar': 'Mardi', 'mer': 'Mercredi', 'jeu': 'Jeudi', 'ven': 'Vendredi', 'sam': 'Samedi','dim': 'Dimanche'}; 
                                   for (var j in jours){
                                        if(array['heurs'].hasOwnProperty(j)){
                                       html  += '<tr>'+
                                                '<td><div class="mt-1">'+jours[j]+'</div></td>'+
                                                '<td>' + (array['heurs'][j]['debut-1-'+j]!== 'undefined'?array['heurs'][j]['debut-1-'+j]:'') + '</td>'+
                                                '<td>' + (array['heurs'][j]['fin-1-'+j]!== 'undefined'?array['heurs'][j]['fin-1-'+j]:'') + '</td>'+
                                            '</tr>';
                                            if(array['heurs'][j].hasOwnProperty('debut-2-'+j)){
                                                 html  += '<tr class="mt-2">'+
                                                    '<td></td>'+
                                                    '<td>' + (array['heurs'][j]['debut-2-'+j]!== 'undefined'?array['heurs'][j]['debut-2-'+j]:'') + '</td>'+
                                                    '<td>' + (array['heurs'][j]['fin-2-'+j]!== 'undefined'?array['heurs'][j]['fin-2-'+j]:'') + '</td>'+
                                                '</tr>';
                                            }
                                        }
                                   }
                               html += '</tbody>'+
                           '</table>'+
                   '</div>';
               }
                $('#heurs').html(html);
                $('#change-state').modal('hide');
                $('#save_heurs').html('Enregistrer');
            }
        });
    });

});

/*map*/
var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
    geocoder.geocode({
        latLng: pos
    }, function (responses) {
        if (responses && responses.length > 0) {
            //updateMarkerAddress(responses[0].formatted_address.replace(", Allemagne","").split(", ").splice(-1,1));

        } else {
            //updateMarkerAddress('Aucune coordonnÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚Â ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¾Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â©e trouvÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚Â ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¾Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â©e!');
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
        zoom: 17,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl: false,
        mapTypeControl: false

    });
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        draggable: true,
        title: "Vous pouvez glisser-déposer pour la destination souhaitée. Ou dans le champ de recherche, saisissez l'emplacement et sélectionnez."
    });

    var input = document.getElementById('searchTextField');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.bindTo('bounds', map);

    // Update current position info.
    updateMarkerPosition(latLng);
    //geocodePosition(latLng);

    // Add dragging event listeners.
    google.maps.event.addListener(marker, 'dragstart', function () {
        //updateMarkerAddress('Dragging...');
    });

    google.maps.event.addListener(marker, 'drag', function () {
        updateMarkerPosition(marker.getPosition());
    });

    google.maps.event.addListener(marker, 'dragend', function () {
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

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
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
        geocoder.geocode({'latLng': latlng}, function (responses, status) {
            if (responses && responses.length > 0) {
                //updateMarkerAddress(responses[0].formatted_address.replace(", Allemagne","").split(", ").splice(-1,1));
                var elt = responses[0].address_components;

                var lt = responses[0].geometry.location.lat();
                var ln = responses[0].geometry.location.lng();
                //alert("responses[0].address_components "+responses[0].address_components);
                document.getElementById('cp').value = "";
                document.getElementById('ville-excate').value = "";



                for (i in elt) {
                    //console.log("==> "+elt[i].types[0]);
                    //console.log("==> "+elt[i].long_name);
                    if (elt[i].types[0] == 'postal_code') {
                        document.getElementById('cp').value = elt[i].long_name;
                        //alert(elt[i].long_name);
                    }

                    if (elt[i].types[0] == 'locality') {
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


Dropzone.autoDiscover = false;
$(document).ready(function () {

    var BASE_URL = $('#id_baseUrl').val();
    var antenne_id = $('#antenne_id').val();
    $("#id_dropzone").dropzone({
        url: BASE_URL + "fr/antennes/uploadPhotos",
        uploadMultiple: false,
        addRemoveLinks: true,
        success: function (file, result, data) {
            var obj = jQuery.parseJSON(result);
            if (obj.success) {
                var nameFile = obj.name;
                if (obj.type_upload == "photo_lieu") {
                    $(file.previewTemplate).append('<input type="hidden" class="" value="' + nameFile + '" name="photoslieux[][nom]" />');
                }
                if (obj.type_upload == "document") {
                    $(file.previewTemplate).append('<input type="hidden" class="" value="' + nameFile + '" name="documents[][nom]" />');
                }
            } else {
                this.removeFile(file);
                alert('Erreur sur la connexion. Veuillez reverifier puis réessayer.');
            }
        },

        init: function () {
            this.on("sending", function (file, xhr, formData) {
                source = $($(this)[0].element);
                var type_upload = source.attr('data-owner');
                formData.append("type_upload", type_upload);
            });

            this.on('addedfile', function (file) {
                var maxsize = 25 * 1024 * 1024;
                if (file.size > maxsize) {
                    this.removeFile(file);
                    alert('Fichier trop gros. Veuillez réessayer.');
                }
            });

            //==== edition img
            this.on('removedfile', function (file) {
                if (antenne_id !== '') {
                    //alert(file.name);
                    $(".dropzone").append('<input type="hidden" class="" value="' + file.name + '" name="documents_a_suppr[][nom]" />');
                }
            });

            if (antenne_id !== '') {
                var thisDropzone = this;
                var idFiles = [];
                var titreFiles = [];
                var urlFiles = [];
                
                $.getJSON(BASE_URL + "fr/antennes/getFichiers/" + antenne_id, function (data) {
                    $.each(data, function (key, value) {
                        //console.log(value);
                        var mockFile = {name: value.name, size: value.size};
                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                        var urlFile = BASE_URL + "uploads/antenne/" + value.name;
                        var url = value.url;
                        //console.log(urlFile);
                        if (value.extension === "pdf") {
                            urlFile = BASE_URL + "img/img_pdf.png";
                            url = value.url_viewer;
                        }
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, urlFile);
                        $('.dz-preview .dz-image img').css({"width": "128", "height": "128"});
                        idFiles[key] = value.id;
                        titreFiles[key] = value.name_origine;
                        urlFiles[key] = url;
                    });

                    console.log(idFiles);
                    var btn_supprs = $('#id_dropzone').find('a.dz-remove');
                    $.each(btn_supprs, function (key, elem) {
                        var a = $(elem);
                        a.attr('id', 'file_' + idFiles[key]);
                        var btn_view_file = '<a class="dz-remove" href="' + urlFiles[key] + '" target="_blank">Visualiser</a>';
                        $(btn_view_file).insertBefore(a);
                    });
                });
            }
        },
        //acceptedFiles: "image/*",
        acceptedFiles: ".doc, .docx, .odt, .pdf, .png, .jpg, .jpeg",
        dictRemoveFile: "Supprimer",
        dictCancelUpload: "Annuler",
        //dictDefaultMessage:"<span class=''>Ajouter documents</span>"
    });
    
    
    $("#id_dropzone_document").dropzone({
        url: BASE_URL + "fr/antennes/uploadPhotos",
        uploadMultiple: false,
        addRemoveLinks: true,
        success: function (file, result, data) {
            var obj = jQuery.parseJSON(result);
            if (obj.success) {
                var nameFile = obj.name;
                if (obj.type_upload == "photo_lieu") {
                    $(file.previewTemplate).append('<input type="hidden" class="" value="' + nameFile + '" name="photoslieux[][nom]" />');
                }
                if (obj.type_upload == "document") {
                    $(file.previewTemplate).append('<input type="hidden" class="" value="' + nameFile + '" name="documents[][nom]" />');
                }
            } else {
                this.removeFile(file);
                alert('Erreur sur la connexion. Veuillez reverifier puis réessayer.');
            }
        },

        init: function () {
            this.on("sending", function (file, xhr, formData) {
                source = $($(this)[0].element);
                var type_upload = source.attr('data-owner');
                formData.append("type_upload", type_upload);
            });

            this.on('addedfile', function (file) {
                var maxsize = 25 * 1024 * 1024;
                if (file.size > maxsize) {
                    this.removeFile(file);
                    alert('Fichier trop gros. Veuillez réessayer.');
                }
            });

            //==== edition img
            this.on('removedfile', function (file) {
                if (antenne_id !== '') {
                    //alert(file.name);
                    $(".dropzone").append('<input type="hidden" class="" value="' + file.name + '" name="documents_a_suppr[][nom]" />');
                }
            });

            if (antenne_id !== '') {
                var thisDropzone = this;
                var idFiles = [];
                var titreFiles = [];
                var urlFiles = [];
                $.getJSON(BASE_URL + "fr/antennes/getDocuments/" + antenne_id, function (data) {
                    $.each(data, function (key, value) {
                        var mockFile = {name: value.name, size: value.size};
                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                        var urlFile = BASE_URL + "uploads/antenne/" + value.name;
                        var url = value.url;
                        if (value.extension === "pdf") {
                            urlFile = BASE_URL + "img/img_pdf.png";
                            url = value.url_viewer;
                        }
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, urlFile);
                        $('.dz-preview .dz-image img').css({"width": "128", "height": "128"});
                        idFiles[key] = value.id;
                        titreFiles[key] = value.name_origine;
                        //urlFiles[key] = value.url_viewer;
                        urlFiles[key] = url;
                    });

                    console.log(idFiles);
                    var btn_supprs = $('#id_dropzone_document').find('a.dz-remove');
                    $.each(btn_supprs, function (key, elem) {
                        var a = $(elem);
                        a.attr('id', 'file_' + idFiles[key]);
                        var btn_view_file = '<a class="dz-remove" href="' + urlFiles[key] + '" target="_blank">Visualiser</a>';
                        $(btn_view_file).insertBefore(a);
                    });
                });
            }
        },
        //acceptedFiles: "image/*",
        acceptedFiles: ".doc, .docx, .odt, .pdf, .png, .jpg, .jpeg",
        dictRemoveFile: "Supprimer",
        dictCancelUpload: "Annuler",
    });


    //============
    $('.textarea_editor').wysihtml5({"image": false});
    $('.textarea_editor1').wysihtml5({"image": false});
    $(".select2Cat").select2();
    var select2CustomEvent = $(".select2CustomEvent").select2();
});

function hideShowClass(c, r) {
    if (r == 1) {
        $('.' + c).removeClass('hide');
        $('.b-' + c).addClass('hide');
    } else {
        $('.' + c).addClass('hide');
        $('.b-' + c).removeClass('hide');
        $('#debut-2-' + c).val('');
        $('#fin-2-' + c).val('');
    }
}







