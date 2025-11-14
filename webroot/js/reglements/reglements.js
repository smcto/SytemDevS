$(document).ready(function () {
    var srcUrl = $("#id_baseUrl").attr('value');
    
    $('.dataTables_wrapper').removeClass('hide');

    // si période personnalisée : on affiche un date picker qui permet de gérer une période.
    $('input[name="date_threshold"]').daterangepicker({
        locale: {
            // "format": 'YYYY-MM-DD',
            "format": 'DD/MM/YYYY',
            "separator": " - ",
            "applyLabel": "Appliquer",
            "cancelLabel": "Annuler",
            "fromLabel": "De",
            "toLabel": "À",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "firstDay": 1
        }
    });

    $('#id_periode').on('change', function(event) {
        if ($(this).val() == 'custom_threshold') {
            $('.container_date_threshold').removeClass('d-none');
            $('.custom-col-width').addClass('custom-col-width-small')
        } else {
            $('.container_date_threshold').addClass('d-none');
            $('.custom-col-width').removeClass('custom-col-width-small')
        }
    });
    
    $('.summernote').summernote({
        height: '100%',   //set editable area's height
        lang: 'fr-FR',
        toolbar: [
            ['style', ['bold', 'italic', 'link', 'ul']]
        ],
    });
    
    $('.select2').select2({
        dropdownParent: $("#add_reglement"),
        allowClear: true
    });
    
    $('.select').select2({
        allowClear: true
    });
    
    
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
                url: srcUrl + "fr/ajax-clients/search-client",
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
    
    
    // Get the input field
    var input = document.getElementById("indent");

    // Execute a function when the user releases a key on the keyboard
    input.addEventListener("keyup", function(event) {
      // Number 13 is the "Enter" key on the keyboard
      if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById("search-factures").click();
      }
    });
    
    $('#search-factures').on('click', function () {
        var indent = $("#indent").val();
        if(indent){
            var client_id = $('#facture_client_id').val();
            searchFacture(indent,client_id);
        }
    });
    $("#indent").keyup(function(){
        var indent = $(this).val();
        if(indent.length > 2){
            var client_id = $('#facture_client_id').val();
            searchFacture(indent, client_id);
        }
    });

    addAvoir();
    addFacture();
    remodeAddeLine();
    removeLineAvoir();
    changeMontantLieAfterAdded();
    changeMontantLieAfterAddedAvoir();

    $('#edit_client').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        modal.find('#title').text(link.attr('data-title'));
        modal.find('#reglement_id').val(link.attr('data-reglement'));
    });
    
    $('#cancel-search').on('click', function () {
        $('#indent').val('');
        $("#table-list table tbody").html('<tr><td colspan="10" class="text-center">Rechercher pour afficher les listes</td></tr>');
        $("#id_loader").hide();
    });
    
    $('#solder_facture').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var client = link.attr('data-client');
        //alert(link.attr('data-reglement'));
        var reglement = JSON.parse(link.attr('data-reglement'));
        modal.find('form').attr('action', link.attr('data-href'));
        modal.find('form').submit(function(event) {});
        modal.find('#facture_client_id').val(client);
        modal.find('.client-nom').text(reglement.client?reglement.client.nom:"--");
        modal.find('.date-reglement').text(reglement.date);
        modal.find('.moyen-paiement').text(reglement.moyen_reglement?reglement.moyen_reglement.name:reglement.sellsy_moyen_reglement);
        modal.find('.montant').text(addCommas(reglement.montant) + ' €');
        modal.find('.value-montant').val(reglement.montant);
        modal.find('.rest').text(reglement.rest?reglement.rest:0);
        $('.rm_rglmt_solde_disponible').val(reglement.solde_disponible)
        
        $('.rm_rglmt_solde_disponible').attr('data-soldeinitiale',reglement.solde_disponible);
        $("#table-list table tbody").html('<tr><td colspan="10" class="text-center">Rechercher pour afficher les listes</td></tr>');
        initTableFacture(reglement.devis_factures, reglement.montant_lie);

        //Par défaut affichier les factures non payé
        var client_id = $('#facture_client_id').val();
        searchFacture("FK-", client_id);
        countTotal();
    });
    
    
    $("body").on('click', "#id_chercheFactByClientAnd", function(){
        var idClient = $("#client_liste").val();
        var indent = $("#id_indentValue").val();
        searchFacture(indent, idClient,'#id_listeAddClientRegelement', 1);
    });
    
    $( "body" ).on( "change", "#id_lie_regelement", function() {
        if($(this).is(':checked')){
            $("#id_tolinkReglement").removeClass('hide');

            var idClient = $("#client_liste").val();
            var indent = $("#id_indentValue").val();
            searchFacture(indent, idClient,'#id_listeAddClientRegelement', 1);
            
        }else{
            $("#id_tolinkReglement").addClass('hide');
        }
    });

    $('#search-avoir').on('click', function () {
        var indent = $("#num_avoir").val();
        if(indent){
            var client_id = $('#avoir_client_id').val();
            searchAvoirs(indent,client_id);
        }
    });
    
    $("#num_avoir").keyup(function(){
        var indent = $(this).val();
        if(indent.length > 2){
            var client_id = $('#avoir_client_id').val();
            searchAvoirs(indent, client_id);
        }
    });

    $('#cancel-search-avoir').on('click', function () {
        $('#indent').val('');
        $("#table-list-avoir table tbody").html('<tr><td colspan="10" class="text-center">Rechercher pour afficher les listes</td></tr>');
        $(".loader").hide();
    });
    
    $('#solder_avoirs').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var client = link.attr('data-client');
        //alert(link.attr('data-reglement'));
        var reglement = JSON.parse(link.attr('data-reglement'));
        modal.find('form').attr('action', link.attr('data-href'));
        modal.find('form').submit(function(event) {});
        modal.find('#avoir_client_id').val(client);
        modal.find('.client-nom').text(reglement.client?reglement.client.nom:"--");
        modal.find('.date-reglement').text(reglement.date);
        modal.find('.moyen-paiement').text(reglement.moyen_reglement?reglement.moyen_reglement.name:reglement.sellsy_moyen_reglement);
        modal.find('.montant').text(addCommas(reglement.montant) + ' €');
        modal.find('.value-montant').val(reglement.montant);
        modal.find('.rest').text(reglement.rest?reglement.rest:0);
        $('.rm_rglmt_solde_disponible').val(reglement.solde_disponible)

        $('.rm_rglmt_solde_disponible').attr('data-soldeinitiale',reglement.solde_disponible);
        $("#table-list table tbody").html('<tr><td colspan="10" class="text-center">Rechercher pour afficher les listes</td></tr>');
        initTableAvoirs(reglement.avoirs, reglement.montant_lie);

        //Par défaut affichier les factures non payé
        var client_id = $('#avoir_client_id').val();
        searchAvoirs("avr", client_id);
        countTotalAvoir();
    });

});

