
jQuery(document).ready(function($) {
    
    tbody = $('tbody.default-data');
    grandTotal = 0;

    tbody.find('.montant-ht').each(function(index, el) {
        currentTr = $(this).parents('tr');
        remis_val = parseFloat(currentTr.find('.remis_val').val());
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
    
    $('.select2').each(function() { 
        $(this).select2({ 
            dropdownParent: $(this).parent(),
            allowClear: true
        });
    });
    
    $('.js-data-client-ajax').select2({
        dropdownParent: $("#duplicat_avoir"),
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
    
    $('.radios-client-1').on('change', function () {
        $('.nouveau-client').addClass('hide');
        $('#client-id').prop('required',true);
        $('.client-required').prop('required',false);
    });
    $('.radios-client-1').trigger('change');

    $('.radios-client-2').on('change', function () {
        $('.nouveau-client').removeClass('hide');
        $('#client-id').prop('required',false);
        $('.client-required').prop('required',true);
    });

    $('.show-list-status').on('click', function() {
        if($(this).hasClass('fa-sort-desc')) {
            $('.liste-status').removeClass('hide');
            $('.show-list-status').removeClass('fa-sort-desc');
            $('.show-list-status').addClass('fa-sort-asc');
        } else {
            $('.liste-status').addClass('hide');
            $('.show-list-status').removeClass('fa-sort-asc');
            $('.show-list-status').addClass('fa-sort-desc');
        }
    });
    
    $('#change_status').on('change', function() {
        var avoir_id = $('#avoir_id').val();
        var value = $(this).val();
        $.ajax({
            url: srcUrl + 'fr/ajax-avoirs/edit-etat/' + avoir_id,
            type: "POST",
            dataType: 'json',
            data: {
                status: value
            },
            success: function(data) {
                if (data.status == 1) {
                    $('.status-devis').html('<small><i class="fa fa-circle ' + data.value + ' font-12" data-toggle="tooltip" data-placement="top" title="' + data.devis_status + '" data-original-title="Brouillon"></i> ' + data.devis_status + '</small>');
                    $('.liste-status').addClass('hide');
                    $('.show-list-status').removeClass('fa-sort-asc');
                    $('.show-list-status').addClass('fa-sort-desc');
                }
            },
            error: function(data) {
                console.log('Erreur:', data);
            },
        });
    });
    
});