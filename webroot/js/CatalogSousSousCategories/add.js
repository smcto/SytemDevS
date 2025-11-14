$('[name="catalog_category_id"]').on('changed.bs.select', function(event) {
    event.preventDefault();

    catalog_category_id = $(this).val();
    select = $('[name="catalog_sous_category_id"]');
    emptyOption = select.find('option[value=""]').text();
    
    $.get(baseUrl+'fr/CatalogSousSousCategories/getSousCategoryByCategoryId/'+catalog_category_id, function(data) {

        // after ajax callback
        var option = new Option(emptyOption, "", true, true);
        select.html('');
        select.append(option);
            
        $.each(data, function (key, value) {
            var option = new Option(value, key, false, false);
            select.append(option);
        });

        
        select.selectpicker('refresh');
    });
});