function searchAvoirs(indent, client_id, appenTo ='#table-list-avoir', checkBox = 0, montantReglement = 0){
    indent = indent.trim();
    var srcUrl = $("#id_baseUrl").attr('value');
    $('#search-avoir').text('Rechercher ...');
    $.ajax({
        url: srcUrl + "fr/ajax-avoirs/refresh-list?indent=" + indent + "&client_id=" + client_id + "&checkBox="+checkBox+"&montantReglement="+montantReglement,
        type: "GET",
        beforeSend: function() {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").hide();
            $(appenTo).html(data);
            $('#search-avoir').text('Rechercher');
        }
    });
}

function searchFacture(indent, client_id, appenTo ='#table-list', checkBox = 0, montantReglement = 0){
    indent = indent.trim();
    var srcUrl = $("#id_baseUrl").attr('value');
    $('#search-factures').text('Rechercher ...');
    $.ajax({
        url: srcUrl + "fr/ajax-devis-factures/refresh-list-factures?indent=" + indent + "&client_id=" + client_id + "&checkBox="+checkBox+"&montantReglement="+montantReglement,
        type: "GET",
        beforeSend: function() {
            $("#id_loader").show();
        },
        success: function (data) {
            $("#id_loader").hide();
            $(appenTo).html(data);
            $('#search-factures').text('Rechercher');
            checkFactureInAddReglement();
        }
    });
}

