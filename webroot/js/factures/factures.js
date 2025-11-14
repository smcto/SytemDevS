$(document).ready(function() {
    var BASE_URL = $('#id_baseUrl').val();
    //==== GESTION LIST MESSAGE
    $("#etat_facture_id").change(function() {
        var etat_facture_id = $("#etat_facture_id").val();
        $('#message_type_id').empty();

        $.ajax({
            url: BASE_URL + 'fr/factures/getListMessage',
            data: {
                etat_facture_id: etat_facture_id
            },
            dataType: 'json',
            type: 'post',
            success: function (data) {
                $("#message_type_id").append('<option value="0">Sélectionner un message</option>');
                $.each(data, function (clef, valeur) {
                    $("#message_type_id").append('<option value="' + clef + '">' + valeur + '</option>');
                });
            }
        })
    });

    $("#message_type_id").change(function() {
        var message_type_id = $("#message_type_id").val();
        $('#message_id').empty();

        $.ajax({
            url: BASE_URL + 'fr/factures/getMessage',
            data: {
                message_type_id: message_type_id
            },
            dataType: 'json',
            type: 'post',
            success: function (data) {
                $.each(data, function (clef, valeur) {
                    $("#message_id").text(valeur);
                });
            }
        })
    });

    //===== Dropify
    // Basic
    $('.dropify').dropify();

    // Translated
    $('.dropify-fr').dropify({
        messages: {
            default: 'Glissez-déposez un fichier ici ou cliquez',
            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
            remove: 'Supprimer',
            error: 'Désolé, le fichier trop volumineux'
        }
    });

    // Used events
    var drEvent = $('#input-file-events').dropify();

    drEvent.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent.on('dropify.afterClear', function(event, element) {
        alert('File deleted');
    });

    drEvent.on('dropify.errors', function(event, element) {
        console.log('Has Errors');
    });

    var drDestroy = $('#input-file-to-destroy').dropify();
    drDestroy = drDestroy.data('dropify')
    $('#toggleDropify').on('click', function(e) {
        e.preventDefault();
        if (drDestroy.isDropified()) {
            drDestroy.destroy();
        } else {
            drDestroy.init();
        }
    });

});