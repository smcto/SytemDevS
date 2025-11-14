Dropzone.autoDiscover = false;

srcUrl = $("div.dropzone").attr('data-srcurl');
base_url = $('#id_baseUrl').val();
targetUrl = srcUrl+"fr/ajax-ventes/upload-devis";

$("div.dropzone").dropzone({
    url: targetUrl,
    timeout: 180000,
    paramName: "file",
    addRemoveLinks : true,
    autoProcessQueue: false,
    acceptedFiles : "image/jpg,image/png,image/gif,image/jpeg",
    thumbnailWidth: null,
    thumbnailHeight: null,
    maxFiles: 100,
    parallelUploads: 100,
    dictRemoveFile: 'Suppression',
    dictDefaultMessage: 'Cliquer ou glisser vos fichiers ici',
    dictInvalidFileType: "Vous ne pouvez pas importez ce type de fichier",
    acceptedFiles: ".doc, .docx, .odt, .pdf, .png, .jpg, .jpeg",
    success: function (file, result, data) {
        if (result.name != undefined) {
            $(file.previewTemplate).append('<input type="hidden" value="' + result.name + '" name="ventes_devis_uploads[][filename]" />')
        }
    },
    queuecomplete: function (a) {
        mainForm = $(dropzone.element).parents('form').first();
        $('.loader-upload').addClass('d-none');
        mainForm.submit();
    },

    init: function (e) {
        dropzone = this;
        mainForm = $(dropzone.element).parents('form').first();
        submited = false; 

        // pré-chargement fichiers crea + édition
        $.getJSON(srcUrl+'fr/ajax-ventes/preloadDevisUploadedInSession', function(data) { // get the json response
            $.each(data, function(key,value){
                var mockFile = { name: value.name, size: value.size }; 
                dropzone.options.addedfile.call(dropzone, mockFile);

                // remove click "suppression"
                $('a.dz-remove').on('click', function () {
                    filename = $(this).parents('.dz-file-preview').find('span[data-dz-name]').text();
                    if ($('.container_devis_uploaded').html() !== undefined) {
                        $.get(srcUrl+'fr/ajax-ventes/remove-devis-uploaded/'+filename, function(data) {
                            if (data.status == 'ok') {
                                $('.container_devis_uploaded[data-filename="'+filename+'"]').remove();
                            }
                        });
                    }
                })
            });
        });

        mainForm.submit(function (e) {
            $('.loader-upload').removeClass('d-none');
            if (dropzone.files.length > 0) {
                if (submited == false) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.processQueue();
                    return false;
                }
            }
        });

        this.on("thumbnail", function(file, dataUrl) {
            $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
            $('.dz-image').last().find('img').attr('src', file.dataURL);
        });

        this.on("sending", function (file, xhr, formData) {
            source = $($(this)[0].element);
        });


        this.on('complete', function(file, dataUrl) {
            fileName = file.name;
            submited = true;

            // mainForm.submit();
        });

    },

});

