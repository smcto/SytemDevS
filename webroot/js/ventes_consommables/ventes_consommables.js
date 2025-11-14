$(document).ready(function() {
    baseURI = $('input#id_baseUrl').val();
    $('#change-state').on('shown.bs.modal', function(event) {
        event.preventDefault();

        srcBtn = $(event.relatedTarget);
        calledModal = $(event.currentTarget);
        venteConsommableId = srcBtn.attr('data-id');
        currentForm = calledModal.find('form');
        currentForm.attr('action', srcBtn.attr('data-action'));
        venteStatutSelect = calledModal.find('select.vente_statut');
        saveBtn = currentForm.find('button.save');

        // --- si pre maj ----
        venteStatutSelect.val(srcBtn.attr('data-consommable-statut'));
        venteStatutSelect.selectpicker('refresh');
        if (srcBtn.attr('data-consommable-statut') == 'expedie') {
            currentForm.find('div.is_expedie').removeClass('d-none');
        } else {
            currentForm.find('div.is_expedie').addClass('d-none');
        }
        
        if (srcBtn.attr('data-consommable-statut') == 'expedie_partiel') {
            $.get(baseURI+'/fr/ajax-ventes/load-form-by-vente-consommable/'+venteConsommableId, function(data) {
                $('.is_partiel_expedie').html(data);
                $('.is_partiel_expedie').removeClass('d-none');
            });
        } else {
            $('.is_partiel_expedie').addClass('d-none');
        }

        // --- quand on choisit l'état "expédiée", on affiche en dessous un champ date qui permet de choisir la "date de départ de l'atelier".
        venteStatutSelect.on('changed.bs.select', function(e) {
            
            if (venteStatutSelect.val() == 'expedie') {
                currentForm.find('div.is_expedie').removeClass('d-none');
                currentForm.find('#date_depart_atelier').attr('required', 'required');
            } else {
                currentForm.find('div.is_expedie').addClass('d-none');
                currentForm.find('#date_depart_atelier').removeAttr('required');
            }

            if (venteStatutSelect.val() == 'expedie_partiel') {
                currentForm.find('.is_partiel_expedie').removeClass('d-none');
            } else {
                currentForm.find('.is_partiel_expedie').addClass('d-none');
            }

        });

        // --- quand on choisit l'état "commande partiellement expédiée", on affiche le tablea des livrables à traiter"
        venteStatutSelect.on('changed.bs.select', function(e) {
            if (venteStatutSelect.val() == 'expedie_partiel') {
                $.get(baseURI+'/fr/ajax-ventes/load-form-by-vente-consommable/'+venteConsommableId, function(data) {
                    $('.is_partiel_expedie').html(data);
                });
            }
        });
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


    // ----- checkbox tr collapse AJAX ----------
    $('.tr-container-checkbox input[type="checkbox"]').click(function(event) {
        self = $(this);
        dataTarget  = self.attr('data-target');

        if (self.is(':checked')) {
            $('tr#'+dataTarget).removeClass('d-none');
            $('tr#'+dataTarget).find('input[type="number"]').val('');
        } else {
            $('tr#'+dataTarget).addClass('d-none');
        }
    });

    $('.tr-container-checkbox input[type="checkbox"]').each(function(index, el) {
        self = $(this);
        dataTarget  = self.attr('data-target');

        if (self.is(':checked')) {
            $('tr#'+dataTarget).removeClass('d-none');
        } else {
            $('tr#'+dataTarget).addClass('d-none');
        }
    });
    // ----- END checkbox tr collapse AJAX ----------
});