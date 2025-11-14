var URL_BASE;
Dropzone.autoDiscover = false;

$(document).ready(function () {

    $(".select2").select2();
    $('.selectpicker').selectpicker();
       
    var BASE_URL = $('#base_url').val();

    // ==== Duplication form contact
    $('.kl_trash:first').hide();
    $('.btnSupprEdit:first').show();

    var BASE_URL = $('#id_baseUrl').val();
    var catalog_produit_id = $('#catalog_produit_id').val();
    
    $("#id_dropzone").dropzone({
        url: BASE_URL + "fr/catalog-produits/uploadPhotos",
        uploadMultiple: false,
        addRemoveLinks: true,
        success: function (file, result, data) {
            var obj = jQuery.parseJSON(result);
            if (obj.success) {
                var nameFile = obj.name;
                $(file.previewTemplate).append('<input type="hidden" class="" value="' + nameFile + '" name="photos[][nom]" />');
            } else {
                this.removeFile(file);
                alert('Erreur sur la connexion. Veuillez reverifier puis réessayer.');
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
                if (catalog_produit_id !== '') {
                    $(".dropzone").append('<input type="hidden" class="" value="' + file.name + '" name="documents_a_suppr[][nom]" />');
                }
            });

            if (catalog_produit_id !== '') {
                var thisDropzone = this;
                var idFiles = [];
                var titreFiles = [];
                var urlFiles = [];
                
                $.getJSON(BASE_URL + "fr/catalog-produits/getFichiers/" + catalog_produit_id, function (data) {
                    $.each(data, function (key, value) {
                        var mockFile = {name: value.name, size: value.size};
                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                        var urlFile = BASE_URL + "uploads/catalogue_produits/" + value.name;
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
                    var btn_supprs = $('#id_dropzone').find('a.dz-remove');
                    $.each(btn_supprs, function (key, elem) {
                        var a = $(elem);
                        a.attr('id', 'file_' + idFiles[key]);
                        var btn_view_file = '<a class="dz-remove" href="' + urlFiles[key] + '" target="_blank">Visualiser</a>';
                        $(btn_view_file).insertBefore(a);
                    });
                });
            }
        },
        //acceptedFiles: "image/*",
        acceptedFiles: ".doc, .docx, .odt, .pdf, .png, .jpg, .jpeg",
        dictRemoveFile: "Supprimer",
        dictCancelUpload: "Annuler",
    });
    
    
    // Objet du document
    $('.textarea_editor').tinymce({
        language: 'fr_FR',
        menubar: false,
        plugins: ['advlist autolink link imagetools spellchecker lists autoresize'],        
        toolbar: 'bold italic underline strikethrough |bullist numlist | link removeformat ',
        relative_urls : false,
        contextmenu: false,
        remove_script_host : false,
        convert_urls : false,
        branding: false,
        statusbar: false,
      });
      
      
    // Ajout multi categorie / sous catégorie
    var defaultData = $('div.default-data');
    var trLength = defaultData.find('.ligne').length-1;
    $('.add-data').unbind('click');
    $('.add-data').click(function(event) {
        cloned = $('.row.clone').last().clone();
        defaultData.append(cloned).promise().then(function (e) {
            newRow = defaultData.find('.row.added-tr').last();
            newRow.find('[input-name="catalog_category_id"] , [input-name="catalog_sous_category_id"]').attr('required', 'required');
            var newTrIndRow = eval(newRow.index()+trLength);
            newRow.find("input[input-name] , select[input-name]").each(function(index, el) {
                $(this).attr('name', 'catalog_produits_has_categories'+'['+newTrIndRow+']['+$(this).attr('input-name')+']');
            });
            newRow.removeClass('d-none');
        });
    });
    
    $('.dropify').dropify();
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
    
    


    function removeProd() {
        defaultData.on('click', '#remove-prod', function(event) {
            event.preventDefault();
            currentRow = $(this).parents('.row').first();
            nbTr = defaultData.find('.row').length;
            if (nbTr == 1) {
                alert('Cette ligne ne peut pas être supprimée');
                return false;
            }

            if (confirm('Êtes vous sûr de vouloir supprimer?')) {
                url = $(this).attr('data-href');

                if (url) {
                    $.get(url, function(data, xhr) {
                        if (data.status == 'success') {
                            currentRow.remove();
                        }
                    });
                } else {
                    currentRow.remove();
                }
            }
        });
    }
    removeProd();

    $('.categories-container .default-data').on('change', '#catalog-category-id', function(event) {
        event.preventDefault();
        categoryId = $(this).val();
        currentTrow = $(this).parents('.row').first();

        sousCategoryId = currentTrow.find('#catalog-sous-category-id');
        emptyOption = sousCategoryId.find('option[value=""]').text();
        $.get(baseUrl+'fr/ajax-catalog-produits/getCatalogSousCategories/'+categoryId, function(data) {

            var option = new Option(emptyOption, "", true, true);
            sousCategoryId.html('');
            sousCategoryId.append(option);
                
            $.each(data, function (key, value) {
                var option = new Option(value, key, false, false);
                sousCategoryId.append(option);
            });
        });
    }); 

    $('.categories-container .default-data').on('change', '#catalog-sous-category-id', function(event) {
        event.preventDefault();
        sousCategoryId = $(this).val();
        currentTrow = $(this).parents('.row').first();

        sousSousCategoryId = currentTrow.find('#catalog-sous-sous-category-id');
        emptyOption = sousSousCategoryId.find('option[value=""]').text();
        $.get(baseUrl+'fr/CatalogSousSousCategories/getSousSousCategoriesBySousCategoryId/'+sousCategoryId, function(data) {

            var option = new Option(emptyOption, "", true, true);
            sousSousCategoryId.html('');
            sousSousCategoryId.append(option);
                
            $.each(data, function (key, value) {
                var option = new Option(value, key, false, false);
                sousSousCategoryId.append(option);
            });
        });
    }); 
    
});

function hideShowClass(c, r) {
    if (r == 1) {
        $('.' + c).removeClass('hide');
        $('.b-' + c).addClass('hide');
    } else {
        $('.' + c).addClass('hide');
        $('.b-' + c).removeClass('hide');
        $('#debut-2-' + c).val('');
        $('#fin-2-' + c).val('');
    }
}