// ---------- GMAP --------------

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

    function initializeGmap() {
        var lat = $('#txtLatitude').val() != '' ? $('#txtLatitude').val() : 0;
        var lng = $('#txtLongitude').val() != '' ? $('#txtLongitude').val() : 0;
        var latLng = new google.maps.LatLng(lat, lng);
        var address = document.getElementById('client_adresse').value;

        // var latLng = new google.maps.LatLng(48.51418, -2.7658350000000382);
        var map = new google.maps.Map(document.getElementById('mapCanvas'), {
            zoom: 17,
            center: latLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            streetViewControl: false,
            mapTypeControl: false

        });
        
        if(lat && lng) {
            var latLng = new google.maps.LatLng(lat, lng);

            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                draggable: true,
                title:"Vous pouvez glisser-déposer pour la destination souhaitée. Ou dans le champ de recherche, saisissez l'emplacement et sélectionnez."
            });
            
            // Update current position info.
            updateMarkerPosition(latLng);
            //geocodePosition(latLng);
        } else if(address) {

            // initialiser par défaut le marker
            var latLng = new google.maps.LatLng(0, 0);

            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                draggable: true,
                title:"Vous pouvez glisser-déposer pour la destination souhaitée. Ou dans le champ de recherche, saisissez l'emplacement et sélectionnez."
            });
            
            // initialiser le marker avec l'adresse si il y en a
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': address}, function(results, status) {
                if (status == 'OK') {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        draggable: true,
                        title:"Vous pouvez glisser-déposer pour la destination souhaitée. Ou dans le champ de recherche, saisissez l'emplacement et sélectionnez."
                    });
                } 
            });
        } else {

            var latLng = new google.maps.LatLng(0, 0);

            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                draggable: true,
                title:"Vous pouvez glisser-déposer pour la destination souhaitée. Ou dans le champ de recherche, saisissez l'emplacement et sélectionnez."
            });
            
            // Update current position info.
            updateMarkerPosition(latLng);
            //geocodePosition(latLng);
        }

        var input = document.getElementById('client_adresse');
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
            document.getElementById("client_adresse").focus();
            document.getElementById("client_adresse").blur();
            geocodePosition(marker.getPosition());
            document.getElementById("txtLatitude").value = this.getPosition().lat();
            document.getElementById("txtLongitude").value = this.getPosition().lng();
            var lat = parseFloat(document.getElementById("txtLatitude").value);
            var lng = parseFloat(document.getElementById("txtLongitude").value);
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
                // console.log(lat);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }

            marker.setPosition(place.geometry.location);
            updateMarkerPosition(marker.getPosition());
            geocodePosition(marker.getPosition());

            // découper CP et ville auto complete
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (responses, status) {
                if (responses && responses.length > 0) {
                    var elt = responses[0].address_components;

                    // document.getElementById('cp').value = "";
                    // document.getElementById('ville').value = "";
                    if(!$('#is-ville-manuel').is(':checked')) {
                        $('#is-ville-manuel').click();
                    }
                    
                    var address = $('#adresse , #client_adresse').val();
                    var address_array = address.split(', ');
                    
                    for(i in elt){
                        // console.log(elt[i].types[0]);
                        // console.log(address_array);
                        if(elt[i].types[0] == 'postal_code'){
                            $('#client_cp').get(0).value = elt[i].long_name;
                            address_array = address_array.filter(e => e !== elt[i].long_name);
                        }

                        if(elt[i].types[0] == 'locality'){
                            $('input#client-ville').get(0).value = (elt[i].long_name).toUpperCase();
                            address_array = address_array.filter(e => e !== elt[i].long_name);
                        }
                        
                        if(elt[i].types[0] == 'country'){
                            majClientPays($('#country'), elt[i].short_name);
                            address_array = address_array.filter(e => e !== elt[i].long_name);
                        }
                    }
                    // $('#adresse').val(address_array.length !== 0 ? address_array.join() : address);
                    $('#client_adresse').val(address_array[0]);

                }
            });
        });
    }

    // Onload handler to fire off the app.
    google.maps.event.addDomListener(window, 'load', initializeGmap);

    function updateMarkerPosition(latLng) {
        document.getElementById('lat_lng').value = [
            latLng.lat(),
            latLng.lng()
        ].join(', ');
    }

// ---------- END GMAP --------------


baseUrl = $('input#id_baseUrl').attr('value');

// ajout champ mois si loca_fi selectionné
$('select[name="parc_id"]').on('change', function(event) {
    event.preventDefault();
    parc_id = $(this).val();
    // console.log(parc_id)

    parc_duree = $('select[name="parc_duree_id"]');


    if (parc_id == 4 || parc_id == 9) { /*Locafi*/

        $('.nb_mois').removeClass('d-none');
        // parc_duree.attr('required', 'required');
        
        $('.debut_fin').removeClass('d-none');

        urlLoadParcDuree = base_url+'/fr/ajax-ventes/loadParcDurees/'+parc_id;
        parc_duree = $('select#parc-duree-id');
        parc_duree.html('');

        $.get(urlLoadParcDuree, function(data) {
            var option = new Option('Séléctionner', "", true, true);
            parc_duree.append(option);
                
            $.each(data, function (key, value) {
                var option = new Option(value, key, false, false);
                parc_duree.append(option);
            });

            parc_duree.prop('disabled', false);
            parc_duree.selectpicker('refresh');
        });



        // -- Facturation
        $('.container_loca_fi').removeClass('d-none');
        $('.container_achat_direct').addClass('d-none');
    } 
    else if(parc_id == 1 || parc_id == 10) { /*Vente ou borne ocasion*/
        $('.nb_mois').addClass('d-none');
        $('.debut_fin').addClass('d-none');
        parc_duree.removeAttr('required');
        $('.nb_mois_longue_duree').addClass('d-none');
        $('[name="contrat_debut"]').val("")

        // -- Facturation
        $('.container_achat_direct').removeClass('d-none');
        $('.container_loca_fi').addClass('d-none');
    }

    if (parc_id != '') {
        $('.container-facturation').removeClass('d-none')
    } else {
        $('.container-facturation').addClass('d-none')
    }
});

