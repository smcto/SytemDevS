$(document).ready(function() {
    var baseUrl = $("#id_baseUrl").val();
    
    $(".select2").select2({
        allowClear: true
    });

    // $('#btn-borne').trigger('change');

    // MAJ de l'état d'une vente
    $('#change-state').on('shown.bs.modal', function(event) {
        event.preventDefault();

        srcBtn = $(event.relatedTarget);
        calledModal = $(event.currentTarget);
        venteId = srcBtn.attr('data-id');
        currentForm = calledModal.find('form');
        currentForm.attr('action', srcBtn.attr('data-action'));
        venteStatutSelect = calledModal.find('select.vente_statut');
        saveBtn = currentForm.find('button.save');

        $('.alert-modal').removeClass('alert-warning').addClass('d-none');
        $('.alert-modal').find('div.msg').empty();
        currentForm.find('#date_depart_atelier').val('');
        currentForm.find('#date_reception_client').val('');

        // --- si pre maj ----
        venteStatutSelect.val(srcBtn.attr('data-vente-statut'));
        venteStatutSelect.selectpicker('refresh');
        if (srcBtn.attr('data-vente-statut') == 'expedie') {

            currentForm.find('div.is_expedie').removeClass('d-none');
            date_depart_atelier = srcBtn.attr('data-departatelier');
            date_reception_client = srcBtn.attr('data-receptionclient');
            date_bon_de_livraison = srcBtn.attr('data-bondelivraison');
            currentForm.find('#date_depart_atelier').val(date_depart_atelier);
            currentForm.find('#date_reception_client').val(date_reception_client);
            currentForm.find('#bon_de_livraison').attr('data-default-file', date_bon_de_livraison);
            currentForm.find('#date_depart_atelier , #date_reception_client').attr('required', 'required');


        } else {
            currentForm.find('div.is_expedie').addClass('d-none');
        }

        // --- quand on choisit l'état "expédiée", on affiche en dessous un champ date qui permet de choisir la "date de départ de l'atelier".
        venteStatutSelect.on('changed.bs.select', function(e) {
            if (venteStatutSelect.val() == 'expedie') {
                currentForm.find('div.is_expedie').removeClass('d-none');
                currentForm.find('#date_depart_atelier , #date_reception_client').attr('required', 'required');
            } else {
                currentForm.find('div.is_expedie').addClass('d-none');
                currentForm.find('#date_depart_atelier , #date_reception_client').removeAttr('required');
            }
        });


        // Blocage soumission si vente expédiée = pas de borne attribuée
        currentForm.one('submit',function(e) {
            e.preventDefault();

            $('.alert-modal').removeClass('alert-warning').addClass('d-none');
            $('.alert-modal').find('div.msg').empty();

            if (venteStatutSelect.val() == 'expedie') {

                $.get(baseUrl+'fr/ajax-ventes/checkIfVenteHasBorne/'+venteId, function(data) {
                    // Si pas de borne
                    if (data.status != true) {
                        $('.alert-modal').addClass('alert-warning').removeClass('d-none');
                        $('.alert-modal').find('div.msg').html("<span class='fa fa-exclamation-triangle'></span> Une commande à expédier doit être attribuée à une borne");
                    } else {
                    // Si borne
                        currentForm.submit();
                    }
                });
            } else {
                currentForm.submit();
            }

        });

        // Deposition BL
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: "Veuillez vérifier votre fichier"
            },
            error: {
                fileExtension: "Ce type de fichier n'est pas permis, (Choisir uniquement un fichier au format : {{ value }})."
            }
        });

    }); 

});