function addFacture() {
    
    $( "body" ).on( "click", ".add-facture", function() {
        var soldeDisponible = parseFloat($(".rm_rglmt_solde_disponible").val());
        //alert('soldeDisponible '+soldeDisponible);
        console.log('soldeDisponible '+soldeDisponible);
        if(soldeDisponible > 0){
            var facture = $(this).find('.value-facture').val();

            if ($('.first-tr').html() != 'undefined') {
                $('.first-tr').remove();
            }
            var data = JSON.parse(facture);
            var clonedTr = $('table.facture-liee tfoot tr').last().clone();
            var addLine = $('tbody.default-data').append(clonedTr);

            return addLine.promise().then(function(e) {
                var i = $('tbody.default-data').find('tr').length;
                var j = i-1;
                var newTr = $('tbody.default-data').find('tr').last();
                newTr.attr('id','id_added_fac_'+data.id);
                newTr.attr('data-id',data.id);
                newTr.find('td.num').text(data.indent);
                newTr.find('td.ht').text(data.total_ht);
                newTr.find('td.ttc').text(data.total_ttc);
                newTr.find('td.restant_du').text(parseFloat(data.reste_du ? data.reste_du : 0).toFixed(2));
                newTr.find('td.unity').text('€');
                //newTr.find('.removed').attr('onclick', 'removeLine(' + i + ')');
                newTr.find('.removed').attr('id',"id_added_"+data.id)
                newTr.find('.removed').attr('data-id',data.id);
                newTr.find('.facture_id').val(data.id);
                //newTr.find('.facture_id').attr('name', 'devis_factures[_ids][' + j + ']');
                newTr.find('.facture_id').attr('name', 'devis_factures[' + j + '][id]');

                var montantLie = data.reste_du;
                if(data.reste_du > soldeDisponible){
                    montantLie = soldeDisponible;
                }
                //alert('montantLie '+montantLie);
                montantLie = parseFloat(montantLie).toFixed(2);
                newTr.find('.crm_montantLie').val(montantLie);
                newTr.find('.crm_montantLie').attr('data-id',data.id);
                newTr.find('.crm_montantLie').attr('name', 'devis_factures[' + j + '][_joinData][montant_lie]');


                //alert(' 2'+montantLie);
                //Calcul solde dispo
                var montantDisponible = parseFloat($(".rm_rglmt_solde_disponible").val());
                //var montantLie = parseFloat(montantLie);
                var reste = montantDisponible - montantLie;
                reste = parseFloat(reste).toFixed(2);
                $(".rm_rglmt_solde_disponible").val(reste);
                $(".rest-facture").text(addCommas(parseFloat(reste).toFixed(2)));

                countTotal();
                $("#id_facture_"+data.id).addClass('hide');

            });
        }else{
            alert('Vous avez atteint le montant du réglement.')
        }
    });
}

function addAvoir() {
    
    $( "body" ).on( "click", ".add-avoir", function() {
        var soldeDisponible = parseFloat($(".rm_rglmt_solde_disponible").val());

        if(soldeDisponible > 0){
            var avoir = $(this).find('.value-avoir').val();

            if ($('.first-tr').html() != 'undefined') {
                $('.first-tr').remove();
            }
            var data = JSON.parse(avoir);
            var clonedTr = $('table.avoir-liee tfoot tr').last().clone();
            var addLine = $('tbody.default-data-avoir').append(clonedTr);

            return addLine.promise().then(function(e) {
                var i = $('tbody.default-data-avoir').find('tr').length;
                var j = i-1;
                var newTr = $('tbody.default-data-avoir').find('tr').last();
                newTr.attr('id','id_added_avoir_'+data.id);
                newTr.attr('data-id',data.id);
                newTr.find('td.num').text(data.indent);
                newTr.find('td.ht').text(data.total_ht);
                newTr.find('td.ttc').text(data.total_ttc);
                newTr.find('td.restant_du').text(parseFloat(data.reste_du ? data.reste_du : 0).toFixed(2));
                newTr.find('td.unity').text('€');
                newTr.find('.removed').attr('id',"id_added_"+data.id)
                newTr.find('.removed').attr('data-id',data.id);
                newTr.find('.avoir_id').val(data.id);
                newTr.find('.avoir_id').attr('name', 'avoirs[' + j + '][id]');

                var montantLie = data.reste_du;
                if(data.reste_du > soldeDisponible){
                    montantLie = soldeDisponible;
                }
                //alert('montantLie '+montantLie);
                montantLie = parseFloat(montantLie).toFixed(2);
                newTr.find('.crm_montantLie').val(montantLie);
                newTr.find('.crm_montantLie').attr('data-id',data.id);
                newTr.find('.crm_montantLie').attr('name', 'avoirs[' + j + '][_joinData][montant_lie]');

                var montantDisponible = parseFloat($(".rm_rglmt_solde_disponible").val());
                var reste = montantDisponible - montantLie;
                reste = parseFloat(reste).toFixed(2);
                $(".rm_rglmt_solde_disponible").val(reste);
                $(".rest-facture").text(addCommas(parseFloat(reste).toFixed(2)));

                countTotalAvoir();
                $("#id_avoir_"+data.id).addClass('hide');

            });
        }else{
            alert('Vous avez atteint le montant du réglement.')
        }
    });
}

