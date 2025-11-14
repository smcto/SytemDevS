
jQuery(document).ready(function($) {
    
    tbody = $('tbody.default-data');
    grandTotal = 0;

    tbody.find('.montant-ht').each(function(index, el) {
        currentTr = $(this).parents('tr');
        remis_val = parseFloat(currentTr.find('.remis_val').val()!=''?currentTr.find('.remis_val').val():0);
        remise_unity = currentTr.find('.remise_unity').val();
        prix_reference_ht = parseFloat(currentTr.find('.prix_reference_ht').val());
        qty = parseFloat(currentTr.find('.qty').val());

        total = prix_reference_ht * qty;
        if(remise_unity == '%'){
            total = total-(total*remis_val/100);
        } else if (remise_unity == '€') {
            total = total-remis_val;
        }
        $(this).text(total.toFixed(2));
        
        if( ! $(this).hasClass('ligne-option')) {
            grandTotal = sum(grandTotal, total);
        }
    });
    
    remisGlobalVal = parseFloat($('.remise-global-value').val());
    remiseGlobalUnity = $('.remise-global-unity').val();
    reductionHT = 0;
    TotalApresReduction = grandTotal;
    
    if(remisGlobalVal){
        if(remiseGlobalUnity == '%'){
            reductionHT = (remisGlobalVal/100) * grandTotal;
        }else {
            reductionHT = remisGlobalVal;
        }
        TotalApresReduction = grandTotal - reductionHT;
    }
    
    montantTTC = 1.2 *TotalApresReduction;
    
    $('.total_general_ht').text(grandTotal.toFixed(2));
    $('.total_general_tva').text((0.2 *TotalApresReduction).toFixed(2));
    $('.total_general_ttc').text(montantTTC.toFixed(2));
    $('.remise-global-ht').text(reductionHT.toFixed(2));
    $('.total-after-remise').text(TotalApresReduction.toFixed(2));
    
    accompteVal = parseFloat($('.accompte-value').val());
    accompteUnity = $('.accompte-unity').val();
    accompte = 0;
    if(accompteUnity == '%') {
        accompte = accompteVal*montantTTC/100;
        $('.accompte').html(accompteVal + accompteUnity + '<br>' + accompte + ' €');
    } else {
        $('.accompte').html(accompteVal + accompteUnity);
    }
});

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
    
    $('.show-list-status').on('click', function() {
        if($('.show-list-status .fa').hasClass('fa-sort-desc')) {
            $('.liste-status').removeClass('hide');
            $('.show-list-status .fa').removeClass('fa-sort-desc');
            $('.show-list-status .fa').addClass('fa-sort-asc');
        } else {
            $('.liste-status').addClass('hide');
            $('.show-list-status .fa').removeClass('fa-sort-asc');
            $('.show-list-status .fa').addClass('fa-sort-desc');
        }
    });
    
    $('#change_status').on('change', function() {
        var devis_id = $('#devis_id').val();
        var value = $(this).val();
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
                    }
                }
            },
            error: function(data) {
                console.log('Erreur:', data);
            },
        });
    });
});


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
