// ajout class .hide-table-empty sur table pour cacheer les theads à border-top visibles
$('.hide-table-empty thead, .hide-table-empty tbody').each(function(index, el) {
    if ($(this).text().trim() == '') {
        $(this).find('tr').css({ 'visibility': 'hidden', 'border': '0' });
        $(this).css({ 'visibility': 'hidden' })
    }
});

// Tjr utilisé
function sum(x, y) {
    return x + y;
}

// dispatché dans les scripts de chq page
function getBaseUrl() {
    return $('#id_baseUrl').val();
}

baseURL = base_url = baseUrl = srcUrl = getBaseUrl();

$('span.br').each(function(index, el) {
    if ($.trim($(this).text()) != '') {
        $(this).append('<br/>');
    }
});

// -- utilisé dans les tableaux de récap
function removeIfEmptyTr() {
    $('.table-recap tr:not(.d-none , .show)').find('td:eq(1):not(.d-none)').each(function(index, el) {
        if ($.trim($(this).text()) == '') {
            $(this).parents('tr').addClass('d-none');
        }
    });
}

$(window).bind("load", function() {
    // utilisé souvent
    if ($('.load-ajax-client').html() != 'undefined') {
        $('.load-ajax-client').select2({
            dropdownParent: $("body"),
            minimumInputLength: 2,
            language: {
                inputTooShort: function() {
                    return "Veuillez saisir 2 caractères ou plus";
                }
            },
            ajax: {
                url: srcUrl + "fr/ajax-clients/search-client",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        nom: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }
});

if ($('select.select2').length) {
    $('select.select2').select2();
}

$("input.onlyint").on('input', function (e) {
    $(this).val($(this).val().replace(/[^0-9]/g, ''));
});

var majClientPays = function (el, isoPays) {
    $.get(baseUrl+'fr/payss/findByShortName/'+isoPays, function(data) {
        $(el).val(data.id);
        if ($(el).hasClass('selectpicker')) {
            $(el).selectpicker('refresh');
        }
    });
}

// === Customize dropdown for inner table menu on tables on Firefox ===

if( navigator.userAgent.indexOf("Firefox") > -1 ) {

    $('.table tbody td .inner-table-menu .dropdown-menu .dropdown-item').css('padding', '8px 34px 8px 20px');

}

// === End of section to Customize dropdown for inner table menu on tables on Firefox ===


// === Unset overflow for table-responsive element ===

$(document).on('click', '.table tbody td .inner-table-menu button[data-toggle="dropdown"]', function(){

    if( window.matchMedia('(min-width: 768px)').matches ) {

        $(this).parents('.table-responsive').addClass('no-overflow');

        if( $(this).parents('.table').outerWidth(true) > $(this).parents('.table-responsive')[0].scrollWidth ) {
            $(this).parents('.table-responsive').scrollLeft( $(this).parents('.table-responsive').scrollLeft() );
        }

    }

});



/* $(document).on('click', function(e) {

    if( $(e.target).closest( $('.table tbody td .inner-table-menu button[data-toggle="dropdown"]') ).length === 1 ) {

        if( window.matchMedia('(min-width: 768px)').matches ) {

            $('.table-responsive').addClass('no-overflow');

            if( $('.table').outerWidth(true) > $('.table-responsive')[0].scrollWidth ) {
                $('.table-responsive').scrollLeft( $('.table-responsive').scrollLeft() );
            }
        }
    }

}); */


$(document).on('click', function(e){

    //if( $(e.target).closest( $('.table tbody td .inner-table-menu .dropdown-menu.show') ).length === 0 || $(e.target).closest( $('.table tbody td .inner-table-menu button[data-toggle="dropdown"]') ).length === 1 ) {

    if( $(e.target).closest( $('.table tbody td .inner-table-menu .dropdown-menu.show') ).length === 0 && $(e.target).closest( $('.table tbody td .inner-table-menu button[data-toggle="dropdown"]') ).length === 0 ) {

        if( window.matchMedia('(min-width: 768px)').matches ) {

            $('.table-responsive').removeClass('no-overflow');
            $('.table-responsive').scrollLeft(0);

        }
    }

});


$(window).resize(function(){

    if( window.matchMedia('(min-width: 768px)').matches ) {
        $('.table-responsive').removeClass('no-overflow');
        $('.table-responsive').scrollLeft(0);
    }

});

// === End of section to Unset overflow for table-responsive element ===