$('select[name="parc_id"]').trigger('change');

//affiche champ propriétaire si agence == 1
$('input[type="checkbox"][name="is_agence"]').on('click', function(event) {
    is_agence = $(this).val();
    proprietaireText = $('textarea[name="proprietaire"]');

    if ($(this).is(':checked')) {
        $('.proprietaire').removeClass('d-none');
        proprietaireText.attr('required', 'required');
    } else {
        $('.proprietaire').addClass('d-none');
        proprietaireText.val('');
        proprietaireText.removeAttr('required');
    }
});

//affiche champ client si client_nonèprésentdanssellsy == 1
commercial_contact_name = '';
commercial_contact_email = '';
commercial_contact_telfixe = '';
commercial_contact_telmobile = '';

client_nom = '';
client_prenom = '';
client_email = '';
client_adresse = '';
client_cp = '';
client_ville = '';
client_telephone = '';
client_telephone_2 = '';
contact_type_id = '';


infoClient = $('.info-client');
blockClient = $('.block-client');

$('button.is_new_client').on('click', function(event) {
    var self = $(this);

    blockClient.find('input , select ').not('[type="checkbox"][name="is_client_not_in_sellsy"]').val('');
    blockClient.find('.selectpicker').not('#client-client-type').selectpicker('val', "");
    $('[name="is_client_belongs_to_group"]').prop('checked', false);
    $('.container-groupe-clients').addClass('d-none');
    $('.container-choix-client .client_id').val("").select2();
    $('[type="checkbox"][name="is_client_not_in_sellsy"]').prop('checked', true);

    initializeGmap();

    is_client_not_in_sellsy = self.hasClass('active');
    // checkIfGroupClientMustBeDisplayed(false, is_client_not_in_sellsy)

    var proprietaireText = $('textarea[name="proprietaire"]');
    var clientSelect = $('select[name="client_id"]');
    $('.alert-choix-client').remove();
    $('#client-client-type').val('corporation').selectpicker('refresh');
    $('#country').val(5).selectpicker('refresh'); // france
});




//affiche liste groupe client si client appartient à un groupe coché
function checkIfGroupClientMustBeDisplayed(client_id, is_client_not_in_sellsy) {
    if (client_id || is_client_not_in_sellsy) {

        $('.container-checkgroupe-clients').removeClass('d-none');
        checkGroupClients();

    } else {
        $('.container-checkgroupe-clients , .container-groupe-clients').addClass('d-none');
    }

    return [client_id, is_client_not_in_sellsy];
}

function checkGroupClients() {
    $('input[name="is_client_belongs_to_group"]').click(function(event) {
        if ($(this).is(':checked')) {
            $('.container-groupe-clients').removeClass('d-none');
        } else {
            $('.container-groupe-clients').addClass('d-none');
        }
    });
}

checkGroupClients();


var trLength = $('tbody.default-data').find('tr').length-1;
$('.add-data').unbind('click');
$('.container-contacts').on('click', '.add-data', function(event) {
    clonedTr = $('tr.clone').last().clone();
    $('tbody.default-data').append(clonedTr).promise().then(function (e) {
        newTr = $('tbody.default-data').find('tr.added-tr').last();
        newTr.find('[input-name="nom"] , [input-name="prenom"] , [input-name="email"]').attr('required', 'required');
        var newTrIndex = eval(newTr.index()+trLength);
        newTr.find("input[input-name] , select[input-name]").each(function(index, el) {
            $(this).attr('name', 'client[client_contacts]'+'['+newTrIndex+']['+$(this).attr('input-name')+']');
        });
        newTr.removeClass('d-none');
    });
});

function removeProd() {
    $('.container-contacts').on('click', ' tbody.default-data #remove-prod', function(event) {
        event.preventDefault();
        
        if (confirm('Êtes vous sûr de vouloir supprimer?')) {
            nbTr = $('tbody.default-data').find('tr').length;
            url = $(this).attr('data-href');
            if (nbTr == 1) {
                alert('Cette ligne ne peut pas être supprimée');
                return false;
            }
            currentTr = $(this).parents('tr');

            if (url) {
                $.get(url, function(data, xhr) {
                    if (data.status == 'success') {
                        currentTr.remove();
                    }
                });
            } else {
                currentTr.remove();
            }

        }
        
    });
}
removeProd();