function countTotalAvoir() {
    
    var montantReglement = Number($('.value-montant').val());
    var rest = Number($('.rest').text());
    var total = 0;
    var tr = $('tbody.default-data-avoir').find('tr');
    var nbrFact = 0;
    tr.each(function() {
        var restantDu = $(this).find('.restant_du').text();
        total += Number(restantDu != '' ? restantDu : 0);
        nbrFact ++;
    });
    rest = montantReglement - total;
    $('.total-facture').text(addCommas(parseFloat(total).toFixed(2)) + ' €');

    if(rest < 0) {
        rest = -1 * rest;
    } else {
        rest = 0;
    }
    $('.value-rest').val(parseFloat(rest).toFixed(2));
    $('.rest').text(parseFloat(rest).toFixed(2) + ' €');

    if(nbrFact > 1){
        $(".col_montantLie").removeClass('hide');
    }else{
        $(".col_montantLie").addClass('hide');
    }
}


function initTableAvoirs(datas, montantlie) {
    $("tbody.default-data-avoir").html('<tr class="first-tr"><td colspan="5" class="text-center">Aucune avoir liée.</td></tr>');
    if(datas.length >0) {
        if ($('.first-tr').html() != 'undefined') {
            $('.first-tr').remove();
        }
        addData(datas, datas.length - 1, montantlie);
    }
    countTotalAvoir();

}

function changeMontantLieAfterAddedAvoir(argument) {
    $("body" ).on( "focusout", ".crm_montantLie", function(e) {
        var idFacture = $(this).attr('data-id');
        var currentMontantLie = parseFloat($(this).val());
        var montaFacture = parseFloat($("#id_added_avoir_"+idFacture).find('.ttc').text());
        if(currentMontantLie > montaFacture){
            alert('Vous ne pouvez pas lié un montant suppérieur à la valeur de la facture');
            $(this).val(montaFacture);
            //return;
        }

        //comparaison de la somme par rapport au solde du reglement
        var soldeInitial = parseFloat($(".rm_rglmt_solde_disponible").attr('data-soldeinitiale'));
        var soldeDisponible = parseFloat($(".rm_rglmt_solde_disponible").val());
        var allMontant = 0;
        var resteSoldeInitial = 0;
        var sommeOtherChamp = 0;
        $(".crm_montantLie").each(function(){
            if($(this).val()){
                console.log($(this).val());
                allMontant = parseFloat(allMontant) + parseFloat($(this).val());
                if($(this).attr('data-id') != idFacture){
                    sommeOtherChamp = parseFloat(sommeOtherChamp) + parseFloat($(this).val());
                }
            }
        });
        if(allMontant > soldeInitial){
            alert('La somme de toute les factures ne doit pas dépasser le montant du règlement');
            $(this).val(soldeInitial - sommeOtherChamp);
        }

        //Update somme disponible
        var soldeInitial = parseFloat($(".rm_rglmt_solde_disponible").attr('data-soldeinitiale'));
        var soldeDispo = soldeInitial - sommeOtherChamp - parseFloat($(this).val());
        $(".rm_rglmt_solde_disponible").val(soldeDispo);
        $(".rest-facture").text(addCommas(parseFloat(soldeDispo).toFixed(2)));

        countTotalAvoir();
    });
}

function addData(datas, index, montantlie) {
    var data = datas[index];
    if (data != 'undefined') {
        var clonedTr = $('table.avoir-liee tfoot tr').last().clone();
        var addLine = $('tbody.default-data-avoir').append(clonedTr);

        addLine.promise().then(function(e) {
            var i = $('tbody.default-data-avoir').find('tr').length;
            var j = i-1;
            var newTr = $('tbody.default-data-avoir').find('tr').last();
            newTr.attr('id','id_added_avoir_'+data.id);
            newTr.attr('data-id',data.id);
            newTr.find('td.num').text(data.indent);
            newTr.find('td.ht').text(data.total_ht);
            newTr.find('td.ttc').text(data.total_ttc);
            newTr.find('td.restant_du').text(data.reste_du ? data.reste_du : 0);
            newTr.find('td.unity').text('€');
            newTr.find('.removed').attr('id',"id_added_"+data.id)
            newTr.find('.removed').attr('data-id',data.id);
            newTr.find('.avoir_id').val(data.id);
            newTr.find('.avoir_id').attr('name', 'avoirs[' + j + '][id]');
            console.log('data.id'+data.id);
            newTr.find('.crm_montantLie').val(montantlie[data.id]);
            newTr.find('.crm_montantLie').attr('data-id',data.id);
            newTr.find('.crm_montantLie').attr('name', 'avoirs[' + j + '][_joinData][montant_lie]');

            countTotalAvoir();
            if(index>0) {
                addData(datas, index-1, montantlie);
            }
        });

        //Ne pas afficher la colonne montant lié que lorsqu'on a plus d'une facture
        if($("#id_listeFact tr").length >= 2){
            $(".crm_mtlie").removeClass('hide');
        }
    }
}

