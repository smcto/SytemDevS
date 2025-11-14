$(document).ready(function() {
    var BASE_URL = $('#id_baseUrl').val();

    $(".dropzone").dropzone({
        url: BASE_URL + 'fr/factures/uploadFile',
        uploadMultiple: false,
        addRemoveLinks: true,
        maxFiles: 2,
        success: function (file, result, data) {
            var obj = jQuery.parseJSON(result);
            if (obj.success) {
                var nameFile = obj.name;
                $(file.previewTemplate).append('<input type="hidden" class="" value="' + nameFile + '" name="fichiers[][nom]" />');
            } else {
                this.removeFile(file);
                alert('Erreur sur la connexion. Veuillez reverifier puis réessayer.');
            }
        },

        removedFile: function (file) {
        },
        init: function () {
            this.on('addedfile', function (file) { alert('');
                if (this.files.length > 2) {
                    this.removeFile(this.files[0]);
                }
                var maxsize = 25 * 1024 * 1024;
                if (file.size > maxsize) {
                    this.removeFile(file);
                    alert('Fichier trop gros. Veuillez réessayer.');
                }
            });
        },
        //acceptedFiles : "image/!*",
        acceptedFiles: ".png, .jpg, .jpeg",

        dictRemoveFile: "Supprimer",
        dictCancelUpload: "Annuler",
        dictDefaultMessage: "<span class='kl_parcourir'>Facture</span>",
    });


    $(".kl_deletePjEdit").click(function () {
        var idTodelete = $(this).attr('id').slice(6);
        var theInput = '<input type="checkbox" name="pjToDelete[]" value="' + idTodelete + '" checked />';
        $(".kl_listePjToDelete").append(theInput);
        $(".kl_thePjEdit_" + idTodelete).hide();

    });
});