$(document).ready(function() {

    var srcUrl = $("#id_baseUrl").attr('value');
    var type_client = $("#client-genre").val();
    
    $("#client-genre").on('change', function() {
        type_client = $(this).val();
        initAjaxClient(srcUrl, type_client);
    });
    
    $('.select2').each(function() { 
        $(this).select2({ 
            dropdownParent: $(this).parent(),
            allowClear: true
        });
    });
    
    initAjaxClient(srcUrl, type_client);
    
    $('.radios-client-1').on('change', function () {
        $('.nouveau-client').addClass('hide');
        $('#client-id').prop('required',true);
        $('.client-required').prop('required',false);
        $('.existing-client').removeClass('hide');
    });
    $('.radios-client-1').trigger('change');

    $('.radios-client-2').on('change', function () {
        $('.nouveau-client').removeClass('hide');
        $('#client-id').prop('required',false);
        $('.client-required').prop('required',true);
        $('.existing-client').addClass('hide');
    });
    
    $('.radios-client-3').on('change', function () {
        $('.nouveau-client').addClass('hide');
        $('#client-id').prop('required',false);
        $('.client-required').prop('required',false);
        $('.existing-client').addClass('hide');
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
    
    
    $('#add_devis_factures').on('shown.bs.modal', function(e) {
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
        modal.find('#facture_id').val(link.attr('data-facture'));
    });
    
    $('#form_client_2').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        modal.find('#title').text(link.attr('data-title'));
        modal.find('#facture_id_2').val(link.attr('data-devi'));
    });
    
    $('#edit_commercial').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        modal.find('#title').text(link.attr('data-title'));
        modal.find('#facture_id').val(link.attr('data-facture'));
    });
    
    $('.duplicate-facture').on('click', function(){
        $('.fieldset-devis-factures').addClass('hide');
        $('#type_doc_id').attr('required', false);
        $('.for-duplicat').removeClass('hide');
    });
    
    $('.create-facture').on('click', function(){
        $('.fieldset-devis-factures').removeClass('hide');
        $('.for-duplicat').addClass('hide');
    });
    
    // si période personnalisée : on affiche un date picker qui permet de gérer une période.
    // console.log($('input[name="date_threshold"]').val());
    $('input[name="date_threshold"]').daterangepicker({
        locale: {
            "format": 'DD/MM/YYYY',
            "separator": " - ",
            "applyLabel": "Appliquer",
            "cancelLabel": "Annuler",
            "fromLabel": "De",
            "toLabel": "À",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "firstDay": 1,
        }
    });

    $('#id_periode').on('change', function(event) {
        if ($(this).val() == 'custom_threshold') {
            $('.container_date_threshold').removeClass('d-none');
            $('.container-mois').addClass('d-none');
        } else if ($(this).val() == 'list_month') {
            $('.container-mois').removeClass('d-none');
        }
        else {
            $('.container_date_threshold').addClass('d-none');
            $('.container-mois').addClass('d-none');
        }
    });
    
    $('#category').on('change', function(){
        var cat = $(this).val();
        var sousCategories = modelSousCategories[cat];
        var option = '<option value>Sous catégorie du modèle</option>';
        $.each(sousCategories, function(key, value){
            option += '<option value="'+key+'">'+value+'</option>';
        });
        $('#sous_category').html(option);
        $('.sous-cat').removeClass('hide');
        modelDevisFactures();
    });

    $('#sous_category').on('change', function(){
        modelDevisFactures();
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

function initAjaxClient(src, type_client) {
    
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
                url: src + "fr/ajax-clients/search-client/" + type_client,
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
}

