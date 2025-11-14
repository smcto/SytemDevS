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

$(document).ready(function() {
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

    //===== NUM PHONE
    $('#phonecode').val($.trim($("#country_id :selected").text().split('  ')[1]));
    $('#country_id').change(function () {
        var code = $("#country_id :selected").text().split('  ')[1];
        //alert();
        $('#phonecode').val($.trim(code));
        //$('#telephone_portable, #telephone_fixe').val($.trim(code));
    });
});