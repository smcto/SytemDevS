$(document).ready(function() {

    // si case Même contact que le client coché affiche l'adresse comme dans un e-comm < Seb?
    $('input#project_is_same_contact_as_client').click(function(event) {
        if ($(this).is(':checked')) {
            $('.container-project').addClass('d-none');
            $('.container-project').find('input , select').attr('disabled', 'disabled');
            $('.default-contact-client').removeClass('d-none');
        } else {
            $('.container-project').removeClass('d-none');
            $('.container-project').find('input , select').removeAttr('disabled');
            $('.default-contact-client').addClass('d-none');
        }
    });

    // On vient cocher une case, comme dans un site e-commerce, pour dire si c’est le même contact ou s’il est différent
    $('input#is_livraison_different_than_contact_client').click(function(event) {
        currentRowFluid = $(this).parents('.row-fluid').first();

        if ($(this).is(':checked')) {
            currentRowFluid.find('.container-infoslivraison').removeClass('d-none');
        } else {
            currentRowFluid.find('.container-infoslivraison').addClass('d-none');
        }
    });

    // On vient cocher une case, comme dans un site e-commerce, pour dire si c’est la même adresse ou si c'est différente
    $('input#is_livraison_adresse_diff_than_client_addr').click(function(event) {
        currentRowFluid = $(this).parents('.row-fluid').first();
        
        if ($(this).is(':checked')) {
            currentRowFluid.find('.container-adress').removeClass('d-none');
            $('#livraison_client_ville , #livraison_client_cp, #livraison_client_adresse').val('');
        } else {
            currentRowFluid.find('.container-adress').addClass('d-none');

            $('#livraison_client_ville').val($('#livraison_client_ville').attr('data-client-addr'));
            $('#livraison_client_cp').val($('#livraison_client_cp').attr('data-client-addr'));
            $('#livraison_client_adresse').val($('#livraison_client_adresse').attr('data-client-addr'));
        }
    });

    // l'un des 2 champ doit être rempli : dès que possible et date souhaitée
    $('form.step-vente').one('submit', function(event) {
        event.preventDefault();
        livr_date = $('input[name="livraison_date"]').val();
        as_soon = $('input#livraison_is_as_soon_as_possible').is(':checked');
        a_definir = $('input#livraison_is_client_livr_adress').is(':checked');

        if (livr_date == '' && as_soon == false && a_definir == false) {
            $('.msg-err').text('Veuillez remplir une "date de livraison" ou cocher "Dès que possible" ou cocher "À définir avec le client');
        } else {
            $('.msg-err').empty();
            $(this).submit();
        }
    });

    $('[name="livraison_date"]').on('keypress change', function (e) {
        $('[name="livraison_is_as_soon_as_possible"]').prop('checked', false);
    })

    $('input#livraison_is_as_soon_as_possible').click(function () {
        if ($(this).is(':checked')) {
            $('[name="livraison_date"]').val('');
            $('.msg-err').empty();
            $('[name="livraison_is_client_livr_adress"]').prop('checked', false);
        }
    });

    $('input#livraison_is_client_livr_adress').click(function () {
        if ($(this).is(':checked')) {
            $('.msg-err').empty();
            $('[name="livraison_is_as_soon_as_possible"]').prop('checked', false);
        }
    });

    $('input[name="livraison_date"]').on('keyup change', function(event) {
        event.preventDefault();
        if ($(this).val().length > 0) {
            $('.msg-err').empty();
        }
    });

    $('[name="livraison_type_date"]').on('change', function(event) {
        var val = $(this).val();
        if (val == 'precis') {
            $('.livr_date_text').removeClass('d-none');
        } else {
            $('.livr_date_text').addClass('d-none');
        }
        /* Act on the event */
    });
});


