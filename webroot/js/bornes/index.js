$(document).ready(function() {
    
    
        $(".select2").select2({
            allowClear: true
        });
        
    var base_url = $('#id_baseUrl').val();

    $('select#gamme_borne_id').on('change', function(event) {
        event.preventDefault();
        gamme_borne_id = $(this).val();

        urlLoadModelBorneByGamme = base_url+'/fr/ajax-ventes/loadModelBorneByGamme/'+gamme_borne_id+'.json';
        model_borne = $('select#model_borne_id');
        model_borne.html('');


        $.get(urlLoadModelBorneByGamme, function(data) {
            var option = new Option( 'Séléctionner un modèle', "", true, true);
            model_borne.append(option);
            
            $.each(data, function (clef, valeur) {
                var option = new Option(valeur, clef, false, false);
                model_borne.append(option);
            });
            model_borne.prop('disabled', false);
        });
    });

    $('.expand-filters').click(function() {
        $('div.optional-filter').toggleClass('d-none');
        if($('div.optional-filter').hasClass('d-none') == true) {
            $('.input_more_filter').val(0)
            $('.expand-filters').html('<u>+ de filtres</u>');
            $('.filter-2').removeClass('col-md-3');
        } else {
            $('.input_more_filter').val(1);
            $('.expand-filters').html('<u>- de filtres</u>');
            $('.filter-2').addClass('col-md-3');
        }
    });

    if ($('.input_more_filter').val() == 1) {
        $('div.optional-filter').toggleClass('d-none');
    }
});





// === Filter List Wrapper for Bornes ===

// Call function to set borne filter block
setBorneFilterBlocks();


$(window).resize(function(){

    // Call function to set borne filter block
    setBorneFilterBlocks();

});


// Function to set borne filter block
function setBorneFilterBlocks() {

    var splitUrl = window.location.href.split('/');
    var id = splitUrl[ splitUrl.length - 1 ];

    if( id == 3 || id == 11 ) {

        $('.borne-filter-wrapper .filter-block:nth-last-child(2), .borne-filter-wrapper .filter-block:nth-last-child(3), .borne-filter-wrapper .filter-block:nth-last-child(4)').css('flex', '0 1 calc( 100% / 5.3 )');

        if( window.matchMedia('(min-width: 1015px)').matches && window.matchMedia('(max-width: 1238px)').matches ) {

            $('.borne-filter-wrapper .filter-block:nth-last-child(3), .borne-filter-wrapper .filter-block:nth-last-child(4)').css('flex', '1 1 calc( 100% / 5.2 )');

            $('.borne-filter-wrapper .filter-block:nth-last-child(2)').css('flex', '0 1 calc( 100% / 4.2 )');

        } else if( window.matchMedia('(min-width: 768px)').matches && window.matchMedia('(max-width: 1014px)').matches ) {

            $('.borne-filter-wrapper .filter-block:nth-last-child(3), .borne-filter-wrapper .filter-block:nth-last-child(4)').css('flex', '1 1 calc( 100% / 4 )');

            $('.borne-filter-wrapper .filter-block:nth-last-child(2)').css('flex', '0 1 calc( 100% / 3.15 )');

        } else if( window.matchMedia('(max-width: 767px)').matches ) {

            $('.borne-filter-wrapper .filter-block:nth-last-child(2), .borne-filter-wrapper .filter-block:nth-last-child(3), .borne-filter-wrapper .filter-block:nth-last-child(4)').css('flex', '1 1 100%');
        }

    }

}

// === End of Filter List Wrapper for Bornes ===
