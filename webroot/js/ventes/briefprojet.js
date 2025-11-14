$(document).ready(function() {
    // On vient cocher une case, comme dans un site e-commerce, pour dire si c’est le même contact ou s’il est différent
    contact_crea_fullname = '';
    contact_crea_fonction = '';
    contact_crea_email = '';
    contact_crea_telmobile = '';
    contact_crea_telfixe = '';
    $('input#is_contact_crea_different_than_contact_client').click(function(event) {
        currentRowFluid = $(this).parents('.row-fluid').first();

        if ($(this).is(':checked')) {
            currentRowFluid.find('.hidden-precision').removeClass('d-none');
        } else {
            currentRowFluid.find('.hidden-precision').addClass('d-none');
        }
    });


});