// ------ POPUP ADD EQUIPEMENTS ACCESSOIRES SUP ---------------
$('form.form-type-equipements').submit(function(event) {
    event.preventDefault();
    var url = $(this).attr('action');
    var queries = $(this).serialize();

    $.get(url, queries, function(data) {
        $('.container-type-equipements').html(data);
    });
});

$('form.form-type-equipements .reset').click(function(event) {
    event.preventDefault();
    var form = $('form.form-type-equipements');
    $('input, select', form).val("");
    form.submit();
});

selectParc = $('.form-type-equipements [name="parc_id"]');
selectBorne = $('.form-type-equipements [name="borne_id"]');

selectParc.on('change', function(event) {
    var parcId = $(this).val();
    emptyOption = selectBorne.find('option[value=""]').text();
    if (parcId != "") {
        $('.container-bornes').removeClass('d-none');
        $.get(baseUrl+'fr/ajaxBornes/findByParcId/'+parcId, function(data) {
            // after ajax callback
            var option = new Option(emptyOption, "", true, true);
            selectBorne.html('');
            selectBorne.append(option);
                
            $.each(data, function (key, value) {
                var option = new Option(value, key, false, false);
                selectBorne.append(option);
            });
            
            selectBorne.selectpicker('refresh');
        });
    } else {
        $('.container-bornes').addClass('d-none');
        var option = new Option(emptyOption, "", true, true);
        selectBorne.html('');
        selectBorne.append(option);
        selectBorne.selectpicker('refresh');
    }
});


// DEBUT POPUP PROTECTION VERS BLOC PROTECTION

$('.modal-equipement-protection button.submit').click(function(event) {
    $('#submit-catalog').addClass('disabled').text('Chargement ...');
    var modalProtections = $('.modal-equipement-protection');
    var blockProtections = $('.block-protections');
    modalProtections.modal('hide');
    var containerAccessoires = $('.container-protections-sup');
    containerAccessoires.removeClass('d-none');
    var defaultData = $('.container-protections-sup tbody.default-data');

    if ($('.selected-produits tr', modalProtections).length > 0) {
        $('.aucun_equip_sup', blockProtections).addClass('d-none');
        $('.selected-produits tr', modalProtections).each(function(index, el) {
            var equipAccessoire = $('.equip-accessoire', $(el));
            if (equipAccessoire.is(':checked')) {
                var currentTr = $(el);
                var equipmId = currentTr.attr('equip-id');
                var selectEquipm = $('.select-equipm', currentTr);
                var qtyEquipm = $('.qty-equipm', currentTr);
                var nomEquipm = $('.nom', currentTr);
                var typeEquipmId = $('.type-equipm-id', currentTr);
                var nTypeEquipmId = $('.delete-selected', currentTr).attr('type_equip_id');

                var newTrIndRow = $('.container-protections-sup .default-data tr').length; // doit être ici, ne pas modifier ordre
                var cloned = $('.container-protections-sup tfoot tr.clone').first().clone();
                defaultData.append(cloned);
                var newRow = defaultData.find('.added-tr').last();
                newRow.find('.nom-equip-accessoire').html(nomEquipm.html())
                newRow.find('.select-equip-accessoire').html(selectEquipm.html())
                newRow.find('.qty-equip-accessoire').html(qtyEquipm.html())
                newRow.find('.type-equip-accessoire-id').html(typeEquipmId.html())
                newRow.find('.delete-selected').attr('type_equip_id', nTypeEquipmId);
                newRow.removeClass('d-none');


                newRow.find("input[input-name] , select[input-name]").each(function(index, el) {
                    // repris à partir des input-name dans find_type_equipements_accessoires.ctp
                    $(this).attr('name', 'equipements_protections_bornes'+'['+newTrIndRow+']['+$(this).attr('input-name')+']');
                });
            }
        });
    }
});

