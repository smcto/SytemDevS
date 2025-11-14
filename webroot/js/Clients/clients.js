var baseUrl = "";
$(document).ready(function() {
    baseUrl = $("#id_baseUrl").val();

    $(".id_syncrho").click(function(e) {
        e.preventDefault();
        $(".kl_loadingclient").hide();
        
        url = $(this).attr('href');
        //alert('test');
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                return xhr;
            },
            type: 'GET',
            url: url,
            data: {},
            beforeSend: function() {
                $('.kl_loadingclient').show();
            },
            complete: function() {
                $(".kl_loadingclient").hide();
            },
            success: function(data) {
                //Do something success-ish
            }
        });


        return false;

    });

    $('#edit_client').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var url = link.attr('data-href');
        var client_id = link.attr('data-client');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
        document.getElementById("form-edit-client").reset();
        $.get(baseUrl + 'fr/ajax-clients/get-client-by-id/' + client_id, function(data, xhr) {
            if (data.status == '1') {
                var client = data.client;
                console.log(client)
                $('#client-type').val(client.client_type);
                $('#nom').val(client.nom);
                $('#prenom').val(client.prenom);
                $('#enseigne').val(client.enseigne);
                $('#adresse').val(client.adresse);
                $('#adresse-2').val(client.adresse_2);
                listVille = $('select.list_ville');
                if(client.ville) {
                    var option = new Option(client.ville, client.ville, true, true);
                    listVille.append(option);
                } else {
                    listVille.html('');
                }
                listVille.selectpicker('refresh');
                $('#cp').val(client.cp);
                $('#is-ville-manuel').attr('checked',client.is_ville_manuel);
                $('#telephone').val(client.telephone);
                $('#telephone-2').val(client.telephone_2);
                $('#email').val(client.email);
                $('#tva-intra-community').val(client.tva_intra_community);
                $('#siren').val(client.siren);
                $('#siret').val(client.siret);
                $('#type-commercial').val(client.type_commercial);
                $('#is-location-event').attr('checked',client.is_location_event);
                $('#is-location-financiere').attr('checked',client.is_location_financiere);
                $('#is-location-lng-duree').attr('checked',client.is_location_lng_duree);
                $('#is-borne-occasion').attr('checked',client.is_borne_occasion);
                $('#is-vente').attr('checked',client.is_vente);
                $('#is-location-financiere').attr('checked',client.is_location_financiere);
                $('#is-location-lng-duree').attr('checked',client.is_location_lng_duree);
                $('#is-borne-occasion').attr('checked',client.is_borne_occasion);
                $('#groupe-client-id').val(client.groupe_client_id);
                // $('.secteurs_activites').selectpicker('val', [2]);
                $('.secteurs_activites').val(client.secteurs_activites_ids).trigger('change');;
                $('#connaissance-selfizee').val(client.connaissance_selfizee);
                $('#client-type').trigger('change');
                $('#country').val(client.pays_id);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    });
    

    $('.multi-actions').on('submit', function() {
        if($('#action').val() === 'delete') {
            if(confirm('Êtes-vous sûr de vouloir supprimer?')) {
                return true;
            }
            return false;
        }
        if($('#action').val() === 'secteurActivite' && $('#secteurs-activites-ids').val() == '') {
            $("#secteur-activite").modal('show');
            
            return false;
        }
        return true;
    });
    
    $('#action').on('change', function () {
        if($(this).val() === 'secteurActivite') {
            $("#secteur-activite").modal('show');
        }
    });
    
    $('#secteur-activite').on('hide.bs.modal', function() {
        $('#secteurs-activites-ids').val('');
        $('.selectpicker').selectpicker('refresh');
    });

    $('.btn-submit-secteur-activite').on('click', function () {
        $('.multi-actions').submit();
    });
    
    $('.delete-client').on('click', function () {
        var clientId = $(this).parents('td').find('#client-id').val();
        if(clientId != 'undefined') {
            if(confirm('Êtes-vous sûr de vouloir supprimer?')) {
                window.location.replace(baseUrl + 'fr/clients/delete-client/' + clientId);
            }
        }
    });
    
    
    $('#checkbox-secteur-activite').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var url = link.attr('data-href');
        var client_id = link.attr('data-client');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
        document.getElementById("form-checkbox-secteur-activite").reset();
        $.get(baseUrl + 'fr/ajax-clients/get-client-by-id/' + client_id, function(data, xhr) {
            if (data.status == '1') {
                var client = data.client;
                $.each(client.secteurs_activites_ids, function (key, value) {
                    document.getElementById("secteurs-activites-ids-" + value).checked = true;
                });
            }
        });
    });
    
});