// affiche contact_client en f° du client choisi, charge les devis
$('.client_id').on('change', function(event) {
    event.preventDefault();

    var client_id = $(this).val();
    var checkboxIsClientSellsy = $('[type="checkbox"][name="is_client_not_in_sellsy"]');
    
    if (client_id != '') {
        checkboxIsClientSellsy.prop('checked', false);
    } else {
        checkboxIsClientSellsy.prop('checked', true);
    }

    // checkIfGroupClientMustBeDisplayed(client_id, false);
    $('.alert-choix-client').remove();

    if (client_id != '') {
        $('div.container-devis-client').remove();
    } else {
    }


    $.get(baseUrl+'fr/ajax-ventes/get-client-documents-devis/'+client_id, function(data) {
        $('.displayed-devis').html(data);
    });

    $.get(baseUrl+'fr/ajax-ventes/get-client/'+client_id, function(data) {
        var dataClient = data;
        var dataClientSecteursActivites = [];
        $.each(dataClient.secteurs_activites, function(index, val) {
            dataClientSecteursActivites.push(val.id);
        });

        if (data.groupe_client_id != null) {
            $('[name="is_client_belongs_to_group"]').prop('checked', true);
            $('.container-groupe-clients').removeClass('d-none');
            $('[name="groupe_client_id"]').selectpicker('val', data.groupe_client_id);
        } else {
            $('[name="is_client_belongs_to_group"]').prop('checked', false);
            $('.container-groupe-clients').addClass('d-none');
        }
        $('#client-client-type').val(data != null ? data.client_type : '');
        $('#client-client-type').selectpicker('refresh');
        $('#client_id').val(data != null ? data.id : '');
        $('#raison_sociale').val(data != null ? data.nom : '');
        $('#enseigne').val(data != null ? data.enseigne : '');
        $('#client-telephone').val(data != null ? data.telephone : '');
        $('#client-telephone-2').val(data != null ? data.telephone_2 : '');
        $('#client-email').val(data != null ? data.email : '');
        $('#client_adresse').val(data != null ? data.adresse : '');
        $('#client_adresse_2').val(data != null ? data.adresse_2 : '');
        $('#client-tva-intra-community').val(data != null ? data.tva_intra_community : '');
        $('#client-siren').val(data != null ? data.siren : '');
        $('#client-siret').val(data != null ? data.siret : '');
        $('#client-secteurs-activites-ids').val(dataClientSecteursActivites).select2();

        var cpVal = data != null ? (data.cp ? data.cp.trim() : '') : '';
        var ville = data != null ? (data.ville ? data.ville.trim() : '') : '';
        $('#client_cp').val(cpVal);

        var listVille = $('select.list_ville');

        emptyOption = listVille.find('option[value=""]').text();
        $.get(baseUrl+'/fr/AjaxVillesCodePostals/getByCp/'+cpVal, function(dataListVille) {
            if (dataListVille) {
                var option = new Option(emptyOption, "", true, true);
                listVille.html('');
                listVille.append(option);
                    
                $.each(dataListVille, function (key, value) {
                    var option = new Option(value, key, false, false);
                    listVille.append(option);
                });
                
                listVille.selectpicker('refresh').selectpicker('val', ville);

                var isVilleExists = false;
                $.each(dataListVille, function (i, val) {
                    if (val === ville) {
                        isVilleExists = true;
                    }
                })
                
                console.log(dataClient.ville)
                if (dataClient.ville == '' && !$.isEmptyObject(dataListVille)) {
                    $('.bloc-ville .select').removeClass('d-none');
                    $('.bloc-ville .input').addClass('d-none');
                }
                else if (isVilleExists == false) { // si ville n'existe pas on rempli manuellement
                    $('[name="is_ville_manuel"]').prop('checked', true);
                    $('.bloc-ville .select').addClass('d-none');
                    $('.bloc-ville .input').removeClass('d-none');
                    $('.bloc-ville .input #client-ville').removeAttr('disabled').val(ville);
                }
            } else {
                if (cpVal != '') {
                    $('[name="is_ville_manuel"]').trigger('click');
                    $('input#client-ville').val(ville);
                }
            }

            return true;
        });

    });

    
    $.get(baseUrl+'fr/ajax-ventes/venteClientsContact/'+client_id, function(data) {
        $('.container-contacts').html(data);
    });


    // si on a déjà choisi un client dans la 1ère liste déroulante, on viendra l’afficher par défaut ici
    $('.livr_client_id').selectpicker('val', client_id);

    // charge latlng gmap

    $.get(baseUrl+'fr/ajax-ventes/get-contact-client/'+client_id, function(data) {

        if (data != false) {
            var client_adresse = $('#client_adresse').val(data != null ? data.adresse : '');

            lat = data != null ? data.addr_lat : '';
            lng = data != null ? data.addr_lng : '';

            $('#txtLatitude').val(lat);
            $('#txtLongitude').val(lng);


            var client_latLng = new google.maps.LatLng(lat, lng);
            var client_map = new google.maps.Map(document.getElementById('mapCanvas'), {
                zoom: 6,
                center: client_latLng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false,
                mapTypeControl: false
            });

            var client_latLng = new google.maps.LatLng(lat, lng);
            var client_marker = new google.maps.Marker({
                position: client_latLng,
                map: client_map,
                draggable: true,
            });

            updateMarkerPosition(client_marker.getPosition());
            geocodePosition(client_marker.getPosition());
            if ((lat+lng) || client_adresse) {
                initializeGmap();
            }
        }
    });
    
});