function removeLineAvoir(){
    $( "body" ).on( "click", ".removed", function(e) {
        e.stopPropagation();
        if (confirm('êtes vous sûr de vouloir supprimer?')) {
            var idFactureToRemove = $(this).attr('data-id');

            var montantDisponible = parseFloat($(".rm_rglmt_solde_disponible").val());
            var montantSupprimer = parseFloat($("#id_added_avoir_"+idFactureToRemove+" .crm_montantLie").val());
            var somme = montantDisponible + montantSupprimer;
            somme = parseFloat(somme).toFixed(2);
            $(".rm_rglmt_solde_disponible").val(somme);
            $(".rest-facture").text(addCommas(parseFloat(somme).toFixed(2)));

            $("#id_added_avoir_"+idFactureToRemove).remove();
            $("#id_avoir_"+idFactureToRemove).removeClass('hide');


            countTotalAvoir();
        }
        return false;
    });
}

function changeMontantLieAfterAdded(argument) {
    $("body" ).on( "focusout", ".crm_montantLie", function(e) {
        var idFacture = $(this).attr('data-id');
        var currentMontantLie = parseFloat($(this).val());
        var montaFacture = parseFloat($("#id_added_fac_"+idFacture).find('.ttc').text());
        if(currentMontantLie > montaFacture){
            alert('Vous ne pouvez pas lié un montant suppérieur à la valeur de la facture');
            $(this).val(montaFacture);
            //return;
        }

        //comparaison de la somme par rapport au solde du reglement
        var soldeInitial = parseFloat($(".rm_rglmt_solde_disponible").attr('data-soldeinitiale'));
        var soldeDisponible = parseFloat($(".rm_rglmt_solde_disponible").val());
        var allMontant = 0;
        var resteSoldeInitial = 0;
        var sommeOtherChamp = 0;
        $(".crm_montantLie").each(function(){
            if($(this).val()){
                console.log($(this).val());
                allMontant = parseFloat(allMontant) + parseFloat($(this).val());
                if($(this).attr('data-id') != idFacture){
                    //console.log('je passe ici');
                    sommeOtherChamp = parseFloat(sommeOtherChamp) + parseFloat($(this).val());
                }
            }
        });
        if(allMontant > soldeInitial){
            alert('La somme de toute les factures ne doit pas dépasser le montant du règlement');
            $(this).val(soldeInitial - sommeOtherChamp);
        }

        //Update somme disponible
        var soldeInitial = parseFloat($(".rm_rglmt_solde_disponible").attr('data-soldeinitiale'));
        var soldeDispo = soldeInitial - sommeOtherChamp - parseFloat($(this).val());
        $(".rm_rglmt_solde_disponible").val(soldeDispo);
        $(".rest-facture").text(addCommas(parseFloat(soldeDispo).toFixed(2)));

        countTotal();
    });
}

function remodeAddeLine(){
    $( "body" ).on( "click", ".removed", function(e) {
        e.stopPropagation();
        if (confirm('êtes vous sûr de vouloir supprimer?')) {
            var idFactureToRemove = $(this).attr('data-id');

            var montantDisponible = parseFloat($(".rm_rglmt_solde_disponible").val());
            var montantSupprimer = parseFloat($("#id_added_fac_"+idFactureToRemove+" .crm_montantLie").val());
            var somme = montantDisponible + montantSupprimer;
            somme = parseFloat(somme).toFixed(2);
            $(".rm_rglmt_solde_disponible").val(somme);
            $(".rest-facture").text(addCommas(parseFloat(somme).toFixed(2)));

            $("#id_added_fac_"+idFactureToRemove).remove();
            $("#id_facture_"+idFactureToRemove).removeClass('hide');


            countTotal();
        }
        return false;
    });
}

