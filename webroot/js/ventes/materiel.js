$(document).ready(function($) {
    var base_url = $('#id_baseUrl').val();

    $(".select2").select2({
        allowClear: true
    });
    
    $('select#gamme_borne_id').on('changed.bs.select', function(event) {
        event.preventDefault();
        gamme_borne_id = $(this).val();
        model_id = $('select#model_borne_id').val();
        $('#id_loader').show();

        urlLoadModelBorneByGamme = base_url+'/fr/ajax-ventes/loadModelBorneByGamme/'+gamme_borne_id;
        $.get(urlLoadModelBorneByGamme, function(dataGamme) {
            $('select#model_borne_id').html(dataGamme);
            $('select#model_borne_id').val(model_id);
            $('select#model_borne_id').selectpicker('refresh');
        });
        
        urlLoadEquipementFromGammeBorne = base_url+'/fr/ajax-ventes/loadEquipementFromGammeBorne/'+gamme_borne_id;
        $.get(urlLoadEquipementFromGammeBorne, function(dataEquipement) {
            $('select#type_equipement_id').html(dataEquipement);
            $('select#type_equipement_id').selectpicker('refresh');
        });

        urlLoadAccessoiresByGammeBorne = base_url+'/fr/ajax-ventes/loadAccessoiresByGammeBorneId/'+gamme_borne_id;
        $.get(urlLoadAccessoiresByGammeBorne, function(data) {
            if ($('input[name="is_accessoires"]').is(':checked')) {
                $('.container-form-accessories').html(data);
            }
        });
        
        var vente_id = $('#vente_id').val();
        
        urlLoadEquipementByGamme = base_url+'/fr/ajax-ventes/equipementByGamme/'+gamme_borne_id+'/'+vente_id;
        $.get(urlLoadEquipementByGamme, function(dataEquipement) {
            $('#dev-equipement').html(dataEquipement);
            
            var  nombre = $('#nombre').val();
            equipementsVentes(nombre);
            $('#id_loader').hide();
        });

    });
    

    $('select#model_borne_id').on('changed.bs.select', function(event) {
        event.preventDefault();
        model_borne_id = $(this).val();
        urlLoadModelBorneByGamme = base_url+'/fr/ajax-ventes/loadModelBorne/'+model_borne_id;
        $.get(urlLoadModelBorneByGamme, function(modelBorne) {
            $('#couleur_borne_id').selectpicker('val', modelBorne.couleur_id);
//            $('#equipement-imp-id').selectpicker('val', modelBorne.type_imprimante_id);
//            $('#equipement_apn_id').selectpicker('val', modelBorne.type_appareil_photo_id);
//            $('#type_equipement_id').selectpicker('val', modelBorne.pied_id);
        });

        var model = $(this).val();
        var nombre = $('#nombre').val();
        $.ajax({
            url : srcUrl + 'fr/ajax-ventes/equipement-by-model-borne/' + model,
            type : "GET",
            beforeSend: function() {
                $("#id_loader").show();
            },
            success: function (data) {
                for(var i=0; i<nombre; i++){
                    var type = $('#equipement-bornes-' + i + '-type-equipement-id').val();
                    if(data[type] != 'undefined' && data[type] != null) {
                        $('#equipement-ventes-' + i + '-equipement-id').selectpicker('val', data[type]);
                    }
                }
                $("#id_loader").hide();
            }
        });
    });

    
    // si precistion sur select, affiche un textarea en bas
    $('select#needprecision').on('changed.bs.select', function(event) {
        event.preventDefault();
        currentRowFluid = $(this).parents('.row-fluid').first();

        if ($(this).val() == 1) {
            currentRowFluid.find('.hidden-precision').removeClass('d-none');
        } else {
            currentRowFluid.find('.hidden-precision').addClass('d-none');
            currentRowFluid.find('.hidden-precision').find('input , textarea').val('');
        }
    }); 

    // si precistion sur select, affiche un textarea en bas
    $('select#valiseprecision , select#housepreicsion').on('changed.bs.select', function(event) {
        event.preventDefault();
        currentRowFluid = $("#row-"+$(this).attr('id'));

        if ($(this).val() == 1) {
            currentRowFluid.removeClass('d-none');
        } else {
            currentRowFluid.addClass('d-none');
            currentRowFluid.find('input , textarea').val('');
        }
    }); 



    $('input[type="checkbox"][name="is_custom_gravure"]').on('click', function(event) {
        is_custom_gravure = $(this).val();
        textareaGravureNote = $('textarea[name="gravure_note"]');

        if ($(this).is(':checked')) {
            $('div.container-gravure-note').removeClass('d-none');
        } else {
            $('div.container-gravure-note').addClass('d-none');
            textareaGravureNote.val('');
        }
    });

    equipement_imp_id = '';
    $('input[name="is_without_imprimante"]').click(function(event) {
        if ($(this).is(':checked')) {
            equipement_imp_id = $('select[name="equipement_imp_id"]').val();
            $('select[name="equipement_imp_id"]').val('')
            $('select[name="equipement_imp_id"]').attr('disabled', 'disabled');
            $('select[name="equipement_imp_id"]').selectpicker('refresh');
        } else {
            $('select[name="equipement_imp_id"]').val(equipement_imp_id);
            $('select[name="equipement_imp_id"]').removeAttr('disabled');
            $('select[name="equipement_imp_id"]').selectpicker('refresh');
        }
    });

    $('.fond_vert_note').wysihtml5({
        'locale': 'fr-FR',
        'image': false,
        "stylesheets": false
    });

    $('#is_without_app_photos').click(function(event) {
        if ($(this).is(':checked')) {
            $('select#equipement_apn_id').attr('disabled', 'disabled');
            $('select#equipement_apn_id').selectpicker('refresh');
        } else {
            $('select#equipement_apn_id').removeAttr('disabled');
            $('select#equipement_apn_id').selectpicker('refresh');
        }
    });

    $('#is_accessoires').click(function(event) {
        gamme_borne_id = $('select#gamme_borne_id').selectpicker('val');
        currentRowFluid = $(this).parents('.row-fluid').first();

        if ($(this).is(':checked')) {
            $('.alert-no-game').remove();
            if (gamme_borne_id == '') {
                $('.container-accessories').append("<div class='text-danger mb-4 alert-no-game'>Veuillez choisir une gamme pour afficher la liste des accessoires correspondante.</div>")
                return false;
            }
             else {

                currentRowFluid.find('.hidden-precision').removeClass('d-none');
                $('.container-form-accessories').removeClass('d-none');

                urlLoadAccessoiresByGammeBorne = base_url+'/fr/ajax-ventes/loadAccessoiresByGammeBorneId/'+gamme_borne_id;
                $.get(urlLoadAccessoiresByGammeBorne, function(data) {
                    $('.container-form-accessories').html(data)
                });
             }
        } else {
            // $('.list-accessories:not(:first)').remove();
            $('.container-form-accessories').addClass('d-none');
            currentRowFluid.find('.hidden-precision').addClass('d-none');
        }
    });

    // ------------------------ Accessoires ----------------------------

    $('.add-accessories').click(function(event) {
        firstListAccessoriesCloned = $('.list-accessories').first().clone();
        firstListAccessoriesClonedSelect = firstListAccessoriesCloned.find('select');
        firstIndex = $('.list-accessories');

        firstListAccessoriesCloned.find('.bootstrap-select').remove().end();
        firstListAccessoriesCloned.find('.form-group').append(firstListAccessoriesClonedSelect).end();
        firstListAccessoriesCloned.find('select').val('').selectpicker('reset');


        $('.list-accessories').last().after(firstListAccessoriesCloned).promise().then(function (e) {
            lastAccessoriesList = $('.list-accessories').last();
            lastAccessoriesList.find('.bootstrap-select:odd').remove();
            lastAccessoriesList.find('.accessories-note').addClass('d-none')
            
            newSelectAttrName = "ventes_accessoires["+eval(lastAccessoriesList.index()-1)+"][accessoire_id]";
            newNoteAttrName = "ventes_accessoires["+eval(lastAccessoriesList.index()-1)+"][note]";

            lastAccessoriesList.find('select').attr('name', newSelectAttrName);
            lastAccessoriesList.find('textarea').attr('name', newNoteAttrName);
            lastAccessoriesList.find('a.remove-accessoire').attr('data-key', $(this).index());
            addNoteOnAccessories();
            removeAccessories();
        });
    });


    function removeAccessories() {
        $('.remove-accessoire').click(function(event) {

            listAccessoires = $(this).parents('.list-accessories');
            if ($('.list-accessories').length > 1) {
                key = $(this).attr('data-key');
                $.get(base_url+'fr/ajax-ventes/removeAccessories/'+key, function(data) {
                    console.log(data)
                    listAccessoires.remove();
                    /*optional stuff to do after success */
                });
            } else {
                alert("Cette liste ne peut être supprimée")
            }
        });
    }
    removeAccessories();


    function addNoteOnAccessories() {
        $('.container-accessories').unbind('changed.bs.select').on('changed.bs.select' , '#list_accessoires' , function(event) {
            if ($(this).val() == 0) {
                $(this).parents('.list-accessories').find('.accessories-note').removeClass('d-none')
            } else {
                $(this).parents('.list-accessories').find('.accessories-note').addClass('d-none')
            }
        });
    }
    addNoteOnAccessories();

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

    function equipementsVentes(nombre) {

        if(nombre != 'undefined' && nombre >= 0) {

            var j = nombre;

            $('#equipement-ventes-' + j + '-aucun').on('change', function(){
                if($(this).prop('checked')){
                    $('#equipement-ventes-' + j +'-equipement-id').val('').selectpicker('refresh');;
                    $('#equipement-ventes-' + j +'-equipement-id').attr('disabled', 'disabled');

                    document.getElementById('equipement-ventes-' + j +'-materiel-occasion').checked = false;
                    $('#equipement-ventes-' + j +'-materiel-occasion').attr('disabled', 'disabled');
                    
                    document.getElementById('equipement-ventes-' + j +'-valeur-definir').checked = false;
                    $('#equipement-ventes-' + j +'-valeur-definir').attr('disabled', 'disabled');
                }else{
                    $('#equipement-ventes-' + j +'-equipement-id').attr('disabled', false);
                    $('#equipement-ventes-' + j +'-materiel-occasion').attr('disabled', false);
                    $('#equipement-ventes-' + j +'-valeur-definir').attr('disabled', false);
                }
            });
            $('#equipement-ventes-' + j + '-aucun').trigger('change');
            
            $('select#equipement-ventes-' + j +'-equipement-id').selectpicker('refresh');
            
            equipementsVentes(nombre - 1);
        }
    }
    
    var  nombre = $('#nombre').val();
    equipementsVentes(nombre);

    // ----- END checkbox tr collapse AJAX ----------

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

    // DEBUT POPUP ACCESSOIRES
    $('.modal-equipement button.submit').click(function(event) {
        $('#submit-catalog').addClass('disabled').text('Chargement ...');
        $('.modal-equipement').modal('hide');
        var modalEquipement = $('.modal-equipement');
        var containerAccessoires = $('.container-accessoires-sup');
        var blockAccessoires = $('.block-accessoires');

        containerAccessoires.removeClass('d-none');
        var defaultData = $('.container-accessoires-sup tbody.default-data');

        if ($('.selected-produits tr', modalEquipement).length > 0) {
            $('.aucun_equip_sup', blockAccessoires).addClass('d-none');
            $('.selected-produits tr', modalEquipement).each(function(index, el) {
                var equipAccessoire = $('.equip-accessoire', $(el));
                if (equipAccessoire.is(':checked')) {
                    var currentTr = $(el);
                    var equipmId = currentTr.attr('equip-id');
                    var selectEquipm = $('.select-equipm', currentTr);
                    var qtyEquipm = $('.qty-equipm', currentTr);
                    var nomEquipm = $('.nom', currentTr);
                    var typeEquipmId = $('.type-equipm-id', currentTr);
                    var nTypeEquipmId = $('.delete-selected', currentTr).attr('type_equip_id');

                    var newTrIndRow = $('.container-accessoires-sup .default-data tr').length; // doit être ici, ne pas modifier ordre
                    var cloned = $('.container-accessoires-sup tfoot tr.clone').first().clone();
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
                        $(this).attr('name', 'equipements_accessoires_ventes'+'['+newTrIndRow+']['+$(this).attr('input-name')+']');
                    });
                }
            });
        }
    });

    // Ajout selection dans bloc Accessoire(s) sélectionné(s)
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

    function checkDisplayBlocSelectedProducts(currentForm) {
        if ($('.bloc-selected-products .selected-produits tr', currentForm).length > 0) {
            $('.bloc-selected-products', currentForm).removeClass('d-none');
        } else {
            $('.bloc-selected-products', currentForm).addClass('d-none');
        }

    }

    function deleteProductFromFormAccessoires() {
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

    deleteProductFromFormAccessoires();
    
    // ------ END POPUP ADD EQUIPEMENTS ACCESSOIRES SUP ---------------

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
                        $(this).attr('name', 'equipements_protections_ventes'+'['+newTrIndRow+']['+$(this).attr('input-name')+']');
                    });
                }
            });
        }
    });
});
