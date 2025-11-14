var BASE_URL = "";
Dropzone.autoDiscover = false;
$(function () {
    
    $(".select2").select2();

    $('.textarea_editor').wysihtml5({"image": false});

    $("#id_addColor").click(function(){
        var key = Math.random().toString(36).substr(2, 9);
        var newColor = '<div class="row" id="id_OneAddedColor_'+key+'">'+
                        	'<div class="col-md-10 p-r-0"><div class="form-group"><input name="couleur_possibles['+key+'][couleur]" maxlength="45" id="couleur-possibles-0-couleur" class="form-control" type="text"></div></div>'+
                        	'<div class="col-md-2 p-l-0">'+
                        		'<button type="button" class="btn btn-danger kl_deleteAdded" id="id_addedColor_'+key+'"><i class="ti-minus  text"></i></button>'+
                        	'</div>'+
                        '</div>';
        $("#id_listeColor").append(newColor);
    });
    
    $( "#id_listeColor" ).on( "click", ".kl_deleteAdded", function() {
      var key = $(this).attr('id').slice(14);
      $("#id_OneAddedColor_"+key).remove();
    });
    
    //var myDropzone = new Dropzone("#myDrop", { url: "/file/post"});
    var BASE_URL = $('#id_baseUrl').val();
    var modelborne_id = $('#modelborne_id').val();
    var i = 0;
    $(".dropzone").dropzone({
        url: BASE_URL + "fr/posts/uploadDocuments",
        addRemoveLinks: true,
        success: function (file, result, data) {
            var obj = jQuery.parseJSON(result);
            if (obj.success) {
                var nameFile = obj.name;
                $(file.previewTemplate).append('<input type="hidden" class="" value="' + nameFile + '" name="photo_illustrations[' + i + '][nom]" />');
                $(file.previewTemplate).append('<input type="hidden" class="" value="' + obj.name_origine + '" name="photo_illustrations[' + i + '][nom_origine]" />');
            } else {
                this.removeFile(file);
                alert('Erreur sur la connexion. Veuillez reverifier puis réessayer.');
            }
            i += 1;
        },

        removedFile: function (file) {
        },
        init: function () {
            this.on('addedfile', function (file) {
                //alert('init');
                /*if (this.files.length > 2) {
                 this.removeFile(this.files[1]);
                 }*/
                var maxsize = 25 * 1024 * 1024;
                if (file.size > maxsize) {
                    this.removeFile(file);
                    alert('Fichier trop gros. Veuillez réessayer.');
                }
            });

            this.on('removedfile', function (file) {
                if(modelborne_id !== '') {
                    $(".dropzone").append('<input type="hidden" class="" value="' + file.name + '" name="photo_illustrations_a_suppr[][nom]" />');
                } else {
                    $.getJSON(BASE_URL + "fr/posts/deleteFile/" + newFilename, function (data) {
                    });
                }
            });

            if(modelborne_id !== '') {
                var thisDropzone = this;
                var idFiles = [];
                var titreFiles = [];
                var urlFiles = [];
                $.getJSON(BASE_URL + "fr/model-bornes/getFichiers/"+modelborne_id, function (data) {
                    $.each(data, function (key, value) {
                        //alert(value.name);
                        var mockFile = {name: value.name, size: value.size };
                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, BASE_URL + "uploads/model_bornes/" + value.name);
                        $('.dz-preview .dz-image img').css({"width":"128", "height":"128"});
                        idFiles[key] = value.id;
                        titreFiles[key] = value.name_origine;
                        urlFiles[key] = value.url;
                    });

                    console.log(idFiles);
                    var btn_supprs = $('.dropzone').find('a.dz-remove');
                    $.each(btn_supprs, function (key, elem) {
                        var a = $(elem);
                        a.attr('id', 'file_'+ idFiles[key]);
                        var btn_view_file = '<a class="dz-remove" href="'+urlFiles[key]+'" target="_blank">Visualiser</a>';
                        $(btn_view_file).insertBefore(a);
                    });
                });
            }
        },
        acceptedFiles: "image/*",

        dictRemoveFile: "Supprimer",
        dictCancelUpload: "Annuler",
        //dictDefaultMessage:"<span class=''>Ajouter documents</span>"
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

    //===== GESTION DOCUMENTS
    $('.kl_suppr_doc:first').hide();
    $('.kl_suppr_doc_edit:first').hide();
    $('#id_add_doc').on('click', function () {

        var clone = $("[id ^='gestionDocuments']:last").clone();
        //===== gestion titre du form
        var idLast = $("[id ^='gestionDocuments']:last").attr('id');
        console.log(idLast);
        var idLast = idLast.split('-');
        var numNouv = parseInt(idLast[1]) + 1;

        $(clone).find('.kl_suppr_doc').attr('id', "btnSupprDoc-" + numNouv);
        clone.find('.kl_suppr_doc').show();//=== affichage btn suppr date

        $(clone).find('.kl_suppr_doc_edit').attr('id', "btnSupprDoc-" + numNouv);
        $(clone).find('.kl_suppr_doc_edit').show();

        var inputs = clone.find('input');
        var textareas = clone.find('textarea');
        clone.find('button').remove();

        var inputFileName = "";
        var inputFileId = "";
        $.each(inputs, function (index, elem) {
            var input = $(elem);
            var id = input.attr('id');
            var ids = id.split('-');
            var num = parseInt(ids[2]);
            var nouvName = ids[0]+"[" + (num + 1) + "][" + ids[1] + "]";
            var nouvId = ids[0] +"-" + ids[1] + "-"+ (num + 1);
            input.attr('id', nouvId);
            input.attr('name', nouvName);
            /*if (nouvId === "dateevenement_id-" + (num + 1)) {
                input.remove();
            }*/
            input.val("");
            if(input.attr('type') === "file"){
                inputFileName = nouvName;
                inputFileId = nouvId;
            }
        });

        $.each(textareas, function (index, elem) {
            var input = $(elem);
            var id = input.attr('id');
            var ids = id.split('-');
            var num = parseInt(ids[2]);
            var nouvName = ids[0]+"[" + (num + 1) + "][" + ids[1] + "]";
            var nouvId = ids[0] +"-" + ids[1] + "-"+ (num + 1);
            input.attr('id', nouvId);
            input.attr('name', nouvName);
            input.val("");
        });

        clone.find('.bloc_dropify').remove();

        $(clone).attr('id', "gestionDocuments-" + (numNouv));
        clone.insertAfter('.gestionDocuments:last');
        var inputFileNouv = '<div class="col-md-3 bloc_dropify"><label>Fichier :</label></label><input type="file" class="dropify" name="' + inputFileName + '" id="' + inputFileId + '" data-height="100"></div>';
        $(inputFileNouv).insertBefore(".bloc_titre:last");
        $('.dropify').dropify();
    });

    //==== suppression date dans add
    $(document).on('click', '.kl_suppr_doc', function () {
        var id = $(this).attr('id');//alert(id);
        var numDate = id.split('-')['1'];
        $("#gestionDocuments-" + numDate).hide("blind");
        $("#gestionDocuments-" + numDate).remove();
    });

    $(document).on('click', '.kl_suppr_doc_edit', function () {
        var id = $(this).attr('id');
        console.log(id);
        var numDate = id.split('-')[1];
        var idDate = id.split('-')[2];
        if(confirm("Are you want to delete ?")) {
            $("#asuppr-" + numDate).val(idDate);
            $("#gestionDocuments-" + numDate).hide("blind");
            $("#gestionDocuments-" + numDate).remove();
        }
    });
});

$(document).ready(function($) {
    
    var base_url = $('#id_baseUrl').val();
    var modelborne_id = $('#modelborne_id').val();
    
    $('#gamme-borne-id').on('change', function(event) {
        event.preventDefault();
        gamme_borne_id = $(this).val();

        urlLoadEquipementFromGammeBorne = base_url+'/fr/ajax-ventes/loadEquipementFromGammeBorne/'+gamme_borne_id;
        $.get(urlLoadEquipementFromGammeBorne, function(dataEquipement) {
            $('select#pied-id').html(dataEquipement);
            $('select#pied-id').selectpicker('refresh');
        });

        var url = base_url + 'fr/ajax-model-bornes/equipement-by-gamme/' + gamme_borne_id + '/' + modelborne_id;
        $.get(url, function(data, xhr) {
            $(".equipements").html(data);
        });
        
    });
    
    $('#gamme-borne-id').trigger('change');
});