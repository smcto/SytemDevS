Dropzone.autoDiscover = false;
$(document).ready(function() {

    var BASE_URL = $('#id_baseUrl').val();
    var post_id = $('#post_id').val();
    var i = 0;
    $('.dz-preview .dz-image img').css({"width":"128", "height":"128"});
        $(".dropzone").dropzone({
            url: BASE_URL + "fr/posts/uploadDocuments",
            addRemoveLinks: true,
            success: function (file, result, data) {
                var obj = jQuery.parseJSON(result);
                newFilename = obj.name;
                if (obj.success) {
                    var nameFile = obj.name;
                    $(file.previewTemplate).append('<input type="hidden" class="" value="' + nameFile + '" name="documents[' + i + '][nom]" />');
                    $(file.previewTemplate).append('<input type="hidden" class="" value="' + obj.name_origine + '" name="documents[' + i + '][nom_origine]" />');
                } else {
                    this.removeFile(file);
                    alert('Erreur sur la connexion. Veuillez reverifier puis réessayer.');
                }
                i += 1;
            },

            init: function (file) {

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

                this.on('removedfile', function (file) {
                    if(post_id !== '') {
                       //alert(file.name);
                        $(".dropzone").append('<input type="hidden" class="" value="' + file.name + '" name="documents_a_suppr[][nom]" />');
                    } else {
                        $.getJSON(BASE_URL + "fr/posts/deleteFile/" + newFilename, function (data) {
                        });
                    }
                });

                if(post_id !== '') {
                    var thisDropzone = this;
                    var idFiles = [];
                    var titreFiles = [];
                    var urlFiles = [];
                    $.getJSON(BASE_URL + "fr/posts/getFichiers/"+post_id, function (data) {
                        $.each(data, function (key, value) {
                            //console.log(value);
                            var mockFile = {name: value.name, size: value.size };
                            thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                            var urlFile = BASE_URL + "uploads/documentations/" + value.name;
                            var url = value.url;
                            //console.log(urlFile);
                            if(value.extension === "pdf"){
                                urlFile = BASE_URL + "img/img_pdf.png";
                                url = value.url_viewer;
                            }
                            thisDropzone.options.thumbnail.call(thisDropzone, mockFile, urlFile);
                            $('.dz-preview .dz-image img').css({"width":"128", "height":"128"});
                            idFiles[key] = value.id;
                            titreFiles[key] = value.name_origine;
                            //urlFiles[key] = value.url_viewer;
                            urlFiles[key] = url;
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
            acceptedFiles: ".doc, .docx, .pdf, .png, .jpg, .jpeg, '.PNG', '.JPG', '.JPEG",

            dictRemoveFile: "Supprimer",
            dictCancelUpload: "Annuler",
            //dictDefaultMessage:"<span class=''>Ajouter documents</span>"
    });

    /*$(".dropzone").delegate(".dz-remove", "click", function () {
        var idFile = $(this).attr('id').split('_')[1];
        alert(idFile);
        if(idFile !== "undefined") {
            $.getJSON(BASE_URL + "fr/posts/deleteFichier/" + idFile, function (data) {
                alert(data.success);
            });
        }
    });*/

    //============
    $('.textarea_editor').wysihtml5();
    $(".select2Cat").select2();
    var select2CustomEvent = $(".select2CustomEvent").select2();

    //==== Ne plus ulitilser
    /*$("#id_statuChange").change(function(){
        var valueStatut = $(this).val();
        if(valueStatut =="private"){
            $(".kl_visiblepar").addClass('hide');
            select2CustomEvent.val(null).trigger("change");
        }else{
            $(".kl_visiblepar").removeClass('hide');
        }
    });
    
    //Par d�faut c'est invisble mais pour garder l'affichage du plugn on fat cette action ici'''
    $(".kl_visiblepar").addClass('hide');
    //Pour l'�dition
    var valueStatut = $("#id_statuChange").val();
    if(valueStatut =="private"){
        $(".kl_visiblepar").addClass('hide');
        select2CustomEvent.val(null).trigger("change");
    }else{
        $(".kl_visiblepar").removeClass('hide');
    }*/

    var BASE_URL = $('#id_baseUrl').val();

});