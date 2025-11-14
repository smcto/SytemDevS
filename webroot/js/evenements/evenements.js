
$(document).ready(function() {

    $('.textarea_editor').wysihtml5({"image": false});
    $('.textarea_editor1').wysihtml5({"image": false});
    $(".select2").select2();


    //===== RESET FORM
    $( "input:reset, button:reset" ).click( function(){
        var form = $(this).closest('form').get(0);
        form.reset();
        var select2s =  $(form).find('.select2');
        $.each(select2s, function (index, elem) {
            var select = $(elem);
            if(index == 0){
                select.attr('disabled', true);
            }
            select.select2();
        });
    });








    $("#date_debut-0").change(function(){
        if(document.getElementById('location_week').checked == true){
            var date_debut = $('#date_debut-0').val();
            var date = new Date(date_debut);
            var date_fin = new Date(date.getTime() + 24*60*60*1000 * 1);

            var dd = date_fin.getDate();
            var mm = date_fin.getMonth()+1;
            var yyyy = date_fin.getFullYear();

            if(parseInt(mm) < 10 && parseInt(dd) < 10) {
                var fin_date = yyyy + '-0' + mm + '-0' + dd;
            }if(parseInt(mm) < 10 && parseInt(dd) >= 10) {
                var fin_date = yyyy + '-0' + mm + '-' + dd;
            }if(parseInt(mm) >= 10 && parseInt(dd) < 10) {
                var fin_date = yyyy + '-' + mm + '-0' + dd;
            }if(parseInt(mm) >= 10 && parseInt(dd) >= 10) {
                var fin_date = yyyy + '-' + mm + '-' + dd;

            }
            $('#date_fin-0').val(fin_date);

            var date_debut_imm = new Date(date.getTime() - 24*60*60*1000 * 1);

            var dd0 = date_debut_imm.getDate();
            var mm0 = date_debut_imm.getMonth()+1;
            var yyyy0 = date_debut_imm.getFullYear();

            if(parseInt(mm0) < 10 && parseInt(dd0) < 10) {
                var deb_date = yyyy0 + '-0' + mm0 + '-0' + dd0;
            }if(parseInt(mm0) < 10 && parseInt(dd0) >= 10) {
                var deb_date = yyyy0 + '-0' + mm0 + '-' + dd0;
            }if(parseInt(mm0) >= 10 && parseInt(dd0) < 10) {
                var deb_date = yyyy0 + '-' + mm0 + '-0' + dd0;
            }if(parseInt(mm0) >= 10 && parseInt(dd0) >= 10) {
                var deb_date = yyyy0 + '-' + mm0 + '-' + dd0;

            }

            $("#date_debut_immobilisation").val(deb_date);



            var date_fin1 = new Date(date.getTime() + 24*60*60*1000 * 2);
            var dd1 = date_fin1.getDate();
            var mm1 = date_fin1.getMonth()+1;
            var yyyy1 = date_fin1.getFullYear();

            if(parseInt(mm1) < 10 && parseInt(dd1) < 10) {
                var fin_date1 = yyyy1 + '-0' + mm1 + '-0' + dd1;
            }if(parseInt(mm1) < 10 && parseInt(dd1) >= 10) {
                var fin_date1 = yyyy1 + '-0' + mm1 + '-' + dd1;
            }if(parseInt(mm1) >= 10 && parseInt(dd1) < 10) {
                var fin_date1 = yyyy1 + '-' + mm1 + '-0' + dd1;
            }if(parseInt(mm1) >= 10 && parseInt(dd1) >= 10) {
                var fin_date1 = yyyy1 + '-' + mm1 + '-' + dd1;

            }
            $('#date_fin_immobilisation').val(fin_date1);
        }

        });
    $("#date_debut_immobilisation").change(function(){
        if(document.getElementById('location_week').checked == true){
            var date_debut = $('#date_debut_immobilisation').val();
            var date = new Date(date_debut);
            var date_fin = new Date(date.getTime() + 24*60*60*1000 * 3);
            var dd = date_fin.getDate();
            var mm = date_fin.getMonth()+1;
            var yyyy = date_fin.getFullYear();

            if(parseInt(mm) < 10 && parseInt(dd) < 10) {
                var fin_date = yyyy + '-0' + mm + '-0' + dd;
            }if(parseInt(mm) < 10 && parseInt(dd) >= 10) {
                var fin_date = yyyy + '-0' + mm + '-' + dd;
            }if(parseInt(mm) >= 10 && parseInt(dd) < 10) {
                var fin_date = yyyy + '-' + mm + '-0' + dd;
            }if(parseInt(mm) >= 10 && parseInt(dd) >= 10) {
                var fin_date = yyyy + '-' + mm + '-' + dd;

            }
            $('#date_fin_immobilisation').val(fin_date);
        }

    });

    $("#location_week").click(function(){
        if(document.getElementById('location_week').checked == true){
            $('#id_type_installation').val(2);
        }
    });




    $("#id_type_installation").change(function(){
        var val = $(this).val();

        if(val == 12 || val == 14){
            $("#id_personne_affecte").removeClass('hide');
            $("#id_personne_affecte select").attr('required', true);
        }else {
            $("#id_personne_affecte").addClass('hide');
            $("#id_personne_affecte select").attr('required', false);
            //$("#id_personne_affecte select").val('');
        }
    });
    $("#desinstallation_id").change(function(){
        var val = $(this).val();

        if(val == 6 || val == 7){
            $("#id_personne_affecte_desinstallation").removeClass('hide');
            $("#id_personne_affecte_desinstallation select").attr('required', true);
        }else {
            $("#id_personne_affecte_desinstallation").addClass('hide');
            $("#id_personne_affecte_desinstallation select").attr('required', false);
            //$("#id_personne_affecte select").val('');
        }
    });
    
    

    $('.kl_daterange_iconPicker').click(function () {
        $(this).closest('.kl_date_block_large').find('input').trigger('click');
    });

    //===== Gestion form PI
    $('.date_evenenement, .date_evenenement_edition').daterangepicker(
        {
            locale: {
                format: 'DD/MM/YYYY',
                applyLabel: 'Valider',
                cancelLabel: 'Annuler'
            },
            autoUpdateInput: false,
            /*startDate: new Date(),
             endDate: new Date()*/
        }
    );

    $('.kl_suppr_date:first').hide();
    $('.kl_suppr_date_edit:first').hide();
    $('#id_add_periode').on('click', function () {

        var clone = $("[id ^='blocDateEvenement']:last").clone();
        //===== gestion titre du form
        var idLast = $("[id ^='blocDateEvenement']:last").attr('id');
        console.log(idLast);
        var idLast = idLast.split('-');
        var numNouv = parseInt(idLast[1]) + 1;

        $(clone).find('.kl_suppr_date').attr('id', "btnSupprDate-" + numNouv);
        clone.find('.kl_suppr_date').show();//=== affichage btn suppr date

        $(clone).find('.kl_suppr_date_edit').attr('id', "btnSupprDate-" + numNouv);
        $(clone).find('.kl_suppr_date_edit').show();

        var inputs = clone.find('input');
        clone.find('button').remove();

        $.each(inputs, function (index, elem) {
            var input = $(elem);
            var id = input.attr('id');
            var ids = id.split('-');
            var num = parseInt(ids[1]);
            var nouvName = "date_evenements[" + (num + 1) + "][" + ids[0] + "]";
            var nouvId = ids[0] + "-" + (num + 1);
            input.attr('id', nouvId);
            input.attr('name', nouvName);
            /*if( (nouvName == "date_evenements[" + (num + 1) + "][dateplanning]")){
             input.removeAttr('name');
             }*/

            if (nouvId === "dateevenement_id-" + (num + 1)) {
                input.remove();
            }
            input.val("");
        });

        $(clone).attr('id', "blocDateEvenement-" + (numNouv));
        clone.insertAfter('.blocDateEvenement:last');
    });

    //==== suppression date dans add
    $(document).on('click', '.kl_suppr_date', function () {
        var id = $(this).attr('id');//alert(id);
        var numDate = id.split('-')['1'];
        $("#blocDateEvenement-" + numDate).hide("blind");
        $("#blocDateEvenement-" + numDate).remove();
    });

    $(document).on('click', '.kl_suppr_date_edit', function () {
        var id = $(this).attr('id');
        console.log(id);
        var numDate = id.split('-')[1];
        var idDate = id.split('-')[2];
        $("#asuppr-" + numDate).val(idDate);
        $("#blocDateEvenement-" + numDate).hide("blind");
        $("#blocDateEvenement-" + numDate).remove();
    });

    //=========== SELECTION CLIENT
    $('.selectpicker').selectpicker();

    var BASE_URL = $('#id_baseUrl').val();
    //==== GESTION LIST CLIENT
    var clientSelect = $('#clients_id');
    var natureSelect = $('#natureEvenement_id');
    $("#type_client_id").change(function() {

        var type_client_id = $("#type_client_id").val();

        $('#clients_id').empty();
        
        $.ajax({
            url: BASE_URL + 'fr/evenements/getListeClient',
            data: {
                type_client_id: type_client_id
            },
            dataType: 'json',
            type: 'post',
            success: function (data) {
                var option = new Option( 'Séléctionner un client', "", true, true);
                clientSelect.append(option);
                
                $.each(data, function (clef, valeur) {
                    var option = new Option(valeur, clef, false, false);
                    clientSelect.append(option);
                });
                clientSelect.prop('disabled', false);
                
            }
        })
        clientSelect.trigger('change');
        $('#natureEvenement_id').empty();

        $.ajax({
            url: BASE_URL + 'fr/evenements/getListeNature',
            data: {
                type_client_id: type_client_id
            },
            dataType: 'json',
            type: 'post',
            success: function (data) {
                var option = new Option( 'Séléctionner une option', "", true, true);
                natureSelect.append(option);

                $.each(data, function (clef, valeur) {
                    var option = new Option(valeur, clef, false, false);
                    natureSelect.append(option);
                });
                natureSelect.prop('disabled', false);

            }
        })
        natureSelect.trigger('change');
    });

    var devisSelect = $('#devisSelect');
    $("#clients_id").change(function(){
        var clientId  = $("#clients_id").val();
        devisSelect.empty();
        if(clientId != null){
            $.ajax({
                url: BASE_URL + 'fr/documents/devis/'+clientId,
                dataType: 'json',
                type: 'GET',
                success: function(data){
                    $.each(data, function (k, valeur) {
                        var option = new Option(valeur.objet, valeur.id, false, false);
                        devisSelect.append(option);
                    });

                }
            });
        }
        devisSelect.trigger('change');
    });



    var borneSelect = $('#borne_id');
    $("#antenne_id").change(function() {
        var antenne_id = $("#antenne_id").val();
        $('#borne_id').empty();

        $.ajax({
            url: BASE_URL + 'fr/evenements/getListeBorne',
            data: {
                antenne_id: antenne_id
            },
            dataType: 'json',
            type: 'post',
            success: function (data) {
                var option = new Option( 'Séléctionner un borne', "", true, true);
                borneSelect.append(option);

                $.each(data, function (clef, valeur) {
                    var option = new Option(valeur, clef, false, false);
                    borneSelect.append(option);
                });
                borneSelect.prop('disabled', false);

            }
        });
        borneSelect.trigger('change');
    });


    //======= Envoi email recap edition
    if($("#type_client_id :selected").val() == "2"){
        $("#envoyer_recap").attr('checked', true);
        $(".envoyer_recap").removeClass('hide');



    }

    //========== NOM EVENT PRE-REMPLI
    $("#type_client_id").change(function() {
		// Particulier
        if($(this).val() != 2){
            $('#nom_event').val('');
        };
        //======= Envoi email recap add
        if($("#type_client_id :selected").val() == "2"){
            $("#location_week").attr('checked', true);
            $('#id_type_installation').val(2);
            $("#envoyer_recap").attr('checked', true);
            $("#publication_fb").prop('checked', false);
            $(".envoyer_recap").removeClass('hide');
			
			$('#id_type_installation').val(11);
			$('#desinstallation_id').val(5);
			$('#id_type_installation').trigger('change');
			$('#desinstallation_id').trigger('change');
        }
        if($("#type_client_id :selected").val() == "1"){
            $("#location_week").attr('checked', false);
            $("#envoyer_recap").attr('checked', false);
			$("#publication_fb").prop('checked', false);
            $(".envoyer_recap").addClass('hide');
			
			$('#id_type_installation').val(12);
			$('#desinstallation_id').val(6);
			$('#id_type_installation').trigger('change');
			$('#desinstallation_id').trigger('change');
        }
		
    });
	
	$('#publication_fb').on('change', function(){
		if($(this).prop('checked')){
			$("#nom_fb").parent().parent().removeClass('hide');
		}else{
			$("#nom_fb").parent().parent().addClass('hide');
		}
	});
	$('#publication_fb').trigger('change');

    $("#type_event").change(function() {
        var type_client_id = $("#type_client_id").val();
        if (type_client_id == 2) {
            $('#nom_event').val('');
            if($('#clients_id :selected').val() !== '' && $(this).val() !== '') {
                var nom_event_auto = $('#type_event :selected').text() + " - " + $('#clients_id :selected').text();
                $('#nom_event').val(nom_event_auto);
            }
        }
    });

    $("#clients_id").change(function() {
        if($('#type_event :selected').val() != '') {
            var type_client_id = $("#type_client_id").val();
            if (type_client_id == 2) {
                $('#nom_event').val('');
                if($('#clients_id :selected').val() !== '' && $(this).val() !== '') {
                    var nom_event_auto = $('#type_event :selected').text() + " - " + $('#clients_id :selected').text();
                    $('#nom_event').val(nom_event_auto);
                }
            }
        }
    });
});