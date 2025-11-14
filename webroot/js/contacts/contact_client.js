$(document).ready(function() {
    var baseUrl = $("#id_baseUrl").val();

    $('#edit_contact').on('shown.bs.modal', function(e) {
        document.getElementById("contact").reset();
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var url = link.attr('data-href');
        var contact_id = link.attr('data-contact');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
        $('#client_id').val(link.attr('data-client'));
        $.get(baseUrl + 'fr/ajax-clients/get-contact/' + contact_id, function(data, xhr) {
            if (data.status == '1') {
                var contact = data.contact;
                $('#civilite-m').attr('checked',contact.civilite == 'M' ? true:false);
                $('#civilite-mlle').attr('checked',contact.civilite == 'Mlle' ? true:false);
                $('#civilite-mme').attr('checked',contact.civilite == 'Mme' ? true:false);
                $('#prenom').val(contact.prenom);
                $('#nom').val(contact.nom);
                $('#position_id').val(contact.position);
                $('#email').val(contact.email);
                $('#tel').val(contact.tel);
                $('#telephone-2').val(contact.telephone_2);
                $('#fax').val(contact.fax);
                $('#site-web').val(contact.site_web);
                $('#date_naiss').val(contact.date_naiss);
                $('#twitter').val(contact.twitter);
                $('#facebook').val(contact.facebook);
                $('#linkedin').val(contact.linkedin);
                $('#viadeo').val(contact.viadeo);
                $('#contact-note').val(contact.contact_note?contact.contact_note:' ');
                
                tinymce.remove();
                $('.tinymce-note').tinymce({
                    language: 'fr_FR',
                    menubar: false,
                    plugins: ['advlist autolink link imagetools spellchecker lists autoresize'],        
                    toolbar: 'bold italic underline strikethrough |numlist bullist| link removeformat ',
                    relative_urls : false,
                    contextmenu: false,
                    remove_script_host : false,
                    convert_urls : false,
                    branding: false,
                    statusbar: false,
                });
            }
        });
    });

    $('.tinymce-note').tinymce({
        language: 'fr_FR',
        menubar: false,
        plugins: ['advlist autolink link imagetools spellchecker lists autoresize'],        
        toolbar: 'bold italic underline strikethrough |numlist bullist| link removeformat ',
        relative_urls : false,
        contextmenu: false,
        remove_script_host : false,
        convert_urls : false,
        branding: false,
        statusbar: false,
    });
    
    $('.edit-contact').on('click', function () {
        $('.client').addClass('hide');
        document.getElementById("client-id").disabled = true;
        // $('#client-id').attr('desabled', true);
    });
    
    $('.add-contact').on('click', function () {
        $('.client').removeClass('hide');
        document.getElementById("client-id").disabled = false;
    });
    
    var type_client = '';
    $('#client-genre').on('change', function () {
        type_client = $(this).val();
    });
    
    $('#client-genre').trigger('change');
    
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
                url: baseUrl + "fr/ajax-clients/search-client/" + type_client,
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
});