// si ajout contact commercial
oldText = '';
if ($('a.add-contact-commercial').hasClass('active')) {
    oldText = 'Ajouter un contact commercial?';
}

$('a.add-contact-commercial').click(function(event) {
    if (!$(this).hasClass('active')) {
        oldText = $(this).html();
        $(this).html("Annuler l'ajout du contact commercial?");
        $(this).addClass('active');
        $('.row-contacts').removeClass('d-none');
        $('.row-contacts').find('input , select').removeAttr('disabled');
    } else {
        $(this).html(oldText).removeClass('active');
        $('.row-contacts').addClass('d-none');
        $('.row-contacts').find('input , select').attr('disabled', 'disabled');
    }
});

$('.dropify-fr').dropify({
    messages: {
        default: 'Glissez-déposez un fichier ici ou cliquez',
        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
        remove: 'Supprimer',
        error: "Veuillez vérifier votre fichier"
    },
    error: {
        fileExtension: "Ce type de fichier n'est pas permis, (Choisir uniquement un fichier au format : {{ value }})."

    }
});

$('div.container_facturation_achat_type input[type="radio"]').click(function(event) {
    facturation_achat_type = $(this).val();
    if (facturation_achat_type == 0) {
        $('div.containr_facturation_other_entity').addClass('d-none');
        $('div.containr_facturation_other_entity').find('input').attr('disabled', 'disabled');

    } else 
    // Facturer une autre entité
    if (facturation_achat_type == 1) {
        $('div.containr_facturation_other_entity').find('input').removeAttr('disabled');
        $('div.containr_facturation_other_entity').removeClass('d-none');
    }
});


// ----------------- VALIDATION --------------------

// Ville saisi manuel input ou select

$('#client_cp').on('blur', function(event) {
    event.preventDefault();

    cpVal = $(this).val();
    loadVilleByCp(cpVal);
});

function loadVilleByCp(cpVal) {

    listVille = $('select.list_ville');

    emptyOption = listVille.find('option[value=""]').text();
    $.get(baseUrl+'/fr/AjaxVillesCodePostals/getByCp/'+cpVal, function(data) {
        var option = new Option(emptyOption, "", true, true);
        listVille.html('');
        listVille.append(option);
            
        $.each(data, function (key, value) {
            var option = new Option(value, key, false, false);
            listVille.append(option);
        });
        
        listVille.selectpicker('refresh');

        return true;
    });

    return false;
}

$('[name="is_ville_manuel"]').click(function(event) {
    if ($(this).is(':checked')) {
        $('.bloc-ville .select').addClass('d-none');
        $('.bloc-ville .input').removeClass('d-none');
        $('.bloc-ville .input .client_text').removeAttr('disabled');
    } else {
        $('.bloc-ville .select').removeClass('d-none');
        $('.bloc-ville .input').addClass('d-none');
        $('.bloc-ville .input .client_text').attr('disabled', 'disabled');
    }
});