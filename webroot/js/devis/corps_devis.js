/**
 * setDropdown dans devis/autre.js
 */
$(window).bind("load", function() {
    var srcUrl = $("#id_baseUrl").attr('value');
    var curentTrForObject = null;

    if (!$('#remise-hide-line').is(':checked')) {
        $('.dynamic-colspan').each(function() {
            cols = $(this).prop('colspan');
            $(this).prop('colspan', cols + 1);
        });
    }
    
    tvaValue = $('#default_tva_decimal').val()/20;
    
    if($('#display-tva').is(':checked')) {
        $('.tva-value').val(0);
        $('.tva-value').prop('disabled', true);
        tvaValue = 0;
    }
    
    showTrRemiseGlobal();
    
    // Autres
    function setSummernoteInTr(currentTr = null, params = {}) {
        el = currentTr != null ? currentTr : $;
        placeholder = typeof params.placeholder != 'undefined' ? params.placeholder : '';
        index = typeof params.index != 'undefined' ? params.index : '0';

        // pour titre/commentaire
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
        el.find('.note-statusbar').hide();
    }

    $('.note-statusbar').hide();

    setSublineBehavior();
    majMontant();
    majRecap();

    // Ajout, suppr, ligne, etc
    var trLength = $('tbody.default-data').find('tr').length;
    $('.new_product_line').unbind('click');
    $('.new_product_line').click(function(event) {

        $('tbody').removeAttr('style');
        $('.detail-form').removeClass('d-none');

        addNewLineLine();
    });


    $('tbody.default-data').find('tr').each(function() {
        setDropdown($(this));
    });
    
    $('input[input-name="remise_value"]').trigger('blur').trigger('change');

    /**
     * si afterCurrentLine ou beforeCurrentLine, doit specifier le tr en q°
     */
    function addNewLineLine(position = 'bottom', tr = null, data = null, class_type = 'clone') {
        if ($('.first-tr').html() != 'undefined') {
            $('.first-tr').remove();
        }
        var clonedTr = $('tfoot tr.' + class_type).last().clone();
        placeholder = '';
        // Ajout ligne simple avec détails produits
        if (position == 'bottom') {
            addLine = $('tbody.default-data').append(clonedTr);
        } else if (position == 'afterCurrentLine') {
            addLine = tr.after(clonedTr);
        } else if (position == 'beforeCurrentLine') {
            addLine = tr.before(clonedTr);
        }

        // Ajout contenu titre / commentaire
        else if ($.inArray(position, ['titreAfterCurrentLine', 'sousTotalAfterCurrentLine', 'commentAfterCurrentLine', 'sautLigneAfterCurrentLine', 'sautPageAfterCurrentLine']) !== -1) {
            placeholder = position == 'titreAfterCurrentLine' ? 'titre' : 'commentaire'; // il n'y a que ces 2 cas
            addLine = tr.after(clonedTr);
        } else if ($.inArray(position, ['titreBeforeCurrentLine', 'sousTotalBeforeCurrentLine', 'commentBeforeCurrentLine', 'sautLigneBeforeCurrentLine', 'sautPageBeforeCurrentLine']) !== -1) {
            placeholder = position == 'titreBeforeCurrentLine' ? 'titre' : 'commentaire'; // il n'y a que ces 2 cas
            addLine = tr.before(clonedTr);
        }

        return addLine.promise().then(function(e) {

            // selection
            if (position == 'bottom') {
                newTr = $('tbody.default-data').find('tr.added-tr').last();
            } else if ($.inArray(position, ['afterCurrentLine', 'titreAfterCurrentLine', 'sousTotalAfterCurrentLine', 'commentAfterCurrentLine', 'sautLigneAfterCurrentLine', 'sautPageAfterCurrentLine']) !== -1) {
                newTr = $(this).next();
            } else if ($.inArray(position, ['beforeCurrentLine', 'titreBeforeCurrentLine', 'sousTotalBeforeCurrentLine', 'commentBeforeCurrentLine', 'sautLigneBeforeCurrentLine', 'sautPageBeforeCurrentLine']) !== -1) {
                newTr = $(this).prev();
            }

            if (data) {
                newTr.find('[input-name="catalog_produits_id"]').val(data['id']);
                newTr.find('[input-name="is_consommable"]').val(data['is_consommable']);
                newTr.find('[input-name="nom_commercial"]').val(data['nom_commercial']);
                newTr.find('[input-name="reference"]').val(data['reference']);
                newTr.find('[input-name="description_commercial"]').val(data['description_commercial']);
                newTr.find('[input-name="prix_reference_ht"]').val(data['prix_reference_ht']);
                newTr.find('[input-name="catalog_unites_id"]').val(data['catalog_unites_id']);
                newTr.find('[input-name="quantite_usuelle"]').val(data['quantite_usuelle'] != 0 ? data['quantite_usuelle'] : 1);

                newTr.find('[input-name="tarif_client"]').val(data['tarif_client']);
                newTr.find('[input-name="unites_client_id"]').val(data['unites_client_id']);
                newTr.find('[input-name="quantite_client"]').val(data['quantite_client'] != 0 ? data['quantite_client'] : 1);
                
                newTr.find('[input-name="sous_total"]').val(data['sous_total']);
                newTr.find('[input-name="titre_ligne"]').val(data['titre_ligne']);
                newTr.find('[input-name="commentaire_ligne"]').val(data['commentaire_ligne']);

                newTr.find('[input-name="remise_value"]').val(data['remise_value']);
                newTr.find('[input-name="remise_unity"]').val(data['remise_unity']);

                montantTTc = (data['prix_reference_ht'] * (data['quantite_usuelle'] != 0 ? data['quantite_usuelle'] : 1)).toFixed(2);
                montantTTcClient = (data['tarif_client'] * (data['quantite_client'] != 0 ? data['quantite_client'] : 1)).toFixed(2);
                if(data['remise_value']) {
                    if(data['remise_unity'] == '%') {
                        montantTTc = (montantTTc * (1 - (data['remise_value'] / 100))).toFixed(2);;
                        montantTTcClient = (montantTTcClient * (1 - (data['remise_value'] / 100))).toFixed(2);;
                    } else {
                        montantTTc = (montantTTc - data['remise_value']).toFixed(2);;
                        montantTTcClient = (montantTTcClient - data['remise_value']).toFixed(2);;
                    }
                }
                newTr.find('td.montant_ht .montant_ht_value').text(montantTTc != 'NaN' ? montantTTc : 0.00);
                newTr.find('td.montant_ht .montant_ht_client').text(montantTTcClient != 'NaN' ? montantTTcClient : 0.00);
            }
            newTr.find('[input-name="reference"]').attr('required', 'required');
            newTr.find("input[input-name]").each(function(index, el) {
                $(this).attr('name', 'devis_produits' + '[0_pour_le_moment][' + $(this).attr('input-name') + ']');
            });
            newTr.find('[input-name="description_commercial"]').addClass('tinymce-note');
            newTr.find('[input-name="titre_ligne"]').addClass('tinymce-note');
            newTr.find('[input-name="commentaire_ligne"]').addClass('tinymce-note');
            newTr.removeClass('d-none');
            $('tbody.default-data tr.d-none').remove();

            setDropdown(newTr);
            setSublineBehavior();
            majMontant();
            majRecap();
            sousTotal();
            setSummernoteInTr(newTr, {
                'placeholder': placeholder
            });
            // sortLine();
        });
    }

    function removeProd() {
        $('tbody.default-data').on('click', '#remove-prod', function(event) {
            event.preventDefault();
            var currentTr = $(event.currentTarget).parents('tr'); 
            if (confirm('Etes-vous sûr de vouloir supprimer ?')) {
                url = $(this).attr('data-href');
                nbTr = $('tbody.default-data').find('tr').length;
                isFromModel = $('[name="is_from_model"]').val();
                if (nbTr <= 1) {
                    currentTr.parents('table').addClass('d-none');
                }
                if (url && !isFromModel) {
                    $.get(url, function(data, xhr) {
                        if (data.status == 'success') {
                            currentTr.remove();
                        }
                    });
                } else {
                    currentTr.remove();
                }
                majRecap();
            }
        });
    }

    removeProd();

    // Calcul des inputs et recapitulations
    function majMontant() {
        tbody = $('tbody.default-data');

        // Calcul montant TTC ligne
        tbody.unbind('blur, change').on('blur, change', 'input[input-name="prix_reference_ht"] , input[input-name="remise_value"], select[input-name="remise_unity"] , [input-name="tva"] , input[input-name="quantite_usuelle"], input[input-name="catalog_unite_id"], input[input-name="quantite_client"] , input[input-name="remise_value"], select[input-name="remise_unity"] , [input-name="tva_client"], input[input-name="tarif_client"]', function(event) {
            currentTr = $(this).parents('tr');
            remise_value =  currentTr.find('input[input-name="remise_value"]').val();
            remise_unity =  currentTr.find('select[input-name="remise_unity"]').val();
            prix_reference_ht = currentTr.find('input[input-name="prix_reference_ht"]').val();
            tva = currentTr.find('[input-name="tva"]').val();
            quantite_usuelle = currentTr.find('input[input-name="quantite_usuelle"]').val();

            tvaPercentage = parseFloat((tva/100).toFixed(2));
            montantTTc = (prix_reference_ht*quantite_usuelle).toFixed(2);
            
            if(remise_unity === '%') {
                montantTTc = ((1 - parseFloat((remise_value/100).toFixed(2))) * montantTTc).toFixed(2);
            }else {
                montantTTc -= remise_value;
            }

            currentTr.find('td.montant_ht .montant_ht_value').text(montantTTc);
            
            prix_client = currentTr.find('input[input-name="tarif_client"]').val();
            tva_client = currentTr.find('[input-name="tva_client"]').val();
            quantite_client = currentTr.find('input[input-name="quantite_client"]').val();

            montantHTClient = (prix_client*quantite_client).toFixed(2);
            
            if(remise_unity === '%') {
                montantHTClient = ((1 - parseFloat((remise_value/100).toFixed(2))) * montantHTClient).toFixed(2);
            }else {
                montantHTClient -= remise_value;
            }
            
            currentTr.find('td.montant_ht .montant_ht_client').text(montantHTClient);
            currentTr.find('input[input-name="montant_client"]').val(montantHTClient);
            
            majRecap();
        });
        
    }

    // Calcul montant récapitulation finale
    function majRecap() {
        tbody = $('tbody.default-data');
        nbTr = tbody.find('tr').length;
        nbTrAsNotProduct = $('tbody.default-data [input-name="type_ligne"][value!="produit"]').length; // attention, ca compte le titre en nombre de produits... vérifier que ça fasse pas pareil avec les sous totaux, saut de lignes etc...

        hasOption = 0;
        globalSumTTc = 0;
        globalMontantHT = 0;
        globalTVA = 0;
        globalRemiseTVA = 0;
        globalNbre = 0;
        globalRemiseHT = 0;
        globalTotalAfterRemiseHT = 0;
        lineTva = '';
        blockOperation = false;

        tbody.find('[input-name="prix_reference_ht"]').each(function(index, el) {
            currentTr = $(this).parents('tr');
            
            if( ! $(this).parents('tr').hasClass('ligne-option')) {

                prix_reference_ht = currentTr.find('input[input-name="prix_reference_ht"]').val();
                tva = currentTr.find('[input-name="tva"]').val();
                if(lineTva == '') {
                    lineTva = tva;
                } else {
                    if(lineTva != tva) {
                        blockOperation = true;
                    }
                }
                quantite_usuelle = 1; // currentTr.find('input[input-name="quantite_usuelle"]').val();
                divUnity = currentTr.find('#devis-produits-catalog-unite-id');
                unity = divUnity.children("option:selected").val();

                montantHT = currentTr.find('.montant_ht_value').text();
                montantTva = montantHT*tva/100;
                globalNbre = sum(globalNbre, parseFloat(quantite_usuelle));
                // globalSumTTc = sum(globalSumTTc, (prix_reference_ht != '' ? prix_reference_ht : 0)*quantite_usuelle);
                globalMontantHT = sum(globalMontantHT, parseFloat(montantHT != '' ? montantHT : 0));
                globalTVA = sum(globalTVA, montantTva);
                
                globalSumTTc = sum(globalMontantHT,globalTVA);
            } else {
                hasOption = 1;
            }
        });
        
        var remisGV = $('#remise-global-value').val() != ''? $('#remise-global-value').val():0;

        if(remisGV != 0 && $('#remise-global-unity').val() == '€' && blockOperation) {
            $('#remise-global-unity').val('%');
            alert ('On peut pas faire la remise en montant si on a 2 taux de tva différents...');
        }else {
            
            if($('#remise-global-unity').val() == '%') {
                globalRemiseHT = globalMontantHT * remisGV / 100;
                globalRemiseTVA = globalTVA * remisGV / 100;
            } else {
                globalRemiseHT = parseFloat(remisGV);
                globalRemiseTVA = globalRemiseHT * lineTva / 100;
            }
            globalTotalAfterRemiseHT = globalMontantHT - globalRemiseHT;
            globalSumTTc = globalTotalAfterRemiseHT + globalTVA; // <= bug qd il y a remise
            globalTVA = globalTVA - globalRemiseTVA;

            $('.total_general_ht').text(globalMontantHT.toFixed(2));
            $('.total_general_ttc').text((globalTotalAfterRemiseHT + globalTVA).toFixed(2));
            $('.total_general_tva').text(globalTVA.toFixed(2));
            $('.remise-global-ht').text(globalRemiseHT.toFixed(2));
            $('.total-after-remise').text(globalTotalAfterRemiseHT.toFixed(2));
            $('.nombre_produit').text(globalNbre);
            if(hasOption == 1) {
                $('.label-montant-ht').text('Montant total HT (hors options)');
            } else {
                $('.label-montant-ht').text('Montant total HT');
            }

            sousTotal();
            majRecapClient();
            // echeanceUpdate();
        }
    }
    
    function majRecapClient() {
        totalHtClient = 0;
        totalTvaClient = 0;
        hasAbonnement = 0;
        hasOption = 0;
        globalRemiseHTClient = 0;
        globalRemiseTVAClient = 0;
        lineTva = '';
        blockOperation = false;
        
        tbody.find('.montant_ht').each(function(index, el) {
            currentTr = $(this).parents('tr');
            if (currentTr.find('[input-name="type_ligne"]').val() == 'abonnement') {
                hasAbonnement = 1;
                montant_ht_client = currentTr.find('.montant_ht_client').text();
                tva_client = currentTr.find('[input-name="tva_client"]').val();
                totalHtClient = sum(totalHtClient, parseFloat(montant_ht_client != '' ? montant_ht_client : 0));
                tvaClient = montant_ht_client*tva_client/100;
                totalTvaClient = sum(totalTvaClient, tvaClient);
                
                if(lineTva == '') {
                    lineTva = tva_client;
                } else {
                    if(lineTva != tva_client) {
                        blockOperation = true;
                    }
                }
            } else if (currentTr.find('[input-name="type_ligne"]').val() == 'produit') {
                if( ! $(this).hasClass('ligne-option')) {
                    montant_ht_value = currentTr.find('.montant_ht_value').text();
                    tva = currentTr.find('[input-name="tva"]').val();
                    montantTva = montant_ht_value*tva/100;
                    totalTvaClient = sum(totalTvaClient, montantTva);
                    totalHtClient = sum(totalHtClient, parseFloat(montant_ht_value != '' ? montant_ht_value : 0));

                    if(lineTva == '') {
                        lineTva = tva;
                    } else {
                        if(lineTva != tva) {
                            blockOperation = true;
                        }
                    }
                }
            }
        });
        
        var remisGV = $('#remise-global-value').val() != ''? $('#remise-global-value').val():0;
        if(remisGV != 0 && $('#remise-global-unity').val() == '€' && blockOperation) {
            $('#remise-global-unity').val('%');
            alert ('On peut pas faire la remise en montant si on a 2 taux de tva différents...');
            
        }else {
            if($('#remise-global-unity').val() == '%') {
                globalRemiseHTClient = totalHtClient * remisGV / 100;
                globalRemiseTVAClient = totalTvaClient * remisGV / 100;
            } else {
                globalRemiseHTClient = parseFloat(remisGV);
                globalRemiseTVAClient = globalRemiseHTClient * lineTva / 100;
            }
            
            TotalAfterRemiseHT = totalHtClient - globalRemiseHTClient;
            totalTvaClient = totalTvaClient - globalRemiseTVAClient;

            if(hasAbonnement) {
                $('.total_general_tva_client').text(totalTvaClient.toFixed(2));
                $('.total_general_ht_client').text(totalHtClient.toFixed(2));
                $('.total_general_ttc_client').text((TotalAfterRemiseHT + totalTvaClient).toFixed(2));
                $('.remise-global-ht-client').text(globalRemiseHTClient.toFixed(2));
                $('.total-after-remise-client').text(TotalAfterRemiseHT.toFixed(2));
                $('.total-avec-abonnement').removeClass('d-none');
            } else {
                $('.total_general_tva_client').text(0);
                $('.total_general_ht_client').text(0);
                $('.total_general_ttc_client').text(0);
                $('.remise-global-ht-client').text(0);
                $('.total-after-remise-client').text(0);
                $('.total-avec-abonnement').addClass('d-none');
            }
        }
    }

    // Calcul sous total
    function sousTotal() {
        tbody = $('tbody.default-data');
        total = 0;

        tbody.find('.montant_ht').each(function(index, el) {
            currentTr = $(this).parents('tr');
            if (currentTr.find('.montant_ht_value').hasClass('sous-total-value')) {
                currentTr.find('[input-name="sous_total"]').val(total.toFixed(2))
                currentTr.find('.montant_ht_value').text(total.toFixed(2));
                total = 0;
            } else {
                if( ! $(this).hasClass('ligne-option')) {
                    if (currentTr.find('[input-name="type_ligne"]').val() == 'abonnement') {
                        total = sum(total, (parseFloat(currentTr.find('.montant_ht_client').text() != '' ? currentTr.find('.montant_ht_client').text() : 0)));
                    } else {
                        total = sum(total, (parseFloat(currentTr.find('.montant_ht_value').text() != '' ? currentTr.find('.montant_ht_value').text() : 0)));
                    }
                }
            }
        });
        orderLine();
    }

    // set ordre line
    function orderLine() {
        tbody = $('tbody.default-data');
        ordre = 0;

        tbody.find('.i-position').each(function(index, el) {
            $(this).val(ordre++);
        });
    }

    // Possibilité d'ajouter un élement à partir d'une ligne
    function setSublineBehavior() {
        tbody = $('tbody.default-data');

        // Ajout ligne
        createTrLineOnClick({'classTarget': '.ajout-dessus a.ligne', 'position': 'beforeCurrentLine', 'classType': 'clone'})
        createTrLineOnClick({'classTarget': '.ajout-dessous a.ligne', 'position': 'afterCurrentLine', 'classType': 'clone'})

        // Ajout titre
        createTrLineOnClick({'classTarget': '.ajout-dessus a.titre', 'position': 'titreBeforeCurrentLine', 'classType': 'clone-titre'})
        createTrLineOnClick({'classTarget': '.ajout-dessous a.titre', 'position': 'titreAfterCurrentLine', 'classType': 'clone-titre'})

        // Ajout objet catalog
        createTrLineObjectOnClick({'classTarget': '.ajout-dessus a.object','position': 'beforeCurrentLine'})
        createTrLineObjectOnClick({'classTarget': '.ajout-dessous a.object','position': 'afterCurrentLine'})

        // Ajout sous total
        createTrLineOnClick({'classTarget': '.ajout-dessus a.sous-total', 'position': 'sousTotalBeforeCurrentLine', 'classType': 'clone-sous-total'})
        createTrLineOnClick({'classTarget': '.ajout-dessous a.sous-total', 'position': 'sousTotalAfterCurrentLine', 'classType': 'clone-sous-total'})

        // Ajout commentaire
        createTrLineOnClick({'classTarget': '.ajout-dessus a.commentaire', 'position': 'commentBeforeCurrentLine', 'classType': 'clone-commentaire'})
        createTrLineOnClick({'classTarget': '.ajout-dessous a.commentaire', 'position': 'commentAfterCurrentLine', 'classType': 'clone-commentaire'})

        // Ajout saut de ligne
        createTrLineOnClick({'classTarget': '.ajout-dessus a.saut-ligne', 'position': 'sautLigneBeforeCurrentLine', 'classType': 'clone-saut-ligne'})
        createTrLineOnClick({'classTarget': '.ajout-dessous a.saut-ligne', 'position': 'sautLigneAfterCurrentLine', 'classType': 'clone-saut-ligne'})

        // Ajout saut de page
        createTrLineOnClick({'classTarget': '.ajout-dessus a.saut-page', 'position': 'sautPageBeforeCurrentLine', 'classType': 'clone-saut-page'})
        createTrLineOnClick({'classTarget': '.ajout-dessous a.saut-page', 'position': 'sautPageAfterCurrentLine', 'classType': 'clone-saut-page'})
        
        // Ajout new-abonnement
        createTrLineOnClick({'classTarget': '.ajout-dessus a.new-abonnement', 'position': 'commentBeforeCurrentLine', 'classType': 'clone-new-abonnement'})
        createTrLineOnClick({'classTarget': '.ajout-dessous a.new-abonnement', 'position': 'commentAfterCurrentLine', 'classType': 'clone-new-abonnement'})

        createTrLineOptionOnClick()
        removeTrLineOptionOnClick()
        
        createTrLineAbonnementOnClick()
        removeTrLineAbonnementOnClick()
        
        cloneTrLineOnClick()
    }

    /**
     * [createTrLineOnClick description]
     * @param  {[type]} params classTarget|position|classType
     */
    function createTrLineOnClick(params) {
        $(params.classTarget).off();
        tbody.on('click', params.classTarget, function(event) {
            currentTr = $(this).parents('tr');
            addNewLineLine(params.position, currentTr, data = null, class_type = params.classType);
        });
    }

    /**
     * @param  {[type]} params classTarget|position|classType
     */
    function createTrLineObjectOnClick(params) {
        tbody.on('click', params.classTarget, function(event) {
            var curentTrForObject = $(this).parents('tr');
            var trIndex = curentTrForObject.index();
            var btnModalSubmit = $('#devis_catalog').find('button#submit-catalog');
            $('#position').val(params.position);
            $('#devis_catalog').modal('show', function () {
                var liParent = $(params.classTarget, curentTrForObject).parents('li');
                btnModalSubmit.removeClass('ajout-dessous').removeClass('ajout-dessus');
                if (liParent.hasClass('ajout-dessous')) {
                    btnModalSubmit.addClass('ajout-dessous');
                }
                if (liParent.hasClass('ajout-dessus')) {
                    btnModalSubmit.addClass('ajout-dessus');
                }

                btnModalSubmit.attr('tr-index', trIndex);
            });
        });
    }

    $('#devis_factures_catalog').modal('show', function (e) {
        alert('ok')
    });
    
    function createTrLineOptionOnClick(params) {
        tbody.on('click', '.option a.set-ligne-option', function(event) {
            $(this).parents('tr').addClass('ligne-option');
            $(this).parents('tr').find('.montant_ht').addClass('ligne-option');
            $(this).parents('tr').find('[input-name="line_option"]').val(1);
            majRecap();
        });
    }
    
    function removeTrLineOptionOnClick(params) {
        tbody.on('click', '.option a.del-ligne-option', function(event) {
            $(this).parents('tr').removeClass('ligne-option');
            $(this).parents('tr').find('.montant_ht').removeClass('ligne-option');
            $(this).parents('tr').find('[input-name="line_option"]').val(0);
            majRecap();
        });
    }
    
    
    function createTrLineAbonnementOnClick(params) {
        tbody.on('click', '.abonnement a.set-ligne-abonnement', function(event) {
            $(this).parents('tr').removeClass('clone').addClass('clone-new-abonnement');
            $(this).parents('tr').find('.ligne-for-abonnement').removeClass('d-none');
            $(this).parents('tr').find('[input-name="type_ligne"]').val('abonnement');
            $(this).parents('tr').find('[input-name="unites_client_id"]').val(0);
            $(this).parents('tr').find('[input-name="tva_client"]').val(20);
            $(this).parents('tr').find('[input-name="quantite_client"]').val(1);
            majRecap();
        });
    }
    
    function removeTrLineAbonnementOnClick(params) {
        tbody.on('click', '.abonnement a.del-ligne-abonnement', function(event) {
            $(this).parents('tr').removeClass('clone-new-abonnement').addClass('clone');
            $(this).parents('tr').find('.ligne-for-abonnement').addClass('d-none');
            $(this).parents('tr').find('[input-name="type_ligne"]').val('produit');
            $(this).parents('tr').find('[input-name="tarif_client"]').val('');
            $(this).parents('tr').find('[input-name="unites_client_id"]').val('');
            $(this).parents('tr').find('[input-name="tva_client"]').val('');
            $(this).parents('tr').find('[input-name="quantite_client"]').val('');
            $(this).parents('tr').find('[input-name="montant_client"]').val('');
            majRecap();
        });
    }
    
    function cloneTrLineOnClick() {
        tbody.on('click', '.clone-tr', function(event) {
            curentTr = $(this).parents('tr');
            clonedTr = $(this).parents('tr').clone();
            classType = 'clone';
            position = 'beforeCurrentLine';
            if (clonedTr.hasClass('clone-new-abonnement')) {
                classType = 'clone-new-abonnement';
                position = 'commentAfterCurrentLine';
            }
            if(clonedTr.hasClass('clone-sous-total')) {
                classType = 'clone-sous-total';
                position = 'sousTotalAfterCurrentLine';
            }
            if(clonedTr.hasClass('clone-titre')) {
                classType = 'clone-titre';
                position = 'titreAfterCurrentLine';
            }
            if(clonedTr.hasClass('clone-commentaire')) {
                classType = 'clone-commentaire';
                position = 'commentAfterCurrentLine';
            }
            if(clonedTr.hasClass('clone-saut-ligne')) {
                classType = 'clone-saut-ligne';
                position = 'sautLigneAfterCurrentLine';
            }
            if(clonedTr.hasClass('clone-saut-page')) {
                classType = 'clone-saut-page';
                position = 'sautPageAfterCurrentLine';
            }
            
            data = {
                'id':clonedTr.find('[input-name="catalog_produits_id"]').val(),
                'is_consommable':clonedTr.find('[input-name="is_consommable"]').val(),
                'nom_commercial':clonedTr.find('[input-name="nom_commercial"]').val(),
                'reference':clonedTr.find('[input-name="reference"]').val(),
                'description_commercial':clonedTr.find('[input-name="description_commercial"]').val(),
                'prix_reference_ht':clonedTr.find('[input-name="prix_reference_ht"]').val(),
                'catalog_unites_id':clonedTr.find('[input-name="catalog_unites_id"]').val(),
                'quantite_usuelle':clonedTr.find('[input-name="quantite_usuelle"]').val(),

                'tarif_client':clonedTr.find('[input-name="tarif_client"]').val(),
                'unites_client_id':clonedTr.find('[input-name="unites_client_id"]').val(),
                'quantite_client':clonedTr.find('[input-name="quantite_client"]').val(),
                
                'sous_total':clonedTr.find('[input-name="sous_total"]').val(),
                'titre_ligne':clonedTr.find('[input-name="titre_ligne"]').val(),
                'commentaire_ligne':clonedTr.find('[input-name="commentaire_ligne"]').val(),
                'remise_value':clonedTr.find('[input-name="remise_value"]').val(),
                'remise_unity':clonedTr.find('[input-name="remise_unity"]').val(),
            };
                    
            addNewLineLine(position , curentTr, data, classType);
        });
    }
    
    function showTrRemiseGlobal() {
        gRemise = $('#remise-global-value').val();
        if(gRemise != '' && gRemise != 0) {
            $('.total-remise-global').removeClass('hide');
        } else {
            $('.total-remise-global').addClass('hide');
        }
    }

    $('.new_product_from_catalog').on('click', function() {
        $('#position').val('bottom');
    });

    // Send products from modal's form catalog to estimate products s form
    $('#devis_catalog').on('shown.bs.modal', function(e) {
        currentLink = $(e.relatedTarget);
        currentModal = $(e.currentTarget);
    });

    $('#submit-catalog').on('click', function(event) {
        containerIds = [];
        $('#submit-catalog').addClass('disabled').text('Chargement ...');

        $('.selected-produits .catalog-produit').each(function() {
            if ($(this).is(':checked')) {
                $(this).prop('checked', false);
                $(this).parents('tr').removeClass("selected-tr");
                var id = $(this).val();
                containerIds.push({'id' : id});
            }
        });

        var currentTrIndex = $(this).attr('tr-index');
        var currentTr = $('.table_bloc_devis .default-data tr').get(currentTrIndex);
        setProductAfterSubmitingModal(0, $(currentTr), $(this));
    });

    // il faut attendre qu'un xhr soit chargé pour charger la prochaine occurence sinon bug si tout ajouter en une fois
    function setProductAfterSubmitingModal(key, tr = null, targetBtnModalSubmit = null) {
        content = containerIds[key];
        if (content === undefined) {
            $('#devis_catalog').modal('hide');
            $('#submit-catalog').removeClass('disabled').text('Valider');
            return false;
        }
        id = content.id;

        $.get(srcUrl + 'fr/catalog-produits/get-produit-by-id/' + id, function(data, xhr) {

            $('tbody').removeAttr('style');
            $('.detail-form').removeClass('d-none');

            position = 'bottom';
            if (tr != null && targetBtnModalSubmit != null) {
                if (targetBtnModalSubmit.hasClass('ajout-dessous')) {
                    position = 'afterCurrentLine';
                }

                if (targetBtnModalSubmit.hasClass('ajout-dessus')) {
                    position = 'beforeCurrentLine';
                }
            }

            addNewLineLine(position, tr, data).promise().then(function (e) {
                setProductAfterSubmitingModal(key+1, tr, targetBtnModalSubmit);
            });
        });
    }
    // -------- end ----------

    // Ordonner
    $('#sortable').sortable({
        placeholder: "tr-ligne-highlight",
        helper: function(e, ui) {
            ui.parents('table').find('thead').children().each(function() {
                $(this).width($(this).width());
            });
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        },
        cursor: "move",
        handle: 'a.fa-arrows-alt-v',
        axis: 'y',
        stop: function(event, ui) {
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
        },
        update: function(event, ui) {
            sousTotal();
        }
    });
    
    $('.annuler_modele').on('click', function(event) {
        $('#is_model').val(0);
        $('#model-name').prop('required', false);
        $('#modele-devis-categories-id').prop('required', false);
        $('#modele-devis-sous-categories-id').prop('required', false);
        $('#model_devis').modal('hide');
    });
    
    $('.save_model').on('click', function(event) {
        $('#model-name').prop('required', true);
        $('#modele-devis-categories-id').prop('required', true);
        $('#modele-devis-sous-categories-id').prop('required', true);
    });

    // deinfition ordre avant save
    $('.save_devis').on('click', function(event) {
        event.preventDefault();
        submit();
    });

    $('.save_continuer_devis').on('click', function(event) {
        event.preventDefault();
        $('#is_continue').val(1);
        submit();
    });
    
    $('.model_submit').on('click', function(event) {
        event.preventDefault();
        $('#is_model').val(1);
        if($('#model-name').val() != '' && $('#modele-devis-categories-id').val() != '') {
            submit();
        }
    });

    // Traitement donnes avant enregistrement
    function submit() {
        if($('#objet').val() == '') {
            alert('Objet du devis doit être non vide');
        } else {
            $('input[input-name="remise_value"], select[input-name="remise_unity"]').prop('disabled', false);
            $('.table_bloc_devis tfoot').remove();

            $('.table_bloc_devis tbody.default-data tr').each(function(index, el) {
                trIndex = index;
                currentTr = $(this);
                trInputName = currentTr.find('[input-name]');

                trInputName.each(function(index, el) {
                    $(this).attr('name', 'devis_produits[' + trIndex + '][' + $(this).attr('input-name') + ']');
                });

                // envoi des divers montants globaux vers les inputs respectifs
                $('.montant_general').each(function(index, el) {
                    montant = $(this).text();
                    currentTr = $(this).parents('tr');
                    currentTr.find('input').val(montant);
                });

            }).promise().then(function(e) {
                $('.form-devis').submit();
            });
        }
    }
    
    $('#remise-global-value').on('blur', function(){
        $('input[input-name="remise_value"]').trigger('blur');
        showTrRemiseGlobal();
        majRecap();
    });
    
    $('#remise-global-unity').on('change', function(){
        $('input[input-name="remise_value"]').trigger('blur');
        majRecap();
    });
    
    $("#remise-line").on('change', function(){
        if($(this).is(':checked')){
            $('input[input-name="remise_value"], select[input-name="remise_unity"]').prop('disabled', false);
        }else {
            $('input[input-name="remise_value"]').val(0);
            $('input[input-name="remise_value"], select[input-name="remise_unity"]').prop('disabled', true);
            $('input[input-name="remise_value"], select[input-name="remise_unity"]').change().prop('disabled', true);
        }
        $('input[input-name="remise_value"]').trigger('blur');
        showTrRemiseGlobal();
        majRecap();
    });
    $('#remise-line').trigger('change');
    
    $('#remise-line').on('click', function() {
        $("#remise-hide-line").click();
    });
    
    
    $("#remise-hide-line").on('change', function(){
        if($(this).is(':checked')){
            $('.remise').addClass('hide');
            $('th.remise .visibility-mark').addClass('isInnactive');
            $('.dynamic-colspan').each(function() {
                cols = $(this).prop('colspan');
                $(this).prop('colspan',cols - 1);
            });
        }else {
            $('.remise').removeClass('hide');
            $('th.remise .visibility-mark').removeClass('isInnactive');
            $('.dynamic-colspan').each(function() {
                cols = $(this).prop('colspan');
                $(this).prop('colspan',cols + 1);
            });
        }
        
        name = $('th.remise .visibility-mark').attr('data');
        isInnactive = $('th.remise .visibility-mark').hasClass('isInnactive');
        if (isInnactive) {
            $('th.remise .visibility-mark').find('.fa').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $('th.remise .visibility-mark').find('.fa').removeClass('fa-eye-slash').addClass('fa-eye');
        }
        dataVisibilityParams[name] = $('th.remise .visibility-mark').hasClass('isInnactive');
        $('[name="col_visibility_params"]').val(JSON.stringify(dataVisibilityParams));
    });
//    $('#remise-hide-line').trigger('change');
    
    $('#modele-devis-categories-id').on('change', function() {
        catId = $(this).val();
        sCatId = $('#sCatId').val();
        listSousCat = modelDevisSousCategorie[catId];
        option = '<option value>Séléctionner</option>';
        $.each(listSousCat, function(key, value){
            if(key == sCatId) {
                option += '<option value="'+key+'" selected=selected>'+value+'</option>';
            } else {
                option += '<option value="'+key+'">'+value+'</option>';
            }
        });
        $('#modele-devis-sous-categories-id').html(option);
    });
    $('#modele-devis-categories-id').trigger('change');
    
    // changer les info et addr commercial
    $('#ref-commercial-id').on('change', function() {
        var idCommercial = $(this).children("option:selected").val();
        if (idCommercial > 0) {
            $.ajax({
                url: srcUrl + 'fr/ajax-devis/changeAddInfo',
                type: "POST",
                dataType: 'json',
                data: {
                    idCommercial: idCommercial
                },
                success: function(data) {
                    // console.log(data)
                    if (data.status == 1) {
                        $('.bloc-addr').remove('hide');
                        $('.infos').remove('hide');

                        // Changement de toutes les données du commercial
                        $('#full_name').html(data.user.prenom + ' ' + data.user.nom);
                        $('#telephone_fixe').html(data.user.telephone_portable);
                        $('#email').html(data.user.email);
                        $('#link-user').attr('href', srcUrl + 'fr/users/edit/' + data.user.id);
                    }
                },
                error: function(data) {
                    console.log('Erreur:', data);
                },
            });

        }
    });
    
    $("#display-tva").on('click', function(){
        if($(this).is(':checked')) {
            $('.tva-value').val(0);
            $('.tva-value').prop('disabled', true);
        } else {
            $('.tva-value').prop('disabled', false);
        }
        majRecap();
    });
});
