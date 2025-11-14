$('tbody tr:not(.d-none)').find('td:eq(1):not(.d-none)').each(function(index, el) {
    if ($.trim($(this).text()) == '') {
        if(! $(this).parents('tbody').hasClass('default-data')) {
            $(this).parents('tr').remove();
        }
    }
    
    
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

});


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
                $('#model_devis_list').html(option);
            }
        },
        error: function(data) {
            console.log('Erreur:', data);
        }
    });
}

$(document).ready(function() {
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
    
    $('#facture_status').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var url = link.attr('data-href');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
        $('#modif_status').val(link.attr('data-value'));
        modal.find('.num_facture').text(link.attr('data-indent'));
    });

    // Commentaire
    $('#modal-commentaire').on('shown.bs.modal', function(e) {
        e.preventDefault();
        var currentLink = $(e.relatedTarget);
        var currentModal = $(e.currentTarget);
        var newCommentUrl = currentModal.find('form').attr('default-url');
        var modalForm = currentModal.find('form');

        if (currentLink.attr("data-id")) { // edit
            action = currentLink.attr('data-href');
            commentaire_id = currentLink.attr('data-id');
            modalForm.attr('action', action);

            $.get(baseUrl+'fr/clients/findCommentaire/'+commentaire_id, function(data) {
                modalForm.find('#titre').val(data.titre)
                modalForm.find('#content').val(data.content)
            });
        }
        else if (currentLink.hasClass('new-comment')) { // new
            modalForm.attr('action', newCommentUrl);
            modalForm.find('#titre').val("");
            modalForm.find('#content').val("");
        }
    });

    $('#modal-commentaire #content').tinymce({
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

    $('.create-facture').on('click', function(){
        $('.for-devis').addClass('hide');
        $('.sous-cat').addClass('hide');
    });
    
    $('.create-devis').on('click', function(){
        $('.for-devis').removeClass('hide');
    });
    
    $('#creation_doc').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        modal.find('#title').text(link.attr('data-title'));
        modal.find('#controller_id').val(link.attr('data-controller'));
        modal.find('.btn-submit').text(link.attr('data-submit'));
    });
    
    $('#edit_client').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var url = link.attr('data-href');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
        modal.find('#title').text(link.attr('data-title'));
        modal.find('#doc_id').val(link.attr('data-doc'));
        modal.find('#doc_id').attr('name', link.attr('data-type'));
    });
    
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
    
    $('#client_type').on('change', function () {
        if($(this).val() == 'corporation') {
            $('.edit-client-lastname').addClass('hide');
            $('.edit-enseigne').removeClass('hide');
            $('.edit-client-name').text('Raison sociale (*)');
            $('.edit-client-tel').text('Tel entreprise');
            $('.edit-client-mail').text('Email général');
            $('.edit-client-pro').removeClass('hide');
        }else {
            $('.edit-client-lastname').removeClass('hide');
            $('.edit-enseigne').addClass('hide');
            $('.edit-client-name').text('Nom (*)');
            $('.edit-client-tel').text('Téléphone');
            $('.edit-client-mail').text('Email');
            $('.edit-client-pro').addClass('hide');
            $('.edit-pro').val('');
        }
    });
    $('#client_type').trigger('change');
    
    initAjaxClient(srcUrl, type_client);

    // GIF
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
