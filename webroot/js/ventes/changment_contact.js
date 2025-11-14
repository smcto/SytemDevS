$('.client_contact_id').on('changed.bs.select', function(event) {
    var contactClientId = $(this).val();

    if (contactClientId != '') {
        $.get(baseUrl+'fr/AjaxClients/getContact/'+contactClientId, function(data) {
            if (data.status == 1) {
                var contact = data.contact;
                $('.form_fullname').val(contact.nom);
                $('.form_lastname').val(contact.prenom);
                $('.form_fonction').val(contact.position);
                $('.form_email').val(contact.email);
                $('.form_telmobile').val(contact.tel);
                $('.form_telfixe').val(contact.telephone_2);
            } 
        });
    } 
    else {
        $('.form_fullname, .form_lastname, .form_fonction, .form_email, .form_telmobile, .form_telfixe').val("");
    }
});

$('.step-vente').one('submit', function (e) {
    e.preventDefault();

    var formContactClients = $('.contact-pre-rempli');
    if ($('.client_contact_id').val() == '') {
        e.preventDefault();
        var form = $(this);
        $('#nom', formContactClients).val($('.form_fullname').val())
        $('#prenom', formContactClients).val($('.form_lastname').val())
        $('#position', formContactClients).val($('.form_fonction').val())
        $('#email', formContactClients).val($('.form_email').val())
        $('#tel', formContactClients).val($('.form_telmobile').val())
        $('#telephone_2', formContactClients).val($('.form_telfixe').val());

        form.submit();
    } else {
        $('#nom', formContactClients).val("")
        $('#prenom', formContactClients).val("")
        $('#position', formContactClients).val("")
        $('#email', formContactClients).val("")
        $('#tel', formContactClients).val("")
        $('#telephone_2', formContactClients).val("");
    }
});