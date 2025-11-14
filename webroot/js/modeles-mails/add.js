Dropzone.autoDiscover = false;
$(document).ready(function () {
    /*$('.textarea_editor').summernote({
        height: '100%',   //set editable area's height
        lang: 'fr-FR',
        toolbar: [
            ['style', ['bold', 'italic', 'link', 'ul']]
        ],
    });*/

    tinymce.init({
        selector: '.textarea_editor',
        language: 'fr_FR',
        menubar: false,
        plugins: 'preview  emoticons searchreplace autolink directionality visualblocks visualchars fullscreen  link   template  table charmap hr pagebreak nonbreaking anchor  insertdatetime advlist lists  wordcount  imagetools textpattern noneditable help charmap quickbars code',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist  | forecolor backcolor casechange   removeformat  | fullscreen |  pageembed link table | code',
        relative_urls : false,
        remove_script_host : false,
        convert_urls : false,
        branding: false,
    });
    
    var BASE_URL = $('#id_baseUrl').val();
    var modeles_mails_id = $('#modeles_mails_id').val();
    
    $("#id_dropzone_pj").dropzone({
        url: BASE_URL + "fr/modeles-mails/upload-pjs",
        uploadMultiple: false,
        addRemoveLinks: true,
        thumbnailWidth: null,
        thumbnailHeight: null,
        maxFiles: 100,
        parallelUploads: 100,
        acceptedFiles: ".doc, .docx, .odt, .pdf, .png, .jpg, .jpeg",
        dictRemoveFile: "Supprimer",
        dictCancelUpload: "Annuler",
        dictInvalidFileType: "Vous ne pouvez pas importez ce type de fichier",
        success: function (file, result, data) {
            var obj = jQuery.parseJSON(result);
            if (obj.success) {
                var nameFile = obj.name;
                if (obj.type_upload == "mail_pj") {
                    $(file.previewTemplate).append('<input type="hidden" class="" value="' + nameFile + '" name="models_mails_pjs[][nom]" />');
                }
            } else {
                this.removeFile(file);
                if(obj.error) {
                    alert(obj.error);
                }else {
                    alert('Erreur sur la connexion. Veuillez reverifier puis réessayer.');
                }
            }
        },

        init: function () {
            this.on("sending", function (file, xhr, formData) {
                source = $($(this)[0].element);
                var type_upload = source.attr('data-owner');
                formData.append("type_upload", type_upload);
            });

            this.on('addedfile', function (file) {
                var maxsize = 25 * 1024 * 1024;
                if (file.size > maxsize) {
                    this.removeFile(file);
                    alert('Fichier trop gros. Veuillez réessayer.');
                }
            });

            //==== edition img
            this.on('removedfile', function (file) {
                if (modeles_mails_id !== '') {
                    $(".dropzone").append('<input type="hidden" class="" value="' + file.name + '" name="documents_a_suppr[]" />');
                }
            });

            if (modeles_mails_id !== '') {
                var thisDropzone = this;
                var idFiles = [];
                var titreFiles = [];
                var urlFiles = [];
                
                $.getJSON(BASE_URL + "fr/modeles-mails/get-pjs/" + modeles_mails_id, function (data) {
                    $.each(data, function (key, value) {
                        //console.log(value);
                        var mockFile = {name: value.name, size: value.size};
                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                        var urlFile = BASE_URL + "uploads/pjs/" + value.name;
                        var url = urlFile;
                        if (value.extension === "pdf") {
                            urlFile = BASE_URL + "img/img_pdf.png";
                        }
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, urlFile);
                        $('.dz-preview .dz-image img').css({"width": "128", "height": "128"});
                        idFiles[key] = value.id;
                        titreFiles[key] = value.name_origine;
                        urlFiles[key] = url;
                    });

                    console.log(idFiles);
                    var btn_supprs = $('#id_dropzone_pj').find('a.dz-remove');
                    $.each(btn_supprs, function (key, elem) {
                        var a = $(elem);
                        a.attr('id', 'file_' + idFiles[key]);
                        var btn_view_file = '<a class="dz-remove" href="' + urlFiles[key] + '" target="_blank">Visualiser</a>';
                        $(btn_view_file).insertBefore(a);
                    });
                });
            }
        },
    });
});