// Ajout des selections dans bloc modal (s) sélectionné(s)
$(".container-type-equipements").on("click", "tbody.table-equipm button.add", function (e) {
    var currentForm = $(this).parents('form');
    var currentTr = $(this).parents('tr');
    var equipId = currentTr.attr('equip-id');
    currentTr.find('.equip-accessoire').prop('checked', true);
    var equipmId = $('.equip-accessoire', currentTr).val();
    if (currentTr.find('.equip-accessoire').is(':checked')) {
        currentTr.addClass('d-none');

        var blocSelectedProducts = $('.bloc-selected-products', currentForm);
        var clonedTr = $('tfoot tr', blocSelectedProducts).last().clone();

        if ($('tr[equip-id="'+equipmId+'"]', blocSelectedProducts).length == 0) { // si produit déjà dans le bloc des produits sélectionnés on ne rajoute +
            var addLine = $('tbody.selected-produits', blocSelectedProducts).prepend(clonedTr);
            addLine.promise().then(function (e) {
                var newTr = $('tbody.selected-produits', blocSelectedProducts).find('tr').first();
                newTr.attr('equip-id', equipmId);
                $('.selected-product', newTr).html($('.selected-product', currentTr).html());
                $('.selected-product .equip-accessoire', newTr).prop('checked', true);
                $('.nom', newTr).text($('.nom', currentTr).text());
                $('.select-equipm', newTr).html($('.select-equipm', currentTr).html());
                $('.qty-equipm', newTr).html($('.qty-equipm', currentTr).html());
                $('.type-equipm-id', newTr).html($('.type-equipm-id', currentTr).html());
                $('.delete-selected', newTr).attr('type_equip_id', equipId);

                checkDisplayBlocSelectedProducts(currentForm);
            });
        }
    }
});

function deleteProductFromModal() {
    $(".div_table_selected_produits").on("click", ".delete-selected", function (e) {
        var currentForm = $(this).parents('form');
        var currentTr = $(this).parents('tr');
        var productId = currentTr.attr('equip-id');
        var tableCatalog = $('tbody.table-equipm');
        $('tr[equip-id="'+productId+'"]', tableCatalog).removeClass('d-none');
        currentTr.remove();

        checkDisplayBlocSelectedProducts(currentForm);
    });
}

deleteProductFromModal();

function checkDisplayBlocSelectedProducts(currentForm) {
    if ($('.bloc-selected-products .selected-produits tr', currentForm).length > 0) {
        $('.bloc-selected-products', currentForm).removeClass('d-none');
    } else {
        $('.bloc-selected-products', currentForm).addClass('d-none');
    }

}

function reinitialiseProduitsSelected() {
    $('.modal-equipement , .modal-equipement-protection').on('show.bs.modal', function(event) {
        var modal = $(this);
        var divTableSelectedProduits = $('.div_table_selected_produits', modal);
        // console.log($('tbody.table-equipm tr[equip-id]', divTableSelectedProduits))
        var containerTypeEquipements = $('.container-type-equipements');
        $('tbody.table-equipm tr[equip-id]', containerTypeEquipements).find('.equip-accessoire').prop('checked', false);
        $('tbody.table-equipm tr[equip-id]', containerTypeEquipements).removeClass('d-none');
        $('.selected-produits tr', divTableSelectedProduits).remove();
        $('.bloc-selected-products', modal).addClass('d-none');
    }); 
}

reinitialiseProduitsSelected();

function deleteProductFromFormProtections() {
    $(".container-equips").on('click', 'a.delete-selected', function () {
        var currentTr = $(this).parents('tr');
        var containerEquips = $(this).parents('.container-equips');
        currentTr.remove();
        if ($('tbody.default-data tr', containerEquips).length == 0) {
            containerEquips.addClass('d-none');
            $('.aucun_equip_sup').removeClass('d-none');
        } else {
            containerEquips.removeClass('d-none');
            $('.aucun_equip_sup').addClass('d-none');
        }
    })
}

deleteProductFromFormProtections();