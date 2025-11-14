$(document).ready(function (){
    
    // bug ne garde pas le focus sur sous-category lors du filtre
    // $('#categorie_id').on('change', function(){
    //     var categorie_id = $(this).val();
    //     var liste_sous_categorie = catalogSousCategories[categorie_id];
    //     var option = '<option value>Sous catégorie</option>';
    //     $.each(liste_sous_categorie, function(key, value){
    //             option += '<option value="'+key+'">'+value+'</option>';
    //     });
    //     $('#sous_categorie').html(option);
    // });
    // $('#categorie_id').trigger('change');
    // 
    
    $('.filtre-produits').on('change', '#categorie_id', function(event) {
        event.preventDefault();
        categoryId = $(this).val();
        currentTrow = $(this).parents('.row').first();

        sousCategoryId = currentTrow.find('#sous_categorie');
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
    
    $('#sous_categorie').on('change', function(event) {
        event.preventDefault();
        sousCategoryId = $(this).val();
        data = sous_sous_categorie[sousCategoryId];

        sousSousCategory = $('#sous-sous-categorie');
        var option = new Option("Toutes les sous sous catégories", "", false, false);
        sousSousCategory.html('');
        sousSousCategory.append(option);

        $.each(data, function (key, value) {
            if(key == sous_sous_cat_val) {
                option = new Option(value, key, true, true);
            } else {
                option = new Option(value, key, false, false);
            }
            sousSousCategory.append(option);
        });
    }); 
    
    $('#sous_categorie').trigger('change');
});