function countTotal() {
    
    var montantReglement = Number($('.value-montant').val());
    var rest = Number($('.rest').text());
    var total = 0;
    var tr = $('tbody.default-data').find('tr');
    var nbrFact = 0;
    tr.each(function() {
        var restantDu = $(this).find('.restant_du').text();
        total += Number(restantDu != '' ? restantDu : 0);
        nbrFact ++;
    });
    rest = montantReglement - total;
    $('.total-facture').text(addCommas(parseFloat(total).toFixed(2)) + ' €');

    if(rest < 0) {
        rest = -1 * rest;
    } else {
        rest = 0;
    }
    $('.value-rest').val(parseFloat(rest).toFixed(2));
    $('.rest').text(parseFloat(rest).toFixed(2) + ' €');

    if(nbrFact > 1){
        $(".col_montantLie").removeClass('hide');
    }else{
        $(".col_montantLie").addClass('hide');
    }
}

function initTableFacture(datas, montantlie) {
    $("tbody.default-data").html('<tr class="first-tr"><td colspan="4" class="text-center">Aucune facture liée.</td></tr>');
    if(datas.length >0) {
        if ($('.first-tr').html() != 'undefined') {
            $('.first-tr').remove();
        }
        myFunction(datas, datas.length - 1, montantlie);
    }
    countTotal();

}

function myFunction(datas, index, montantlie) {
    var data = datas[index];
    if (data != 'undefined') {
        var clonedTr = $('table.facture-liee tfoot tr').last().clone();
        var addLine = $('tbody.default-data').append(clonedTr);

        addLine.promise().then(function(e) {
            var i = $('tbody.default-data').find('tr').length;
            var j = i-1;
            var newTr = $('tbody.default-data').find('tr').last();
            newTr.attr('id','id_added_fac_'+data.id);
            newTr.attr('data-id',data.id);
            newTr.find('td.num').text(data.indent);
            newTr.find('td.ht').text(data.total_ht);
            newTr.find('td.ttc').text(data.total_ttc);
            newTr.find('td.restant_du').text(data.reste_du ? data.reste_du : 0);
            newTr.find('td.unity').text('€');
            newTr.find('.removed').attr('id',"id_added_"+data.id)
            newTr.find('.removed').attr('data-id',data.id);
            newTr.find('.facture_id').val(data.id);
            //newTr.find('.facture_id').attr('name', 'devis_factures[_ids][' + j + ']');
            newTr.find('.facture_id').attr('name', 'devis_factures[' + j + '][id]');
            //console.log(montantlie[data.id]+" "+data.id );
            console.log('data.id'+data.id);
            newTr.find('.crm_montantLie').val(montantlie[data.id]);
            newTr.find('.crm_montantLie').attr('data-id',data.id);
            newTr.find('.crm_montantLie').attr('name', 'devis_factures[' + j + '][_joinData][montant_lie]');


            countTotal();
            if(index>0) {
                myFunction(datas, index-1, montantlie);
            }
        });

        //Ne pas afficher la colonne montant lié que lorsqu'on a plus d'une facture
        if($("#id_listeFact tr").length >= 2){
            $(".crm_mtlie").removeClass('hide');
        }
    }
}

$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}


function checkFactureInAddReglement() {
    $('td.kl_cheboxFact').on('change', 'input[type="checkbox"]', function () {

        var nombre = $('table input[type="checkbox"]:checked').length;
        
        if (nombre > 1) {
            $('.montant-lie-value').val(0);
            $('.montant-lie').removeClass('hide');
        } else {
            
            $('.montant-lie').addClass('hide');
            if ($(this).is(':checked')) {
                var tr = $(this).parents('tr');
                var facture = JSON.parse(tr.find('.value-facture').val());
                var montant_lie = $('#montant').val();
                if (facture.total_ttc < montant_lie) {
                    montant_lie = facture.total_ttc;
                }
                tr.find('.montant-lie-value').val(montant_lie);
            } else {
                
                $('.montant-lie-value').val(0);
                $('table input[type="checkbox"]:checked').each(function() { 
               
                    var tr = $(this).parents('tr');
                    var facture = JSON.parse(tr.find('.value-facture').val());
                    var montant_lie = $('#montant').val();
                    if (facture.total_ttc < montant_lie) {
                        montant_lie = facture.total_ttc;
                    }
                    tr.find('.montant-lie-value').val(montant_lie);
                });
            }
        }
        
    });
}