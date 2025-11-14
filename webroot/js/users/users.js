$(document).ready(function() {

    //=========== FILTRE
    var BASE_URL = $('#id_baseUrl').val();
    $("#antenne_id").change(function(){
        var type_profil = $("#type_profil :selected").val();
        var key = $("#key").val();
        var group_user = $("#group_user").val();
        var antenne = $(this).val();
        window.location =  BASE_URL+"fr/users/index/"+group_user+"?key="+key+"&typeprofil="+type_profil+"&antenne="+antenne;
    });

    $('.textarea_editor').wysihtml5({"image": false});
    $(".select2").select2();

    //===== NUM PHONE
    //$('#phonecode').val($.trim($("#pays_id :selected").text().split('  ')[1]));
    $('#phonecode').val("+" + $("#pays_id :selected").attr('data-id'));
    $('#pays_id').change(function () {
        $('#phonecode, #telephone_portable_id, #telephone_fixe_id').val('');
        //var code = $("#pays_id :selected").text().split('  ')[1];
        var code = $("#pays_id :selected").attr('data-id');
        if(code != undefined) {
            $('#phonecode').val($.trim("+" + code));
            $('#telephone_portable_id, #telephone_fixe_id').val($.trim("+" + code));
        }
    });

    $("#type_profil").change(function () {
        var vals = $(this).val();
        console.log(vals);

        if(jQuery.inArray("6", vals) !== -1 || jQuery.inArray("5", vals) !== -1 ){ //  Livreur
            $(".livreur").removeClass('hide');
            $(".infos_livreur").removeClass('hide');
            //$(".livreur input").attr('required', true);
        } else {
            $(".livreur").addClass('hide');
            $(".infos_livreur").addClass('hide');
            //$(".livreur input").attr('required', false);
        }

        if(jQuery.inArray("4", vals) !== -1 || jQuery.inArray("5", vals) !== -1 || jQuery.inArray("7", vals) !== -1){ //
            $(".antenne").removeClass('hide');
            $(".infos_antenne").removeClass('hide');
            $(".infos_antenne #antenne_ids").attr('required',true);
            $(".select2").select2();
            if(jQuery.inArray("4", vals) !== -1){
                $(".niveau_tech_info, .description_niveau_tech_info").removeClass('hide');
            }
            if(jQuery.inArray("5", vals) !== -1){
                $(".niveau_tech_info, .description_niveau_tech_info").removeClass('hide');
            }
        } else {
            $(".antenne").addClass('hide');
            $(".infos_antenne").addClass('hide');
            $(".infos_antenne #antenne_ids").attr('required',false);
            if(jQuery.inArray("4", vals) == -1){
                $(".niveau_tech_info, .description_niveau_tech_info").addClass('hide');
                $(".niveau_tech_info, .description_niveau_tech_info").val('')
            }
            if(jQuery.inArray("5", vals) == -1) {
                $(".niveau_tech_info, .description_niveau_tech_info").addClass('hide');
                $(".niveau_tech_info").val('');
                $(".niveau_tech_info, .description_niveau_tech_info").val('');
            }
            $("#antenne_ids").val('');
        }

        if(jQuery.inArray("8", vals) !== -1){ //
            $(".fournisseur").removeClass('hide');
            $(".infos_fournisseur").removeClass('hide');
        }else {
            $(".fournisseur").addClass('hide');
            $(".infos_fournisseur").addClass('hide');
            $("#fournisseur_id").val('');
        }

        if(jQuery.inArray("9", vals) !== -1){ //
            $(".client").removeClass('hide');
            $(".infos_client").removeClass('hide');
        }else {
            $(".client").addClass('hide');
            $(".infos_client").addClass('hide');
            $("#client_id").val('');
        }

        if(jQuery.inArray("2", vals) !== -1){ // konitys
            $(".konitys").removeClass('hide');
            $(".infos_konitys").removeClass('hide');
        } else {
            $(".konitys").addClass('hide');
            $(".infos_konitys").addClass('hide');
        }

        if(jQuery.inArray("3", vals) !== -1){ // konitys
            $(".konitys").removeClass('hide');
            $(".infos_konitys").removeClass('hide');
        } else {
            $(".konitys").addClass('hide');
            $(".infos_konitys").addClass('hide');
        }
    });

    $('#password_visible').keyup(function () {
        var pwdvisible = $(this).val();
        $('#password').val(pwdvisible);
    });

    $('#id_email').keyup(function () {
        var email_val = $(this).val();
        $('#id_login').val(email_val);
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
    })

    //== affiche 3 champs si véhiculé
    if($("#is_vehicule").prop('checked')){
        $("#choix_modele_vehicule").show();
        $("#choix_nbr_transportable_vehicule").show();
        $("#choix_comnt_vehicule").show();

    } else {
        $("#choix_modele_vehicule").hide();
        $("#choix_nbr_transportable_vehicule").hide();
        $("#choix_comnt_vehicule").hide();
    }
    $("#is_vehicule").click(function () {

        if($(this).prop('checked')){

            $("#choix_modele_vehicule ").show();
            $("#choix_nbr_transportable_vehicule").show();
            $("#choix_comnt_vehicule ").show();
        } else {

            $("#choix_modele_vehicule").hide();
            $("#choix_nbr_transportable_vehicule").hide();
            $("#choix_comnt_vehicule").hide();
        }
    });


    $("#suppr_photo_user").click(function () {
        //alert('');
        var supp = confirm('Vouler vous supprimer le photo ?');
        if(supp){
            alert('');s
        }
    });
});