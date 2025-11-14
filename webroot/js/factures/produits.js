$(document).ready(function() {
    srcUrl = $("#id_baseUrl").attr('value');

    $('.add-products').unbind('click');

    $('.add-products').click(function(event) {
        clonedTr = $('tr.clone').last().clone();
        $('tbody.products-table').append(clonedTr).promise().then(function (e) {
            newTr = $('tbody.products-table').find('tr.added-tr').last();
            newTr.find('[input-name="type_equipement_id"] , [input-name="equipement_id"] , [input-name="parc_id"]').attr('required', 'required');
            var newTrIndex = newTr.index();
            newTr.find("input[input-name] , select[input-name]").each(function(index, el) {
                $(this).attr('name', 'factures_produits'+'['+newTrIndex+']['+$(this).attr('input-name')+']');
            });
            newTr.removeClass('d-none');
        });
    });

    function removeProd() {
        $('tbody.products-table').on('click', '#remove-prod', function(event) {
            event.preventDefault();
            nbTr = $('tbody.products-table').find('tr').length;
            if (nbTr == 1) {
                alert('Cette ligne ne peut pas être supprimée');
                return false;
            }
            currentTr = $(this).parents('tr');

            if ($(this).attr('data-id')) {
                facture_produit_id = $(this).attr('data-id');
                $.get(srcUrl+'fr/factures/deleteFacturesProduits/'+facture_produit_id, function(data, xhr) {
                    if (data.status == 'success') {
                        currentTr.remove();
                    }
                });
            } else {
                currentTr.remove();
            }
        });
    }
    removeProd();

    function loadEquipements() {
        $('tbody.products-table').on('change', '#type_equipement_id', function(event) {

            currentTr = $(this).parents('tr');
            type_equipement_id = $(this).val();
            equipementSelect = currentTr.find('#equipement_id');
            equipementSelect.html('');

            $.get(srcUrl+'fr/factures/loadEquipements/'+type_equipement_id, function(data) {
                var option = new Option( 'Séléctionner', "", true, true);
                equipementSelect.append(option);
                
                $.each(data, function (clef, valeur) {
                    var option = new Option(valeur, clef, false, false);
                    equipementSelect.append(option);
                });
                equipementSelect.prop('disabled', false);
            });
        });
    }

    loadEquipements();

});