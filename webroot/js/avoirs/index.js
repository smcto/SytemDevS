$(document).ready(function() {

    var srcUrl = $("#id_baseUrl").attr('value');
    
    $('.select2').each(function() {
        $(this).select2({
            dropdownParent: $(this).parent(),
            allowClear: true
        });
    });

    
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

    $('#group_radios_client_1').on('change', function () {
        $('#nouveau-client').addClass('hide');
        $('#client-id').removeClass('hide').prop('required',true);
        $('.client-required').prop('required',false);
    });

    $('#group_radios_client_2').on('change', function () {
        $('#nouveau-client').removeClass('hide');
        $('#client-id').addClass('hide').prop('required',false);
        $('.client-required').prop('required',true);
    });


    $('#facture_status').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var url = link.attr('data-href');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
        $('#modif_status').val(link.attr('data-value'));
        modal.find('.num_facture').text(link.attr('data-indent'));
    });
    
    
    $('#add_avoirs').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var url = link.attr('data-href');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
        modal.find('#title').text(link.attr('data-title'));
        modal.find('.btn-submit').text(link.attr('data-submit'));
    });
    
    $('#edit_client').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        modal.find('#title').text(link.attr('data-title'));
        modal.find('#avoir_id').val(link.attr('data-avoir'));
    });

    $('#edit_commercial').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        modal.find('#title').text(link.attr('data-title'));
        modal.find('#avoir_id').val(link.attr('data-avoir'));
    });
    
    $('.duplicate-facture').on('click', function(){
        $('.fieldset-devis-factures').addClass('hide');
    });
    
    $('.create-facture').on('click', function(){
        $('.fieldset-devis-factures').removeClass('hide');
    });
    
    // si période personnalisée : on affiche un date picker qui permet de gérer une période.
    $('input[name="date_threshold"]').daterangepicker({
        locale: {
            // "format": 'YYYY-MM-DD',
            "format": 'DD/MM/YYYY',
            "separator": " - ",
            "applyLabel": "Appliquer",
            "cancelLabel": "Annuler",
            "fromLabel": "De",
            "toLabel": "À",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "firstDay": 1
        }
    });

    $('#id_periode').on('change', function(event) {
        if ($(this).val() == 'custom_threshold') {
            $('.container_date_threshold').removeClass('d-none');
            $('.container-mois').addClass('d-none');
        }
        else if ($(this).val() == 'list_month') {
            $('.container-mois').removeClass('d-none');
        } else {
            $('.container_date_threshold').addClass('d-none');
            $('.container-mois').addClass('d-none');
        }
    });
    
    // AC des villes cf. CP saisi
    $('.cp').on('blur', function(event) {
        event.preventDefault();

        cpVal = $(this).val();
        listVille = $('select.list_ville');
        
        // after ajax callback
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
        });   
    });


    // getCountFacture();
});

function getCountFacture(){
    var srcUrl = $("#id_baseUrl").attr('value');
    var idInSellsy = $("#id_inSellsy").val();
    var data = {
        keyword : $("#id_keyword").val(),
        ref_commercial_id : $("#id_ref_commercial_id").val(),
        client_type : $("#id_client_type").val(),
        antennes_id : $("#id_antenne_id").val(),
        periode : $("#id_periode").val(),
        status :  $("#id_status").val(),
        date_threshold : $("#id_date_threshold").val()
    };

    $.ajax({
        url: srcUrl + 'fr/devisFactures/countFacture/'+idInSellsy,
        type: "GET",
        data : data,
        dataType: 'json',
        success: function(data) {
            $("#id_totalHT").html(data.total_ht);
            $("#id_totalTTC").html(data.total_ttc);
        },
        error: function(data) {
            //console.log('Erreur:', data);
        }
    });
}

function modelDevisFactures() {
    var cat = $('#category').val();
    var sCat = $('#sous_category').val();
    var srcUrl = $("#id_baseUrl").attr('value');
    $.ajax({
        url: srcUrl + 'fr/ajax-devis-factures/get-model-devis-factures?cat=' + cat + '&sous-cat=' + sCat,
        type: "GET",
        dataType: 'json',
        success: function(data) {
            if (data.status == 1) {
                var option = '<option value>Modèle factures</option>';
                $.each(data.devis_factures, function(key, value){
                    option += '<option value="'+key+'">'+value+'</option>';
                });
                $('#model_devis_factures').html(option);
            }
        },
        error: function(data) {
            console.log('Erreur:', data);
        }
    });
}
