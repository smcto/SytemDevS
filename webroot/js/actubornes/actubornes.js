Dropzone.autoDiscover = false;
$(document).ready(function() {

    $(".select2").select2({
        allowClear: true
    });

    var BASE_URL = $('#id_baseUrl').val();
    $(".dropzone").dropzone({
        url: BASE_URL + "fr/actuBornes/uploadPhotos",
        uploadMultiple: false,
        addRemoveLinks: true,
        success: function (file, result, data) {
            var obj = jQuery.parseJSON(result);
            if (obj.success) {
                var nameFile = obj.name;
                $(file.previewTemplate).append('<input type="hidden" class="" value="' + nameFile + '" name="documents[][nom]" />');
            } else {
                this.removeFile(file);
                alert('Erreur sur la connexion. Veuillez reverifier puis réessayer.');
            }
        },

        removedFile: function (file) {
        },
        init: function () {
            this.on('addedfile', function (file) {
                //alert('init');
                /*if (this.files.length > 2) {
                 this.removeFile(this.files[0]);
                 }*/
                var maxsize = 25 * 1024 * 1024;
                if (file.size > maxsize) {
                    this.removeFile(file);
                    alert('Fichier trop gros. Veuillez réessayer.');
                }
            });
        },
        //acceptedFiles: "image/*",
        acceptedFiles: ".doc, .docx, .odt, .pdf, .png, .jpg, .jpeg",

        dictRemoveFile: "Supprimer",
        dictCancelUpload: "Annuler",
        //dictDefaultMessage:"<span class=''>Ajouter documents</span>"
    });

    //============
    //$('.textarea_editor').wysihtml5();
    $('#contenu').wysihtml5();
    $(".select2Cat").select2();
    var select2CustomEvent = $(".select2CustomEvent").select2();

    $('#categorie_actus_id').on('change', function(){
        var description = categoriedescription[$(this).val()];
        $('#contenu').data("wysihtml5").editor.setValue(description);
    });
});