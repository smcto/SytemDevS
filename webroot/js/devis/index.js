$(document).ready(function() {

//    $(".select2").select2({
//        dropdownParent: $("#add_devis"),
//        allowClear: true
//    });
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

    $('#devis_status').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var url = link.attr('data-href');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
        $('#modif_status').val(link.attr('data-value'));
        $('#devis_id').val(link.attr('data-devis'));
        modal.find('.num_devis').text(link.attr('data-indent'));
    });

    $('#add_devis').on('shown.bs.modal', function(e) {
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
        modal.find('#devi_id').val(link.attr('data-devi'));
    });
    
    $('#form_client_2').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        modal.find('#title').text(link.attr('data-title'));
        modal.find('#devi_id_2').val(link.attr('data-devi'));
    });
    
    $('#edit_commercial').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        modal.find('#title').text(link.attr('data-title'));
        modal.find('#devi_id').val(link.attr('data-devi'));
    });
    
    $('#bons_commande').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var url = link.attr('data-href');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
        $('#bl_devi_id').val(link.attr('data-devis'));
    });

    $('.duplicate-devis').on('click', function(){
        $('.fieldset-devis').addClass('hide');
        $('#type_doc_id').attr('required', false);
        $('.for-duplicat').removeClass('hide');
    });
    
    $('.create-devis').on('click', function(){
        $('.fieldset-devis').removeClass('hide');
        $('#type_doc_id').attr('required', true);
        $('.for-duplicat').addClass('hide');
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
            $('.custom-col-width').addClass('custom-col-width-small')
            $('.container-mois').addClass('d-none');
        } 
        else if ($(this).val() == 'list_month') {
            $('.container-mois').removeClass('d-none');
        }
        else {
            $('.container_date_threshold').addClass('d-none');
            $('.custom-col-width').removeClass('custom-col-width-small')
            $('.container-mois').addClass('d-none');
        }
    });
    
    $('.multi-actions').on('submit', function() {
        if($('#action').val() === 'delete') {
            if(confirm('Etes-vous sûr de vouloir supprimer ?')) {
                return true;
            }
            return false;
        }
        return true;
    });
    
    
    $('form#form-edit-status').on('submit', function(e) {
        e.preventDefault();
        var devis_id = $('#devis_id').val();
        var value = $('#modif_status').val();
        $.ajax({
            url: srcUrl + 'fr/ajax-devis/edit-etat/' + devis_id,
            type: "POST",
            dataType: 'json',
            data: {
                status: value
            },
            success: function(data) {
                if (data.status == 1) {
                    $('.status-devis').html('<small><i class="fa fa-circle ' + data.value + ' font-12" data-toggle="tooltip" data-placement="top" title="' + data.devis_status + '" data-original-title="Brouillon"></i> ' + data.devis_status + '</small>');
                    $('.liste-status').addClass('hide');
                    $('.show-list-status .fa').removeClass('fa-sort-asc');
                    $('.show-list-status .fa').addClass('fa-sort-desc');
                    if(value === 'accepted' || value === 'billing') {
                        displayGifImage();
                        $(document).on('click', function(){
                            location.reload();
                        });
                        //setTimeout(function() { location.reload(); } , 3000);
                        
                    } else {
                        location.reload();
                    }
                }
            },
            error: function(data) {
                console.log('Erreur:', data);
            },
        });
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
        modelDevis();
    });

    $('#sous_category').on('change', function(){
        modelDevis();
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

//    getCountDevise();

    $('.custom-selectpicker').selectpicker();
    
    
    $('.delete-devis').on('click', function () {
        var devis = $(this).parents('td').find('#delete-devi-id').val();
        if(devis != 'undefined') {
            if(confirm('Êtes-vous sûr de vouloir supprimer?')) {
                window.location.replace(baseUrl + 'fr/devis/delete/' + devis);
            }
        }
    });


    // Objet du document
    $('.tinymce').tinymce({
        language: 'fr_FR',
        menubar: false,
        plugins: ['advlist autolink link imagetools spellchecker lists autoresize'],        
        toolbar: 'bold italic underline strikethrough |bullist numlist | link removeformat ',
        relative_urls : false,
        contextmenu: false,
        remove_script_host : false,
        convert_urls : false,
        branding: false,
        statusbar: false,
      });
      
      $('#type-date').on('change', function () {
          if ($(this).val() === '3') {
              $('.date-bc').removeClass('hide');
          }else {
              $('.date-bc').addClass('hide');
          }
      });

});

function getCountDevise(){
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
        url: srcUrl + 'fr/devis/countDevise/'+idInSellsy,
        type: "GET",
        data : data,
        dataType: 'json',
        success: function(data) {
            $("#id_totalDevise").html(data.count_devise);
        },
        error: function(data) {
            //console.log('Erreur:', data);
        }
    });
}

function modelDevis() {
    var cat = $('#category').val();
    var sCat = $('#sous_category').val();
    var srcUrl = $("#id_baseUrl").attr('value');
    $.ajax({
        url: srcUrl + 'fr/ajax-devis/get-model-devis?cat=' + cat + '&sous-cat=' + sCat,
        type: "GET",
        dataType: 'json',
        success: function(data) {
            if (data.status == 1) {
                var option = '<option value>Modèle devis</option>';
                $.each(data.devis, function(key, value){
                    option += '<option value="'+key+'">'+value+'</option>';
                });
                $('#model_devis').html(option);
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




